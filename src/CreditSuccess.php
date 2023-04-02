<?php

namespace Hanoivip\PaymentMethodCredit;

use Hanoivip\PaymentMethodContract\IPaymentResult;

class CreditSuccess implements IPaymentResult
{
    private $amount;
    private $trans;
    
    public function __construct($trans, $amount)
    {
        $this->trans = $trans;
        $this->amount = $amount;    
    }
    
    public function getDetail()
    {
        return __('hanoivip.credit::credit.success', ['amount' => $this->amount]);
    }

    public function isPending()
    {
        return false;
    }

    public function isFailure()
    {
        return false;
    }

    public function isSuccess()
    {
        return true;
    }

    public function getAmount()
    {
        return $this->amount;
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
    
    public function getTransId()
    {
        return $this->trans->trans_id;
    }
    
    public function getCurrency()
    {
        return 'webcoin';
    }
    
}