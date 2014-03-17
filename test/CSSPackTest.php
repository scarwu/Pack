<?php
class CSSPackTest extends PHPUnit_Framework_TestCase
{
    private $packer;

    public function setUp()
    {
        $this->packer = new Pack\CSS();
    }

    /**
     * @dataProvider tagNameProvider
     */
    public function testTagName($input, $output)
    {
        $this->assertEquals($this->packer->get($input), $output);
    }

    /**
     * @dataProvider atrributeProvider
     */
    public function testAtrribute($input, $output)
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

    public function tagNameProvider()
    {
        return [
            [
                " div > span { } ",
                'div>span{}'
            ], [
                " div ~ span { } ",
                'div~span{}'
            ], [
                " div , span { } ",
                'div,span{}'
            ], [
                " div + span { } ",
                'div+span{}'
            ], [
                " #main div { } ",
                '#main div{}'
            ], [
                " .block { } ",
                '.block{}'
            ], [
                " a:hover { } ",
                'a:hover{}'
            ], [
                " a:nth-child(odd) { } ",
                'a:nth-child(odd){}'
            ], [
                " div::before { } ",
                'div::before{}'
            ], [
                " div [ title ] { } ",
                'div[title]{}'
            ], [
                " div [ title = name ] { } ",
                'div[title=name]{}'
            ], [
                " div [ title ~= name ] { } ",
                'div[title~=name]{}'
            ], [
                " [ hidden ] { } ",
                '[hidden]{}'
            ]
        ];
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

    public function mutlipleLineProvider()
    {
        return [
            [
                "\ndiv\n{\n\tdisplay : inline-block;\n\twidth : 200px ; }\n ",
                'div{display:inline-block;width:200px;}'
            ], [
                "\rdiv\r{\r\tdisplay : inline-block;\r\twidth : 200px ; }\r ",
                'div{display:inline-block;width:200px;}'
            ], [
                "\r\ndiv\r\n{\r\n\tdisplay : inline-block ;\r\n\twidth : 200px ; }\r\n ",
                'div{display:inline-block;width:200px;}'
            ]
        ];
    }

    public function commentProvider()
    {
        return [
            [
                " div { width : 100% ; /* color : black; */ }",
                'div{width:100%;}'
            ], [
                " /* style */ div { width : 100% ; }",
                'div{width:100%;}'
            ], [
                " div { /*min-*/width : 100% ; }",
                'div{width:100%;}'
            ], [
                " div { width : 100%/*px*/ ; }",
                'div{width:100%;}'
            ], [
                " div { margin /*-top*/ : 100px ; }",
                'div{margin:100px;}'
            ]
        ];
    }
}
