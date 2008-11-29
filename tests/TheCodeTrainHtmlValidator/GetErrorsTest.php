<?php

class TheCodeTrainHtmlValidator_GetErrorsTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new TheCodeTrainHtmlValidator('http://validator.w3.org/'); // TODO proper URL
    }

    public function tearDown() {
    }

    public function testReturnsFalseWhenNoPreviousHtmlChunkTested() {
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE == $errors ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::validHtmlChunkProvider
     */
    public function testReturnsFalseWhenValidHtmlChunkTested($input) {
        $isValid = $this->obj->isValid($input);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE == $errors ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::invalidHtmlChunkProvider
     */
    public function testReturnsArrayWhenInvalidHtmlChunkTested($input) {
        $isValid = $this->obj->isValid($input);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE == $errors ) {
            $this->markTestSkipped();
        }
        $this->assertType('array', $errors);
    }
}
?>