<?php namespace Maatwebsite\Clerk\Tests\Excel\Html\PHPExcel;

use Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\ElementParserFactory;

class ElementParserFactoryTest extends \PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        \Mockery::close();
    }

    public function test_factory_returns_right_element()
    {
        $this->assertInstanceOf('Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\Elements\TrElement', ElementParserFactory::create('tr', $this->mockSheet()));
        $this->assertInstanceOf('Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\Elements\TdElement', ElementParserFactory::create('td', $this->mockSheet()));
        $this->assertInstanceOf('Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\Elements\ThElement', ElementParserFactory::create('th', $this->mockSheet()));
    }


    protected function mockSheet()
    {
        return \Mockery::mock('Maatwebsite\Clerk\Excel\Sheet')->makePartial();
    }
}