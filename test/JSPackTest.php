<?php
class JSPackTest extends PHPUnit_Framework_TestCase
{
    private $packer;

    public function setUp()
    {
        $this->packer = new Pack\JS();
    }

    /**
     * @dataProvider operatorProvider
     */
    public function testOperator($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider stringProvider
     */
    public function testString($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider mutlipleLineProvider
     */
    public function testMutlipleLine($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider commentProvider
     */
    public function testComment($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    public function operatorProvider()
    {
        return [
            [
                "",
                ''
            ], [
                "",
                ''
            ]
        ];
    }

    public function stringProvider()
    {
        return [
            [
                "",
                ''
            ], [
                "",
                ''
            ]
        ];
    }

    public function mutlipleLineProvider()
    {
        return [
            [
                "",
                ''
            ], [
                "",
                ''
            ]
        ];
    }

    public function commentProvider()
    {
        return [
            [
                "",
                ''
            ], [
                "",
                ''
            ]
        ];
    }
}
