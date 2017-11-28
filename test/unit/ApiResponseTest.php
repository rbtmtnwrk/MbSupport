<?php

class ApiResponseTest extends TestCase
{
    protected $helper;

    public function setUp()
    {
        parent::setUp();
    }

    public function test_it_returns_an_array()
    {
        $expected = [
            'success' => 1,
            'msg'     => '',
            'total'   => 0,
            'code'    => 0,
            'results' => [],
        ];

        $apiResponse = new \MbSupport\ApiResponse;
        $apiResponse->setResults([]);

        $this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_it_returns_json()
    {
        $expected = [
            'success' => 1,
            'msg'     => '',
            'total'   => 0,
            'code'    => 0,
            'results' => [],
        ];

        $apiResponse = new \MbSupport\ApiResponse;
        $apiResponse->setResults([]);

        $this->assertEquals($apiResponse->toJson(), json_encode($expected));
    }

    public function test_the_format_of_the_exception_message()
    {
        $file = __FILE__;

        // Keep next 3 lines together!
		$line      = __LINE__ + 2;
		$msg       = 'Error';
		$exception = new \Exception($msg);
        // Ok safe now.

        $expected = $msg . ' thrown in ' . $file . ' on line ' . $line;

        $apiResponse = new \MbSupport\ApiResponse;
        $this->assertEquals($expected, $apiResponse->formatExceptionMessage($exception));
    }

    public function test_it_sets_an_exception()
    {
		$exception   = new \Exception('Test');
        $apiResponse = new \MbSupport\ApiResponse;

        $expected = [
            'success' => 0,
            'msg'     => $apiResponse->formatExceptionMessage($exception),
            'total'   => 0,
            'code'    => 0,
        ];

        $this->assertEquals($apiResponse->setException($exception)->toArray(), $expected);
    }

    public function test_it_calls_the_exception_callback()
    {
        $exception   = new \Exception('Test');
        $apiResponse = new \MbSupport\ApiResponse;
        $result      = (object) [
            'called'    => false,
            'msg'       => null,
            'exception' => null,
        ];
        $callback    = function($msg, $e) use (&$result) {
            $result->called    = true;
            $result->msg       = $msg;
            $result->exception = $e;
        };

        $apiResponse->setExceptionCallback($callback);
        $apiResponse->setException($exception);

        $this->assertEquals(true, $result->called);
        $this->assertEquals($apiResponse->formatExceptionMessage($exception), $result->msg);
        $this->assertEquals('Exception', get_class($result->exception));
    }

    public function test_results_and_success_is_settable()
    {
		$success  = 0;
        $msg      = 'Foobar.';
        $total    = 1;
        $results  = ['foo' => 'bar'];

        $expected = [
            'success' => $success,
            'msg'     => $msg,
            'total'   => $total,
            'code'    => 0,
            'results' => $results,
        ];

        $apiResponse = new \MbSupport\ApiResponse;
        $apiResponse->setSuccess($success, $msg);
        $apiResponse->setResults($results, $total);

        $this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_it_can_set_msg()
    {
        $msg      = 'Foobar';
        $expected = [
            'success' => 1,
            'msg'     => $msg,
            'total'   => 0,
            'code'    => 0,
        ];
    	$apiResponse = new \MbSupport\ApiResponse;
    	$apiResponse->setMsg($msg);

    	$this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_it_can_set_total()
    {
        $total    = 1;
        $expected = [
            'success' => 1,
            'msg'     => '',
            'total'   => $total,
            'code'    => 0,
        ];
    	$apiResponse = new \MbSupport\ApiResponse;
    	$apiResponse->setTotal($total);

    	$this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_it_can_set_payload_key()
    {
        $expected = [
            'success' => 1,
            'msg'     => '',
            'total'   => 1,
            'code'    => 0,
            'data'    => ['test' => 1]
        ];
        $apiResponse = new \MbSupport\ApiResponse;
        $apiResponse->setPayloadKey('data')->setResults(['test' => 1]);

        $this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_it_loads()
    {
        $expected = [
            'success' => 1,
            'msg'     => '',
            'total'   => 1,
            'code'    => 0,
            'data'    => ['test' => 1]
        ];
        $apiResponse = new \MbSupport\ApiResponse;
        $apiResponse->load(['test' => 1], 'data');

        $this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_response_closure()
    {
        $this->apiResponse = new \MbSupport\ApiResponse;
        $test = 'foo';

        $apiResponse = $this->apiResponse->response(function() use($test) {
            return $this->apiResponse->setResults($test);
        });

        $expected = [
            'success' => 1,
            'msg'     => '',
            'total'   => 1,
            'code'    => 0,
            'results' => $test,
        ];

        $this->assertEquals($expected, $apiResponse->toArray());
    }

    public function test_it_sets_a_code()
    {
        $apiResponse = new \MbSupport\ApiResponse;

        $apiResponse->setResponseCode(1);

        $this->assertEquals(1, $apiResponse->toArray()['code']);
    }
}

/* End of file */
