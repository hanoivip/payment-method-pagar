<?php

namespace Hanoivip\PaymentMethodPagar;

use Hanoivip\PaymentMethodContract\IPaymentResult;

class PagarResult implements IPaymentResult
{
    private $detail;
    
    private $channelInstruct;
    
    function __construct($PagarTrans, $instructions = null)
    {
        $this->detail = $PagarTrans;
        $this->channelInstruct = $instructions;
    }
    public function getDetail()
    {

    }

    public function toArray()
    {
        $arr = [];
        $arr['detail'] = $this->getDetail();
        $arr['amount'] = $this->getAmount();
        $arr['isPending'] = $this->isPending();
        $arr['isFailure'] = $this->isFailure();
        $arr['isSuccess'] = $this->isSuccess();
        $arr['trans'] = $this->getTransId();
        return $arr;
    }

    public function isPending()
    {
        return $this->detail['status'] == 'UNPAID';
    }

    public function isFailure()
    {
        return $this->detail['status'] == 'CANCEL';
    }

    public function getTransId()
    {
        return $this->detail['merchant_ref'];
    }

    public function isSuccess()
    {
        return $this->detail['status'] == 'PAID';
    }

    public function getAmount()
    {
        return $this->detail['amount'];
    }

}