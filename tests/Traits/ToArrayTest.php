<?php
    namespace Mbright\Test\Traits;

    use Mbright\Traits\ToArray;

    class fake extends \stdClass
    {
        protected static $nope = 'nope';

        use ToArray;
    }


    class ToArrayTest extends \PHPUnit_Framework_TestCase
    {
        public function testToArray()
        {
            $obj = new fake();
            $obj->attr1 = 1;
            $obj->attr2 = 2;

            $expected = [
                'attr1' => 1,
                'attr2' => 2
            ];
            $actual = $obj->toArray();
            $this->assertEquals($expected, $actual);
        }
    }