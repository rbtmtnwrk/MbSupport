<?php

namespace MbSupport;

interface ApiResponseInterface
{
    /**
     * Convert response array to its json string representation.
     *
     * @return string
     */
    public function __toString();

    public function response($closure);

    public function load($data, $payloadKey = null);

    public function setSuccess($success, $msg = null);

    public function setMsg($msg);

    public function setTotal($total);

    public function setPayloadKey($payloadKey);

    public function setResults($value, $total = 0);

    public function setException($e, $success = 0);

    public function toArray();

    public function toJson($options = 0);
}

/* End of file */
