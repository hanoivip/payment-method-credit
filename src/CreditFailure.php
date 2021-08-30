<?php

namespace Hanoivip\PaymentMethodCredit;

use Hanoivip\PaymentMethodContract\IPaymentResult;

class CreditFailure implements IPaymentResult
{
    private $message;
    private $trans;
    
    public function __construct($trans, $message)
    {
        $this->trans = $trans;
        $this->message = $message;
    }
    public function getDetail()
    {
        return $this->message;
    }

    public function isPending()
    {
        return false;
    }

    public function isFailure()
    {
        return true;
    }

    public function isSuccess()
    {
        return false;
    }

    public function getAmount()
    {
        return 0;
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

    public function getTransId()
    {
        return $this->trans->trans_id;
    }


    
}