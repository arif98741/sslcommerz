<?php
/**
 * @author: Mahabubul Hasan <codehasan@gmail.com>
 * Date: 8/28/2018
 * Time: 3:44 PM
 */

namespace Xenon\SslCommerz;


use GuzzleHttp\Exception\GuzzleException;
use Xenon\SslCommerz\Contracts\OrderValidationRequestInterface;
use Xenon\SslCommerz\Exceptions\RequestParameterMissingException;
use Xenon\SslCommerz\Traits\RequestValidatorTrait;

class OrderValidationRequest implements OrderValidationRequestInterface
{
    use RequestValidatorTrait;

    /**
     * @var array
     */
    private $_required = [
        self::VAL_ID,
        self::STORE_ID,
        self::STORE_PASSWORD
    ];
    /**
     * @var array
     */
    private $_errors = [];
    /**
     * @var array
     */
    private $_fields = [];
    /**
     * @var bool
     */
    private $_validated = false;

    /**
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->_fields = $fields;
    }

    /**
     * @throws RequestParameterMissingException
     * @throws GuzzleException
     * @throws \JsonException
     */
    function send($isSandbox = false)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $param = '?';
        foreach ($this->values() as $k => $v) {
            $param .= $k . '=' . $v . '&';
        }
        $param .= 'v=1&format=json';
        $resp = $client->get($this->getApiUrl($isSandbox) . $param);
        return new OrderValidationResponse($resp->getBody()->getContents());
    }

    /**
     * @param $isSandbox
     * @return string
     */
    public function getApiUrl($isSandbox = false): string
    {
        if ($isSandbox) {
            return 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php';
        }

        return 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';
    }

}
