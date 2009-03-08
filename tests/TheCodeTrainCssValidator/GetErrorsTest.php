<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidator_GetErrorsTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $urls = TheCodeTrainCssValidatorProviders::validValidatorUrlProvider();
        $this->obj = new TheCodeTrainCssValidator($urls[0][0]); // TODO proper URL
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::invalidValidatorUrlProvider
     */
    public function testReturnsNoValidatorResponseWhenBadUrlGiven($input) {
        $validator = new TheCodeTrainCssValidator($input);
        $validator->isValid('anything');
        $this->assertEquals(
            TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE,
            $validator->getErrors()
        );
    }

    public function testReturnsNoValidatorResponseWhenNoPreviousCssTested() {
        $this->assertEquals(
            TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE,
            $this->obj->getErrors()
        );
    }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::validCssProvider
     */
    public function testReturnsFalseWhenValidCssTested($input) {
        $isValid = $this->obj->isValid($input);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::invalidCssProvider
     */
    public function testReturnsArrayWhenInvalidCssTested($input) {
        $isValid = $this->obj->isValid($input);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertType('array', $errors);
    }

}
?>