<?php

use Pack\CSS;

class CSSPackTest extends PHPUnit_Framework_TestCase
{
    private $packer;

    public function setUp()
    {
        $this->packer = new CSS();
    }

    public function atrributeProvider()
    {
        return [
            [
                ' width : 100% ; height : 200px ; ',
                'width:100%;height:200px;'
            ], [
                ' content : " ( " attr() " ) " ; ',
                'content:" ( "attr()" ) ";'
            ], [
                " content : ' email ' ; ",
                "content:' email ';"
            ], [
                ' color : #000000 !important ; ',
                'color:#000000!important;'
            ], [
                ' border : 1px red solid ; ',
                'border:1px red solid;'
            ]
        ];
    }

    public function tagNameProvider()
    {
        return [
            [
                "\ndiv\n{\n\tdisplay : inline-block;\n\twidth : 200px ; }\n",
                'div{display:inline-block;width:200px;}'
            ], [
                "\rdiv\r{\r\tdisplay : inline-block;\r\twidth : 200px ; }\r",
                'div{display:inline-block;width:200px;}'
            ], [
                "\r\ndiv\r\n{\r\n\tdisplay : inline-block ;\r\n\twidth : 200px ; }\r\n",
                'div{display:inline-block;width:200px;}'
            ], [
                " div > span { color : #333 ; }",
                'div>span{color:#333;}'
            ], [
                " div ~ span { color : #333 ; }",
                'div~span{color:#333;}'
            ], [
                " div , span { color : #333 ; }",
                'div,span{color:#333;}'
            ], [
                " #main div { width : 100px ; }",
                '#main div{width:100px;}'
            ], [
                " .block { display : block; } ",
                '.block{display:block;}'
            ], [
                " a:hover { background : #666; } ",
                'a:hover{background:#666;}'
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
            ], [
                "",
                ''
            ]
        ];
    }

    /**
     * @dataProvider atrributeProvider
     */
    public function testAtrribute($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider tagNameProvider
     */
    public function testTagName($input, $output) {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider commentProvider
     */
    public function testComment($input, $output) {
        $this->assertEquals($this->packer->get($input), $output);
    }
}