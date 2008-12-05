<?php

class TheCodeTrainHtmlValidator_GetErrorsTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new TheCodeTrainHtmlValidator('http://htmlvalidator/check'); // TODO proper URL
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidValidatorUrlProvider
     */
    public function testReturnsNoValidatorResponseWhenBadUrlGiven($input) {
        $validator = new TheCodeTrainHtmlValidator($input);
        $validator->isValid('anything', TheCodeTrainHtmlValidator::HTML_CHUNK);
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
        $isValid = $this->obj->isValid($input, TheCodeTrainHtmlValidator::HTML_CHUNK);
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
        $isValid = $this->obj->isValid($input, TheCodeTrainHtmlValidator::HTML_CHUNK);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertType('array', $errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlChunkProvider
     */
    public function testReturnsFalseWhenValidHtmlDocumentTested($input) {
        $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$input
</body></html>
HTML;
        $isValid = $this->obj->isValid($html, TheCodeTrainHtmlValidator::HTML_DOCUMENT);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkProvider
     */
    public function testReturnsArrayWhenInvalidHtmlDocumentTested($input) {
        $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$input
</body></html>
HTML;
        $isValid = $this->obj->isValid($html, TheCodeTrainHtmlValidator::HTML_DOCUMENT);
        $errors = $this->obj->getErrors();
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $errors ) {
            $this->markTestSkipped();
        }
        $this->assertType('array', $errors);
    }
}
?>