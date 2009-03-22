<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinter_IsValidTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new TheCodeTrainJsLinter('java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js'); // TODO proper URL
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::validJsProvider
     */
    public function testReturnsTrueWhenGivenValidJs($input) {
        $isValid = $this->obj->isValid($input);
        if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue($isValid);
    }

     /**
      * @dataProvider TheCodeTrainJsLinterProviders::invalidJsProvider
      */
     public function testReturnsFalseWhenGivenInvalidCss($input) {
         $isValid = $this->obj->isValid($input);
         if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
             $this->markTestSkipped();
         }
         $this->assertFalse($isValid);
     }
}
?>