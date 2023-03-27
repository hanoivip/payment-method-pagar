<?php

namespace Hanoivip\PaymentMethodPagar;

use Hanoivip\PaymentMethodContract\IPaymentSession;

class PagarSession implements IPaymentSession
{
    private $trans;
    
    private $channels;
    
    public function __construct($trans, $channels)
    {
        $this->trans = $trans;
        $this->channels = $channels;
    }
    
    public function getSecureData()
    {}
    
    public function getGuide()
    {
        return __('pagar::pagar.guide');
    }
    
    public function getData()
    {
        return $this->channels;
    }
    
    public function getTransId()
    {
        return $this->trans->trans_id;
    }
    
}