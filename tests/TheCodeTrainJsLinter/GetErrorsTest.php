<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinter_GetErrorsTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new TheCodeTrainJsLinter('java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js'); // TODO proper URL
    }

    public function tearDown() {
    }

    public function testReturnsNoErrorResponseWhenNoPreviousJsTested() {
        $this->assertEquals(
            TheCodeTrainCssValidator::NO_ERROR,
            $this->obj->getErrors()
        );
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::validJsProvider
     */
    public function testReturnsFalseWhenValidJsTested($input) {
        $isValid = $this->obj->isValid($input);
        $errors = $this->obj->getErrors();
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::invalidJsProvider
     */
    public function testReturnsArrayWhenInvalidHsTested($input) {
        $isValid = $this->obj->isValid($input);
        $errors = $this->obj->getErrors();
        $this->assertType('array', $errors);
    }

}
?>