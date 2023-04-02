<?php

namespace Hanoivip\PaymentMethodPagar;

use Hanoivip\PaymentMethodContract\IPaymentResult;

class PagarFailure implements IPaymentResult
{
    private $detail;
    
    private $error;

    function __construct($PagarTrans, $error)
    {
        $this->detail = $PagarTrans;
        $this->error = $error;
    }
    
    public function getDetail()
    {
        return $this->error;
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
        $arr['currency'] = $this->getCurrency();
        return $arr;
    }

    public function isPending()
    {
        return false;
    }

    public function isFailure()
    {
        return true;
    }

    public function getTransId()
    {
        return $this->detail['data']['merchant_ref'];
    }

    public function isSuccess()
    {
        return false;
    }

    public function getAmount()
    {
        return 0;
    }
    
    public function getCurrency()
    {
        return 'BRL';
    }


}