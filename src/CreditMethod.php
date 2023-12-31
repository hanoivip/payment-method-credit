<?php

namespace Hanoivip\PaymentMethodCredit;

use Hanoivip\PaymentMethodContract\IPaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Hanoivip\Payment\Facades\BalanceFacade;
use Hanoivip\Shop\Facades\OrderFacade;
use Exception;

class CreditMethod implements IPaymentMethod
{
    public function endTrans($trans)
    {}

    public function cancel($trans)
    {}

    public function beginTrans($trans)
    {
        $uid = Auth::user()->getAuthIdentifier();
        $balances = BalanceFacade::getInfo($uid);
        $info = [];
        foreach ($balances as $bal)
        {
            $i = new \stdClass();
            $i->type = __('hanoivip.credit::credit.type.' . $bal->balance_type);
            $i->balance = $bal->balance;
            $info[] = $i;
        }
        return new CreditSession($trans, $info);
    }

    public function request($trans, $params)
    {
        $uid = Auth::user()->getAuthIdentifier();
        $order = $trans->order;
        $orderDetail = OrderFacade::detail($order);
        $amount = $orderDetail->price;
        $currency = $orderDetail->currency;
        if (!BalanceFacade::enough($uid, $amount, 0, $currency))
        {
            Log::error("CreditMethod user not enough credit");
            return new CreditFailure($trans, __('hanoivip.credit::credit.failure.not-enough'));
        }
        if (!BalanceFacade::remove($uid, $amount, "CreditMethod", 0, $currency))
        {
            return new CreditFailure($trans, __('hanoivip.credit::credit.failure.fail-to-charge'));
        }
        return new CreditSuccess($trans, $amount, $currency);
    }

    public function query($trans, $force = false)
    {}

    public function config($cfg)
    {}
    
    public function validate($params)
    {
        return true;
    }
    
    public function openPendingPage($trans)
    {
        throw new Exception("Pay with credit is never pending.");
    }
    
    public function openPaymentPage($transId, $guide, $session)
    {
        return view('hanoivip.credit::payment', ['trans' => $transId, 'guide' => $guide, 'data' => $session]);
    }
    
}