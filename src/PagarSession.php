<?php

namespace Hanoivip\PaymentMethodPagar;

use Hanoivip\PaymentMethodContract\IPaymentSession;

class PagarSession implements IPaymentSession
{
    private $trans;
    
    private $channels;
    
    private $customer;
    
    private $billing;
    
    private $shipping;
    
    private $param;
    
    public function __construct($trans, $channels, $cinfo, $billing, $shipping, $param)
    {
        $this->trans = $trans;
        $this->channels = $channels;
        $this->customer = $cinfo;
        $this->billing = $billing;
        $this->shipping = $shipping;
        $this->param = $param;
    }
    
    public function getSecureData()
    {
        return [];
    }
    
    public function getGuide()
    {
        return __('hanoivip.pagar::pagar.guide');
    }
    
    public function getData()
    {
        return ['customer' => $this->customer, 'billing' => $this->billing, 
            'shipping' => $this->shipping, 'param' => $this->param ];
    }
    
    public function getTransId()
    {
        return $this->trans->trans_id;
    }
    
}