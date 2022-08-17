<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xenon\SslCommerz\Client;
use Xenon\SslCommerz\Exceptions\RenderException;
use Xenon\SslCommerz\IpnNotification;


class SslCommerzController extends Controller
{

    /**
     * @param Request $request
     * @return void
     * @throws RenderException
     */
    public function success(Request $request)
    {
        //response from sslcommerz if success(Demo Data)
        /**Demo Data
         * "tran_id" => "TRANSACTION_62fb770427d8d"
         * "val_id" => "2208161655090CGIT4FEuG0ByQd"
         * "amount" => "29.00"
         * "card_type" => "BKASH-BKash"
         * "store_amount" => "28.28"
         * "card_no" => null
         * "bank_tran_id" => "220816165509mwGvpGF84bJfJvR"
         * "status" => "VALID"
         * "tran_date" => "2022-08-16 16:55:03"
         * "currency" => "BDT"
         * "card_issuer" => "BKash Mobile Banking"
         * "card_brand" => "MOBILEBANKING"
         * "card_issuer_country" => "Bangladesh"
         * "card_issuer_country_code" => "BD"
         * "store_id" => "media5f62f70a14c0a"
         * "verify_sign" => "728d7179e79c28de9aea033c52602144"
         * "verify_key" => "amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_type,currency,currency_amount,currency_rate,curre ▶"
         * "verify_sign_sha2" => "b9fcd9fb7c1935e218d14ee1e1449915610235b3e7c5021ef9c0531b1e179ee2"
         * "currency_type" => "BDT"
         * "currency_amount" => "29.00"
         * "currency_rate" => "1.0000"
         * "base_fair" => "0.00"
         * "value_a" => null
         * "value_b" => null
         * "value_c" => null
         * "value_d" => null
         * "risk_level" => "0"
         * "risk_title" => "Safe"
         */

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        try {
            $resp = Client::verifyOrder($request->val_id);
            //$resp->getStatus();
            //$resp->getTransactionId();
            //todo:: do whatever you want. it's totally depend on you

        } catch (\JsonException|RenderException $e) {
            throw new RenderException($e->getMessage());
        }


    }

    /**
     * @param Request $request
     * @return void
     */
    public function fail(Request $request)
    {

        //response from sslcommerz due to fail(Demo Data)
        /**
         * "tran_id" => "TRANSACTION_62fb778bc2727"
         * "error" => "system error: (unable to process transaction request)"
         * "status" => "FAILED"
         * "key" => "amount=29.00&bank_tran_id=2208161657240oxFXBuOVTQ3Q03&base_fair=0.00&card_brand=MOBILEBANKING&card_issuer=BKash Mobile Banking&card_issuer_country=Bangladesh&ca ▶"
         * "pass" => "media5f62f70a14c0a@ssl"
         * "bank_tran_id" => "2208161657240oxFXBuOVTQ3Q03"
         * "currency" => "BDT"
         * "tran_date" => "2022-08-16 16:57:19"
         * "amount" => "29.00"
         * "store_id" => "media5f62f70a14c0a"
         * "card_type" => null
         * "card_no" => null
         * "card_issuer" => "BKash Mobile Banking"
         * "card_brand" => "MOBILEBANKING"
         * "card_issuer_country" => "Bangladesh"
         * "card_issuer_country_code" => "BD"
         * "currency_type" => "BDT"
         * "currency_amount" => "29.00"
         * "currency_rate" => "1.0000"
         * "base_fair" => "0.00"
         * "value_a" => null
         * "value_b" => null
         * "value_c" => null
         * "value_d" => null
         * "verify_sign" => "d98371e7231df9d13a9380588c5dc8fe"
         * "verify_sign_sha2" => "ae20ad542f41f278dc871eb4995cc3d7ff33e9b048b65e84dcf5351f7a86180b"
         * "verify_key" => "amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_type,currency,currency_amount,currency_rate,curr
         */
        $tran_id = $request->input('tran_id');
        if ($request->status == 'FAILED') {

            //TODO:: Do whatever you want due to failed transaction
            $status = $request->status;
        }


    }

    /**
     * @param Request $request
     * @return void
     */
    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        //todo:: do whatever you want
    }

    /**
     * @param Request $request
     * @return array
     * @throws RenderException
     * @throws \JsonException
     */
    public function ipn(Request $request)
    {
        /**
         * This is a ipn response method. When you customer will click pay button in sslcommerz then he/she will
         * get ip request in your website. This ipn request is handled from here.
         * Ipn request should be outside csrf-verification rule. For doing this add ipn url in except list
         * in App/Http/Middleware/VerifyCsrfToken middleware
         */
        if (ipn_hash_varify(config('sslcommerz.store_password'))) {
            $ipn = new IpnNotification($_POST);
            $val_id = $ipn->getValId();
            $transaction_id = $ipn->getTransactionId();
            $amount = $ipn->getAmount();
            $resp = Client::verifyOrder($val_id);
            return [
                'val_id' => $val_id,
                'transaction_id' => $transaction_id,
                'amount' => $amount,
                'resp' => $resp,
            ];
        }
    }

}
