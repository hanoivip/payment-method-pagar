<?php

namespace Hanoivip\PaymentMethodPagar;

use Hanoivip\PaymentMethodContract\IPaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Hanoivip\IapContract\Facades\IapFacade;

class PagarMethod implements IPaymentMethod
{
    private $config;
    
    private $helper;
    
    public function __construct(IHelper $helper)
    {
        $this->helper = $helper;
    }
    
    public function endTrans($trans)
    {
    }

    public function cancel($trans)
    {
    }

    public function beginTrans($trans)
    {
        $exists = PagarTransaction::where('trans', $trans->trans_id)->get();
        if ($exists->isNotEmpty())
            throw new Exception('Pagar transaction existed!');
        $channels = [];
        $log = new PagarTransaction();
        $log->trans = $trans->trans_id;
        $log->save();
        $cinfo = [];
        $billing = [];
        $shipping = [];
        $param = [];
        // load customer, billing, shipping, cards info - if any
        $userId = Auth::user()->getAuthIdentifier();
        $customer = Customer::where('user_id', $userId)->first();
        if (empty($customer))
        {
            $customer = new Customer();
            $customer->user_id = $userId;
            $customer->info = json_encode([]);
            $customer->billing = json_encode([]);
            $customer->shipping = json_encode([]);
            $customer->param = json_encode([]);
            $customer->save();
        }
        else 
        {
            $cinfo = json_decode($customer->info, true);
            $billing = json_decode($customer->billing, true);
            $shipping = json_decode($customer->shipping, true);
            $param = json_decode($customer->param, true);
            //if (empty($cinfo)) $cinfo = session()->get('info', []);
            //if (empty($billing)) $billing = session()->get('billing', []);
            //if (empty($shipping)) $shipping = session()->get('shipping', []);
            //if (empty($card)) $card = session()->get('card', []);
        }
        return new PagarSession($trans, $channels, $cinfo, $billing, $shipping, $param);
    }
    
    private function getCustomer($params)
    {
        $userId = Auth::user()->getAuthIdentifier();
        return [
                'external_id' => $userId,
                'name' => $params['customer_name'],
                'type' => 'individual',
                'country' => 'br',
                'documents' => [
                    [
                        'type' => $params['customer_doc_type'],
                        'number' => $params['customer_doc_number'],
                    ]
                ],
                'phone_numbers' => [ $params['customer_phone'] ],
                'email' => $params['customer_email']
            ];
    }
    
    private function getBilling($params)
    {
        return [
                'name' => 'Nome do pagador',
                'address' => [
                    'country' => 'br',
                    'street' => 'Avenida Brigadeiro Faria Lima',
                    'street_number' => '1811',
                    'state' => 'sp',
                    'city' => 'Sao Paulo',
                    'neighborhood' => 'Jardim Paulistano',
                    'zipcode' => '01451001'
                ]
            ];
    }
    
    private function getShipping($params)
    {
        return [
            'name' => 'Nome de quem receberá o produto',
            'fee' => 1,
            'delivery_date' => date("Y-m-d"),
            'expedited' => false,
            'address' => [
                'country' => 'br',
                'street' => 'Avenida Brigadeiro Faria Lima',
                'street_number' => '1811',
                'state' => 'sp',
                'city' => 'Sao Paulo',
                'neighborhood' => 'Jardim Paulistano',
                'zipcode' => '01451001'
                ]
            ];
    }
    
    private function getCredit($params)
    {
        return [
            'card_holder_name' => $params['credit_holder'],
            'card_cvv' => $params['credit_ccv'],
            'card_number' => $params['credit_number'],
            'card_expiration_date' => $params['credit_expire'],
        ];
    }

    public function request($trans, $params)
    {
        Log::error(print_r($params, true));
        if (!isset($params['channel']))
        {
            return new PagarFailure($trans, __('pagar::pagar.invalid-request'));
        }
        $channel = $params['channel'];// credit pix boleto split
        $log = PagarTransaction::where('trans', $trans->trans_id)->first();
        $info = $this->getCustomer($params);
        $billing = $this->getBilling($params);
        $shipping = $this->getShipping($params);
        // validate params
        // ...
        // get 
        $userId = Auth::user()->getAuthIdentifier();
        $customer = Customer::where('user_id', $userId)->first();
        $order = $trans->order;
        $orderDetail = IapFacade::detail($order);
        $this->helper->setConfig($this->config);
        try {
            $param = [];
            switch ($channel)
            {
                case 'credit': $param = $this->getCredit($params);
            }
            // save user input
            $customer->info = json_encode($info);
            $customer->billing = json_encode($billing);
            $customer->shipping = json_encode($shipping);
            $p = json_decode($customer->param, true);
            $customer->param = array_merge($p, [$channel => $param]);
            $customer->save();
            // invoke service
            $result = $this->helper->create($trans->trans_id, $channel, $info, $billing, $shipping, $orderDetail, $param);
            Log::error("Pagar result: " . print_r($result, true));
            if (gettype($result) == 'string')
            {
                return new PagarFailure($trans, $result);
            }
            // save transaction
            $log->channel = $channel;
            $log->result = json_encode($result);
            $log->save();
            return new PagarResult($result);
        } catch (Exception $ex) {
            Log::error("Pagar create transaction error: " . $ex->getMessage());
            Log::error(">>>>>>>> " . $ex->getTraceAsString());
            return new PagarFailure($trans, __('pagar::pagar.exception'));
        }
    }

    public function query($trans, $force = false)
    {
        $log = PagarTransaction::where('trans', $trans->trans_id)->first();
        if (empty($log))
        {
            return new PagarFailure($trans, __('pagar::pagar.failure.error'));
        }
        try
        {
            $oldDetail = json_decode($log->result, true);
        }
        catch (Exception $ex)
        {
            Log::error("Pagar query transaction exception " . $ex->getMessage());
        }
        return new PagarResult($oldDetail);
    }

    public function config($cfg)
    {
        $this->config = $cfg;
    }
    public function validate($params)
    {
        return false;
    }
    
}