<?php
namespace Mbright\Test\Traits;

use Mbright\Traits\FromArray;

class Fake2 extends \stdClass
{
    public static $yep = 'yep';

    use FromArray;
}

class FromArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testFromArray()
    {
        $expected = new Fake2();
        $expected->attr1 = 1;
        $expected->attr2 = 2;

        $actual = new Fake2();
        $actual->fromArray(
            [
                'attr1' => 1,
                'attr2' => 2
            ]
        );
        $this->assertEquals($expected, $actual);
    }
}
