<?php

use Pack\CSS;

class CSSPackTest extends PHPUnit_Framework_TestCase
{
    private $packer;

    public function setUp()
    {
        $this->packer = new CSS();
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
                ' div > span { } ',
                'div>span{}'
            ], [
                ' div ~ span { } ',
                'div~span{}'
            ], [
                ' div , span { } ',
                'div,span{}'
            ], [
                ' div + span { } ',
                'div+span{}'
            ], [
                ' #main div { } ',
                '#main div{}'
            ], [
                ' .block { } ',
                '.block{}'
            ], [
                ' a:hover { } ',
                'a:hover{}'
            ], [
                ' a:nth-child(odd) { } ',
                'a:nth-child(odd){}'
            ], [
                ' div::before { } ',
                'div::before{}'
            ], [
                ' div [ title ] { } ',
                'div[title]{}'
            ], [
                ' div [ title = name ] { } ',
                'div[title=name]{}'
            ], [
                ' div [ title ~= name ] { } ',
                'div[title~=name]{}'
            ], [
                " [ hidden ] { } ",
                '[hidden]{}'
            ], [
                ' @media screen and ( min-width : 400px) and ( max-width : 1200px) { } ',
                '@media screen and(min-width:400px)and(max-width:1200px){}'
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
                ' border : 1px #333 solid ; ',
                'border:1px#333 solid;'
            ], [
                ' margin : 2px 2px 2px 2px ; ',
                'margin:2px 2px 2px 2px;'
            ], [
                ' border-image : url ( border.png ) 30 30 round ; ',
                'border-image:url(border.png)30 30 round;'
            ], [
                ' background : url ( img_tree.gif ) , url ( img_flwr.gif ) ; ',
                'background:url(img_tree.gif),url(img_flwr.gif);'
            ], [
                ' background : linear-gradient ( to right , red , blue ) ; ',
                'background:linear-gradient(to right,red,blue);'
            ], [
                ' background : radial-gradient ( red 5% , green 15% , blue 60% ) ; ',
                'background:radial-gradient(red 5%,green 15%,blue 60%);'
            ], [
                ' background : linear-gradient ( to right , rgba ( 255 , 0 , 0 , 0 ) , rgba ( 255 , 0 , 0 , 1 ) ) ; ',
                'background:linear-gradient(to right,rgba(255,0,0,0),rgba(255,0,0,1));'
            ], [
                ' background : radial-gradient ( 60% 55% , farthest-side , blue ) ; ',
                'background:radial-gradient(60% 55%,farthest-side,blue);'
            ], [
                ' transition : width 2s , height 2s , transform 2s ; ',
                'transition:width 2s,height 2s,transform 2s;'
            ]
        ];
    }

    public function commentProvider()
    {
        return [
            [
                ' /* comment */ ',
                ''
            ], [
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

    public function mutlipleLineProvider()
    {
        return [
            [
                " \ndiv\n{\n\tdisplay : inline-block;\n\twidth : 200px ; }\n ",
                'div{display:inline-block;width:200px;}'
            ], [
                " \rdiv\r{\r\tdisplay : inline-block;\r\twidth : 200px ; }\r ",
                'div{display:inline-block;width:200px;}'
            ], [
                " \r\ndiv\r\n{\r\n\tdisplay : inline-block ;\r\n\twidth : 200px ; }\r\n ",
                'div{display:inline-block;width:200px;}'
            ], [
                " \r\ndiv\r\n{\r\n\t/* display : inline-block ;\r\n\twidth : 200px ; */ }\r\n ",
                'div{}'
            ], [
                " \n@media screen and ( max-width : 1200px)\n{\n\tdiv\n\t{\n\t\tfont-size : 2em ;\n\t}\n}\n ",
                '@media screen and(max-width:1200px){div{font-size:2em;}}'
            ], [
                " \nbody #main .content , span\n{\n\tdisplay : inline-block;\n\t/* width : 200px ; */ }\n@media screen and ( max-width : 1200px)\n{\n\tdiv\n\t{\n\t\tfont-size : 2em ;\n\t}\n}\n ",
                'body#main.content,span{display:inline-block;}@media screen and(max-width:1200px){div{font-size:2em;}}'
            ], [
                " \n@keyframes myfirst\n{\n\t0%\n\t{background: red; left:0px; top:0px;\n\t}\n\t50%\n\t{\n\t\tbackground : blue ; left : 200px ; top : 200px ;\n\t}\n\t100%\n\t{\n\t\tbackground : red ;\n\t\tleft : 0px ;\n\t\ttop : 0px ;\n\t}\n}\n ",
                '@keyframes myfirst{0%{background:red;left:0px;top:0px;}50%{background:blue;left:200px;top:200px;}100%{background:red;left:0px;top:0px;}}'
            ]
        ];
    }
}
