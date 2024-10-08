<?php
/**
 * Created by PhpStorm.
 * User: Mahabubul Hasan
 * Date: 8/28/2018
 * Time: 1:04 PM
 */

namespace Xenon\SslCommerz\Traits;


use Xenon\SslCommerz\Exceptions\RequestParameterMissingException;

trait RequestValidatorTrait
{
    function getErrors()
    {
        return $this->_errors;
    }

    function values()
    {
        if (!$this->_validated && !$this->isValid()) {
            throw new RequestParameterMissingException();
        }

        return $this->_fields;
    }

    function isValid()
    {
        return !$this->_hasError($this->_fields);
    }

    private function _hasError(array $fields)
    {
        $keys = array_keys($fields);
        $required_keys = array_flip($this->_required);

        $hasError = false;
        foreach ($this->_required as $v) {
            if (!in_array($v, $keys)) {
                $this->_errors[] = $required_keys[$v] . ' field is required';
                $hasError = true;
            }
        }
        $this->_validated = true;
        return $hasError;
    }
}
