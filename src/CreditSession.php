<?php

namespace Hanoivip\PaymentMethodCredit;

use Hanoivip\PaymentMethodContract\IPaymentSession;
use stdClass;

class CreditSession implements IPaymentSession
{
    /**
     * 
     * @var array
     */
    private $info;
    /**
     * 
     * @var stdClass
     */
    private $trans;
    
    public function __construct($trans, $balanceInfo)
    {
        $this->trans = $trans;
        $this->info = $balanceInfo;    
    }
    
    public function getSecureData()
    {}

    public function getGuide()
    {
        return __('hanoivip::credit.guide');
    }

    public function getData()
    {
        return $this->info;
    }
    
    public function getTransId()
    {
        return $this->trans->trans_id;
    }
    
}