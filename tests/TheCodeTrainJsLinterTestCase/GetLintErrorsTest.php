<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinterTestCase_GetLintErrorsTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $commands = TheCodeTrainJsLinterProviders::validLintCommandProvider();
        $this->obj = new ConcreteJsLinterTestCase();
        $this->obj->setLintCommand( $commands[0][0] );
    }

    public function tearDown() {
    }
    
    /**
     * @dataProvider TheCodeTrainJsLinterProviders::validJsProvider
    */
    public function testReturnsFalseWhenValidJsTested($input) {
        $errors = $this->obj->getLintErrors($input);
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::invalidJsProvider
     */
    public function testReturnsArrayWhenInvalidJsTested($input) {
        $errors = $this->obj->getLintErrors($input);
        $this->assertType('array', $errors);
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::validJsWithOptionsProvider
     */
    public function testReturnsFalseWhenValidCssWithExceptionsTested($input) {
        $errors = $this->obj->getLintErrors($input[0], $input[1]);
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::invalidJsWithOptionsProvider
     */
    public function testReturnsArrayWhenInvalidJsWithExceptionsTested($input) {
        $errors = $this->obj->getLintErrors($input[0], $input[1]);
        $this->assertType('array', $errors);
    }
}
?>