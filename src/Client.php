<?php
/**
 * @author: Mahabubul Hasan <codehasan@gmail.com>
 * Date: 8/29/2018
 * Time: 1:15 PM
 */

namespace Xenon\SslCommerz;


use GuzzleHttp\Exception\GuzzleException;
use Xenon\SslCommerz\Exceptions\RenderException;
use Xenon\SslCommerz\Exceptions\RequestParameterMissingException;

class Client
{
    /**
     * @param Customer $customer
     * @param $amount
     * @param array $config
     * @return SessionResponse
     * @throws Exceptions\RequestParameterMissingException
     * @throws RenderException
     */
    public static function initSession(Customer $customer, $amount, array $config = [])
    {
        $data[SessionRequest::STORE_ID] = config('sslcommerz.store_id');
        $data[SessionRequest::STORE_PASSWORD] = config('sslcommerz.store_password');
        $data[SessionRequest::TOTAL_AMOUNT] = $amount;
        $data[SessionRequest::CURRENCY] = config('sslcommerz.currency');;
        $data[SessionRequest::TRANSACTION_ID] = "TRANSACTION_" . uniqid();
        $data[SessionRequest::SUCCESS_URL] = config('sslcommerz.success_url');
        $data[SessionRequest::FAIL_URL] = config('sslcommerz.fail_url');
        $data[SessionRequest::CANCEL_URL] = config('sslcommerz.cancel_url');
        $data[SessionRequest::EMI] = '0';
        $data[SessionRequest::CUSTOMER_NAME] = $customer->getName();
        $data[SessionRequest::CUSTOMER_EMAIL] = $customer->getEmail();
        $data[SessionRequest::CUSTOMER_PHONE] = $customer->getPhone();

        $request = new SessionRequest(array_merge($data, $config));
        try {
            $resp = $request->send(config('sslcommerz.sandbox_mode'));

        } catch (GuzzleException $e) {
            throw new RenderException($e->getMessage());
        }

        if ($resp->getStatus() === 'FAILED') {
            throw new RenderException($resp->getFailureReason() . '. Check your environment data');
        }

        $resp->setTransactionId($data[SessionRequest::TRANSACTION_ID]);//important
        return $resp;
    }

    /**
     * @param $valId
     * @return OrderValidationResponse
     * @throws RenderException|\JsonException
     */
    public static function verifyOrder($valId)
    {
        $data[OrderValidationRequest::VAL_ID] = $valId;
        $data[OrderValidationRequest::STORE_ID] = config('sslcommerz.store_id');
        $data[OrderValidationRequest::STORE_PASSWORD] = config('sslcommerz.store_password');

        try {
            return (new OrderValidationRequest($data))->send(config('sslcommerz.sandbox_mode'));
        } catch (GuzzleException|RequestParameterMissingException $e) {
            throw new RenderException($e->getMessage());
        }
    }
}
