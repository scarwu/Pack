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
                ' < div id = "main" class = "block" > < /div >',
                '<div id="main" class="block"></div>'
            ], [
                '< img src = "001.jpg" / >',
                '<img src="001.jpg"/>'
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
