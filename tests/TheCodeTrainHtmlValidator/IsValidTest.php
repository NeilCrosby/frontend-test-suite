<?php

class TheCodeTrainHtmlValidator_IsValidTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new TheCodeTrainHtmlValidator('http://validator.w3.org/'); // TODO proper URL
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::validHtmlChunkProvider
     */
    public function testReturnsTrueWhenGivenValidHtmlChunk($input) {
        $isValid = $this->obj->isValid($input);
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE == $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::invalidHtmlChunkProvider
     */
    public function testReturnsFalseWhenGivenInvalidHtmlChunk($input) {
        $isValid = $this->obj->isValid($input);
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE == $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($isValid);
    }
    
}
?>