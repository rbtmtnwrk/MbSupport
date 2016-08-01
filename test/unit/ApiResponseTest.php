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

        $in = ' in ' . $file . ' on line ' . $line;

        $apiResponse = new \MbSupport\ApiResponse;
        $this->assertEquals($msg . $in, $apiResponse->formatExceptionMessage($exception));
    }

    public function test_it_sets_an_exception()
    {
		$exception   = new \Exception('Test');
        $apiResponse = new \MbSupport\ApiResponse;

        $expected = [
            'success' => 0,
            'msg'     => $apiResponse->formatExceptionMessage($exception),
            'total'   => 0,
        ];

        $this->assertEquals($apiResponse->setException($exception)->toArray(), $expected);
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
            'results' => $test,
        ];

        $this->assertEquals($expected, $apiResponse->toArray());
    }
}

/* End of file */
