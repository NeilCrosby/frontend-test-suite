<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidator_IsValidTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $urls = TheCodeTrainHtmlValidatorProviders::validValidatorUrlProvider();
        $this->obj = new TheCodeTrainHtmlValidator( $urls[0][0] );
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidValidatorUrlProvider
     */
    public function testReturnsNoValidatorResponseWhenBadUrlGiven($input) {
        $validator = new TheCodeTrainHtmlValidator($input);
        $this->assertEquals(
            TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE,
            $validator->isValid('anything')
        );
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlChunkProvider
     */
    public function testReturnsTrueWhenGivenValidHtmlChunk($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkProvider
     */
    public function testReturnsFalseWhenGivenInvalidHtmlChunk($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($isValid);
    }
    
    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlDocumentProvider
     */
    public function testReturnsTrueWhenGivenValidHtmlDocument($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_DOCUMENT));
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlDocumentProvider
     */
    public function testReturnsFalseWhenGivenInvalidHtmlDocument($input) {
        $isValid = $this->obj->isValid($input, array('document_section'=>TheCodeTrainHtmlValidator::HTML_DOCUMENT));
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($isValid);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlWithDoctypeOverrideProvider
     */
    public function testReturnsTrueWhenGivenValidHtmlDoctypeOverride( $html, $aOptions ) {
        $isValid = $this->obj->isValid( $html, $aOptions );
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue( $isValid );
    }
}
?>