<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainBaseValidatorTestCase_GetValidationErrorTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new ConcreteValidatorTestCase();
        $this->obj->setValidatorUrl('http://htmlvalidator/check');
    }

    public function tearDown() {
    }

    public function testSkipsTestWhenBadUrlGiven() {
        $this->markTestIncomplete();
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlChunkProvider
     */
    public function testReturnsFalseWhenValidHtmlChunkTested($input) {
        $errors = $this->obj->getValidationError($input, TheCodeTrainHtmlValidator::HTML_CHUNK);
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkProvider
     */
    public function testReturnsStringWhenInvalidHtmlChunkTested($input) {
        $errors = $this->obj->getValidationError($input, TheCodeTrainHtmlValidator::HTML_CHUNK);
        $this->assertType('string', $errors);
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
        $errors = $this->obj->getValidationError($html, TheCodeTrainHtmlValidator::HTML_DOCUMENT);
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkProvider
     */
    public function testReturnsStringWhenInvalidHtmlDocumentTested($input) {
        $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$input
</body></html>
HTML;
        $errors = $this->obj->getValidationError($html, TheCodeTrainHtmlValidator::HTML_DOCUMENT);
        $this->assertType('string', $errors);
    }
}

class ConcreteValidatorTestCase extends TheCodeTrainBaseValidatorTestCase {
    
}
?>