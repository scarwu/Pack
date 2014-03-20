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
                ' console.log ( i++ + ++i ) ; ',
                'console.log(i++ + ++i);'
            ], [
                ' console.log ( i++ - ++i ) ; ',
                'console.log(i++-++i);'
            ], [
                ' console.log ( i-- - --i ) ; ',
                'console.log(i-- - --i);'
            ], [
                ' console.log ( i-- + --i ) ; ',
                'console.log(i--+--i);'
            ], [
                ' console.log ( i-- - ++i ) ; ',
                'console.log(i-- -++i);'
            ], [
                ' console.log ( i++ + --i ) ; ',
                'console.log(i++ +--i);'
            ], [
                ' console.log ( i-- - --i * i-- + --i ) ; ',
                'console.log(i-- - --i*i--+--i);'
            ], [
                ' console.log ( i++ - ++i / i++ + ++i ) ; ',
                'console.log(i++-++i/i++ + ++i);'
            ], [
                ' console.log ( "foo" + "bar" ) ; ',
                'console.log("foo"+"bar");'
            ], [
                ' console.log ( 25 % 5 ) ; ',
                'console.log(25%5);'
            ], [
                ' console.log ( 25 * 5 ) ; ',
                'console.log(25*5);'
            ], [
                ' console.log ( 25 / 5 ) ; ',
                'console.log(25/5);'
            ]
        ];
    }

    public function stringProvider()
    {
        return [
            [
                " console.log ( ' hello ' ) ; ",
                "console.log(' hello ');"
            ], [
                ' console.log ( " hello " ) ; ',
                'console.log(" hello ");'
            ], [
                " console.log ( ' It\'s blue. ' ) ; ",
                "console.log(' It\'s blue. ');"
            ], [
                ' console.log ( " \"Oni\" is means ghost. " ) ; ',
                'console.log(" \"Oni\" is means ghost. ");'
            ], [
                " console.log ( ' \'\"\' ' ) ; ",
                "console.log(' \'\"\' ');"
            ], [
                ' console.log ( " \"\'\" " ) ; ',
                'console.log(" \"\'\" ");'
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
                " \n// line 1\nfoobar();\n// line 3\n ",
                'foobar();'
            ], [
                " // line 1 /*\nfoobar();\n// line 3 */ ",
                'foobar();'
            ], [
                " /* // line 1\n'use strict';\n// line 3 */",
                ''
            ], [
                "/**\n * foobar\n**/\nfoobar();",
                'foobar();'
            ]
        ];
    }
}
