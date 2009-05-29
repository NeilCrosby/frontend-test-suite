<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinter_ConstructTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    /**
     * @dataProvider lintCommandProvider
     */
    public function testInstantiatesIfValidLintCommandGiven( $input ) {
        $obj = new TheCodeTrainJsLinter($input);
        $this->assertThat(
            $obj,
            $this->isInstanceOf('TheCodeTrainJsLinter')
        );
    }

    public function testExceptionRaisedIfNoLintCommandGiven( ) {
        $this->setExpectedException('Exception');
        $obj = new TheCodeTrainJsLinter();
    }

    public static function lintCommandProvider() {
        return array(
            array('java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js'),
        );
    }


}
?>