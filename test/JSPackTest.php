<?php

use Pack\JS;

class JSPackTest extends PHPUnit_Framework_TestCase
{
    private $packer;

    public function setUp()
    {
        $this->packer = new JS();
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
            ], [
                ' if ( i > 0 || i < 100 ) { console.log ( i ) ; } ',
                'if(i>0||i<100){console.log(i);}'
            ], [
                ' if ( i <= 0 || i >= 100 ) { console.log ( i ) ; } ',
                'if(i<=0||i>=100){console.log(i);}'
            ], [
                ' if ( i == 0 && ( j <= 100 && j >= 0 ) ) { console.log ( i ) ; } ',
                'if(i==0&&(j<=100&&j>=0)){console.log(i);}'
            ], [
                ' for (var i in list) { console.log( i ) ; } ',
                'for(var i in list){console.log(i);}'
            ], [
                ' while ( true ) { console.log( i ) ; break ; } ',
                'while(true){console.log(i);break;}'
            ], [
                ' do { console.log( i ) ; break ; } while ( true ) ; ',
                'do{console.log(i);break;}while(true);'
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
                " \nvar foobar = function ( name )\n{\n\tconsole.log ( name ) ;\n\t} ;\n",
                'var foobar=function(name){console.log(name);};'
            ], [
                " \rvar foobar = function ( name )\r{\r\tconsole.log ( name ) ;\r\t} ;\r",
                'var foobar=function(name){console.log(name);};'
            ], [
                " \r\nvar foobar = function ( name )\r\n{\r\n\tconsole.log ( name ) ;\r\n\t} ;\r\n",
                'var foobar=function(name){console.log(name);};'
            ], [
                " \nfunction hi ( name )\n{\n\tconsole.log( name ) ;\n} ",
                'function hi(name){console.log(name);}'
            ], [
                " \n'use strict';\nvar list = {\n\ta : 'str' ,\n\tb : [ 1 , 2 ] ,\n\tc : {\n\t\td : 3 ,\n\t\te : 4\n\t}\n} ;",
                '\'use strict\';var list={a:\'str\',b:[1,2],c:{d:3,e:4}};'
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