<?php
class HTMLPackTest extends PHPUnit_Framework_TestCase
{
    private $packer;

    public function setUp()
    {
        $this->packer = new Pack\HTML();
    }

    /**
     * @dataProvider tagNameProvider
     */
    public function testTagName($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider contentProvider
     */
    public function testContent($input, $output)
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

    /**
     * @dataProvider mutlipleLineProvider
     */
    public function testMutlipleLine($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    public function tagNameProvider()
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

    public function contentProvider()
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
}
