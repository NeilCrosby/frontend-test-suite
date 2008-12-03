<?php

class TheCodeTrainHtmlValidator_IsValidTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new TheCodeTrainHtmlValidator('http://htmlvalidator/check'); // TODO proper URL
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::invalidValidatorUrlProvider
     */
    public function testReturnsNoValidatorResponseWhenBadUrlGiven($input) {
        $validator = new TheCodeTrainHtmlValidator($input);
        $this->assertEquals(
            TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE,
            $validator->isValid('anything')
        );
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::validHtmlChunkProvider
     */
    public function testReturnsTrueWhenGivenValidHtmlChunk($input) {
        $isValid = $this->obj->isValid($input, TheCodeTrainHtmlValidator::HTML_CHUNK);
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::invalidHtmlChunkProvider
     */
    public function testReturnsFalseWhenGivenInvalidHtmlChunk($input) {
        $isValid = $this->obj->isValid($input, TheCodeTrainHtmlValidator::HTML_CHUNK);
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($isValid);
    }
    
    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::validHtmlChunkProvider
     */
    public function testReturnsTrueWhenGivenValidHtmlDocument($input) {
        $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$input
</body></html>
HTML;
        $isValid = $this->obj->isValid($html, TheCodeTrainHtmlValidator::HTML_DOCUMENT);
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertTrue($isValid);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorTestSuite::invalidHtmlChunkProvider
     */
    public function testReturnsFalseWhenGivenInvalidHtmlDocument($input) {
        $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$input
</body></html>
HTML;
        $isValid = $this->obj->isValid($html, TheCodeTrainHtmlValidator::HTML_DOCUMENT);
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($isValid);
    }
    
}
?>