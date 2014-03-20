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
            ], [
                ' < a href = "scar.simcz.tw" target = "_blank" style = " display : block ; font-size : 1.25em ; " > < /a >',
                '<a href="scar.simcz.tw" target="_blank" style="display:block;font-size:1.25em;"></a>'
            ]
        ];
    }

    public function contentProvider()
    {
        return [
            [
                ' < div > hello < /div > ',
                '<div>hello</div>'
            ], [
                ' < div >  < div > hello < /div >  < /div > ',
                '<div><div>hello</div></div>'
            ], [
                " < script type = \"text/javascript\" > ( function ( ) {  var po = document.createElement( 'script' ) ; po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName ( 'script' ) [ 0 ] ; s.parentNode.insertBefore ( po , s ) ; } ) ( ) ; < /script > ",
                "<script type=\"text/javascript\">(function(){var po=document.createElement('script');po.type='text/javascript';po.async=true;po.src='https://apis.google.com/js/plusone.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po,s);})();</script>"
            ], [
                " < style type = \"text/css\" > div { background-color : #FF0000 ; } < /style > ",
                "<style type=\"text/css\">div{background-color:#FF0000;}</style>"
            ]
        ];
    }

    public function mutlipleLineProvider()
    {
        return [
            [
                " \n< div >\n\t< img / >\n< /div >\n ",
                '<div><img/></div>'
            ], [
                " \r< div >\r\t< img / >\r< /div >\r ",
                '<div><img/></div>'
            ], [
                " \r\n< div >\r\n\t< img / >\r\n< /div >\r\n ",
                '<div><img/></div>'
            ]
        ];
    }
}
