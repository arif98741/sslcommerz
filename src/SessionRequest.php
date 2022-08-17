<?php
/**
 * @author: Mahabubul Hasan <codehasan@gmail.com>
 * Date: 8/28/2018
 * Time: 12:58 PM
 */

namespace Xenon\SslCommerz;


use GuzzleHttp\Exception\GuzzleException;
use Xenon\SslCommerz\Contracts\SessionRequestInterface;
use Xenon\SslCommerz\Exceptions\RenderException;
use Xenon\SslCommerz\Exceptions\RequestParameterMissingException;
use Xenon\SslCommerz\Traits\RequestValidatorTrait;

class SessionRequest implements SessionRequestInterface
{
    use RequestValidatorTrait;

    private $_required = [
        self::STORE_ID,
        self::STORE_PASSWORD,
        self::TOTAL_AMOUNT,
        self::CURRENCY,
        self::TRANSACTION_ID,
        self::SUCCESS_URL,
        self::FAIL_URL,
        self::CANCEL_URL,
        self::EMI,
        self::CUSTOMER_NAME,
        self::CUSTOMER_EMAIL,
        self::CUSTOMER_PHONE,
    ];
    private $_errors = [];
    private $_fields = [];
    private $_validated = false;

    /**
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->_fields = $fields;
    }

    /**
     * @param bool $isSandbox
     * @return SessionResponse
     * @throws RequestParameterMissingException
     * @throws GuzzleException
     * @throws RenderException
     */
    function send($isSandbox = false)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);
        try {
            $resp = $client->request('POST', $this->getApiUrl($isSandbox), ['form_params' => $this->values()]);
        } catch (GuzzleException $e) {
            throw new RenderException($e->getMessage());
        }

        return new SessionResponse($resp->getBody()->getContents());
    }

    /**
     * @param bool $isSandbox
     * @return string
     */
    public function getApiUrl($isSandbox = false)
    {
        if ($isSandbox) {
            return 'https://sandbox.sslcommerz.com/gwprocess/v3/api.php';
        }

        return 'https://securepay.sslcommerz.com/gwprocess/v3/api.php';
    }


}
