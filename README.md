# MbSupport

Support classes for Mb libraries.

### ApiResponse

Class for formatting basic API responses.

Available methods:

```
response($closure);

load($data, $payloadKey = null);

setSuccess($success, $msg = null);

setMsg($msg);

setTotal($total);

setPayloadKey($payloadKey);

setResults($value, $total = 0);

setException($e, $success = 0);

setExceptionCallback($exceptionCallback);

toArray();

toJson($options = 0);
```

Example usage:

```
$apiResponse = new \MbSupport\ApiResponse;

// Load results
$apiResponse->load(['foo' => 1, 'bar' => 2]);

// toJson() returns: "{"success":1,"msg":"","total":2,"results":{"foo":1}}"
$apiResponse->toJson();

...

// Override the default payload key named 'results'
$apiResponse->load(['foo' => 1], 'data');

// toJson() returns: "{"success":1,"msg":"","total":1,"data":{"foo":1}}"
$apiResponse->toJson();

```

Setting and exception sets the success to <code>0</code> for you:

```
$apiResponse->setException($e);

// toJson() returns: "{"success":0,"msg":"Test Exception in Foo.php: eval()'d code on line 1","total":0}"
$apiResponse->toJson();
```

### ResettableTrait

Trait to add a reset method that resets properties to their initial values.

Available methods
```
reset();
```

To exclude any properties add a <code>$notResettable</code> array property with the properties to exclude:

```

class Foo
{
    protected $resetMe;
    protected $dontResetme;
    protected $notResettable = ['dontResetme'];

    use \MbSupport\ResettableTrait;

    ...
}
```

