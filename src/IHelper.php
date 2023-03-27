<?php

namespace Hanoivip\PaymentMethodPagar;

interface IHelper
{
    public function setConfig($cfg);
    
    public function create($merchantRef, $channel, $cinfo, $billing, $shipping, $item, $param);
    
    public function fetch($ref);
}