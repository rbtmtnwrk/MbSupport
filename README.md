# MbSupport

Support classes for Mb libraries.

###ApiResponse

Class for formatting basic API responses.

Available methods:

```
response($closure);

setSuccess($success, $msg = null);

setMsg($msg);

setTotal($total);

setPayloadKey($payloadKey);

setResults($value, $total = 0);

setException($e, $success = 0);

toArray();

toJson($options = 0);
```

###ResettableTrait

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

