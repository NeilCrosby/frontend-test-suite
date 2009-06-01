<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidator_IsValidTest extends PHPUnit_Framework_TestCase {

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