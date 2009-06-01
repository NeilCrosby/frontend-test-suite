<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidator_GetErrorsTest extends PHPUnit_Framework_TestCase {
    
    const DEFAULT_VALIDATOR_URL="http://htmlvalidator/check"; // TODO proper URL
    
    public function setUp() {
        $validator_url = getenv( 'FETS_TEST_HTML_VALIDATOR_URL' );
        if ( empty( $validator_url ) ) {
            $validator_url = self::DEFAULT_VALIDATOR_URL;
        }
        $this->obj = new TheCodeTrainHtmlValidator( $validator_url );
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidValidatorUrlProvider
     */
    public function testReturnsNoValidatorResponseWhenBadUrlGiven($input) {
        $validator = new TheCodeTrainHtmlValidator($input);
        $validator->isValid('anything', array('document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        $this->assertEquals(
            TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE,
            $validator->getErrors()
        );
    }

    public function testReturnsNoValidatorResponseWhenNoPreviousHtmlChunkTested() {
        $this->assertEquals(
            TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE,
            $this->obj->getErrors()
        );
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlChunkProvider
     */
    public function testReturnsFalseWhenValidHtmlChunkTested($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkProvider
     */
    public function testReturnsArrayWhenInvalidHtmlChunkTested($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertType('array', $errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlDocumentProvider
     */
    public function testReturnsFalseWhenValidHtmlDocumentTested($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_DOCUMENT));
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlDocumentProvider
     */
    public function testReturnsArrayWhenInvalidHtmlDocumentTested($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_DOCUMENT));
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertType('array', $errors);
    }
}
?>