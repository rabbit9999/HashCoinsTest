<?php
use PHPUnit\Framework\TestCase;
require_once '../calc_2/Calc2Core.php';

class CalculatorTests extends TestCase{
    private $calc;

    protected function setUp()
    {
        $this->calc = new Calc2Core();
    }

    protected function tearDown()
    {
        $this->calc = NULL;
    }

    public function test_1()
    {
        $result = $this->calc->calculate('0');
        $this->assertEquals(0, $result);
    }

    public function test_2()
    {
        $result = $this->calc->calculate('5 + 2');
        $this->assertEquals(7, $result);
    }

    public function test_3()
    {
        $result = $this->calc->calculate('5 * 2');
        $this->assertEquals(10, $result);
    }

    public function test_4()
    {
        $result = $this->calc->calculate('10 / 2');
        $this->assertEquals(5, $result);
    }

    public function test_5()
    {
        $result = $this->calc->calculate('10 - 2');
        $this->assertEquals(8, $result);
    }

    public function test_6()
    {
        $result = $this->calc->filter('1 + 2');
        $this->assertEquals('1+2', $result);
    }

    public function test_7()
    {
        $result = $this->calc->filter('_ ( 5 + 2 ) _');
        $this->assertEquals('(5+2)', $result);
    }

    public function test_8()
    {
        $result = $this->calc->filter('qwe5qwe*qwe2qwe');
        $this->assertEquals('5*2', $result);
    }
}