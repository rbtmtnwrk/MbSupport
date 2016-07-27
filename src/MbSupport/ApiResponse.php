<?php

namespace MbSupport;

class ApiResponse implements ApiResponseInterface
{
    protected $payloadKey = 'results';

    protected $response = [
        'success' => 1,
        'msg'     => '',
        'total'   => 0,
    ];

    /**
     * Convert response array to its json string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    public function __construct()
    {
    }

    public function setSuccess($success, $msg = null)
    {
        $this->response['success'] = $success;
        if ($msg) {
            $this->response['msg'] = $msg;
        }

        return $this;
    }

    public function setMsg($msg)
    {
        $this->response['msg'] = $msg;

        return $this;
    }

    public function setTotal($total)
    {
        $this->response['total'] = $total;

        return $this;
    }

    public function setResults($value, $total = 1)
    {
        $this->response[$this->payloadKey] = $value;
        $this->response['total'] = $total;

        if (is_array($value)) {
            $this->response['total'] = count($value);
        }

        return $this;
    }

    public function setPayloadKey($payloadKey)
    {
        if (! empty($this->response[$this->payloadKey])) {
            $this->response[$payloadKey] = $this->response[$this->payloadKey];
            unset($this->response[$this->payloadKey]);
        }

        $this->payloadKey = $payloadKey;

        return $this;
    }

    public function setException($e, $success = 0)
    {
        $this->response['success'] = $success;
        $this->response['msg'] = $this->formatExceptionMessage($e);

        return $this;
    }

    public function formatExceptionMessage($e)
    {
        return $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine();
    }

    public function toArray()
    {
        return $this->response;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->response, $options);
    }

    public function response($closure)
    {
        try {
            return $closure();
        } catch (\Exception $e) {
            return $this->setException($e);
        }
    }
}

/* End of file */
