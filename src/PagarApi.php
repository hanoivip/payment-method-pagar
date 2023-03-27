<?php

namespace Hanoivip\PaymentMethodPagar;

use PagarMe\Client as PagarMeClient;

class PagarApi implements IHelper
{
    private $pagarme;
    
    public function __construct($cfg)
    {
        $this->pagarme = new PagarMeClient($cfg['private_key']);
    }
    
    public function fetch($ref)
    {
        return $this->pagarme->transactions()->get([
            'id' => $ref
        ]);
    }

    public function create($merchantRef, $channel, $cinfo, $billing, $shipping, $item, $param)
    {
        $p = array_merge([
            'amount' => intval($item['item_price']),
            'payment_method' => $channel,
            'items' => [
                [
                    'id' => '1',
                    'title' => $item['item'],
                    'unit_price' => $item['item_price'],
                    'quantity' => 1,
                    'tangible' => true
                ]
            ],
            'postback_url' => route('pagar.callback'),
        ], $param);
        $p = array_merge($p, ['customer' => $cinfo]);
        $p = array_merge($p, ['billing' => $billing]);
        $p = array_merge($p, ['shipping' => $shipping]);
        $trans = $this->pagarme->transactions()->create($p);
        return $trans;
    }

    public function setConfig($cfg)
    {}

}
