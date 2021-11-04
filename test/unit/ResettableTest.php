<?php

use \MbSupport\ResettableTrait;

class Resettable
{
    public $foo = 1;
    public $bar = 2;
    public $baz;

    private $notResettable = ['baz'];

    use ResettableTrait;
}

class ResettableTest extends \Tests\TestCase
{
    public function test_it_resets()
    {
        $dummy    = new Resettable;
        $dummyNew = new Resettable;

        $dummy->foo = 10;
        $dummy->bar = 20;

        $dummy->reset();

        $this->assertEquals($dummyNew->foo, $dummy->foo);
        $this->assertEquals($dummyNew->bar, $dummy->bar);
    }

    public function test_it_skips_not_resettable()
    {
        $dummy = new Resettable;
        $dummy->baz = 30;

        $dummy->reset();

        $this->assertEquals(30, $dummy->baz);
    }
}

/* End of file */
