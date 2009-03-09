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

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidValidatorUrlProvider
     **/
    public function testSkipsTestWhenBadUrlGiven($input) {
        $this->obj = new ConcreteValidatorTestCase();
        $this->obj->setValidatorUrl($input);
        try {
            $this->obj->getValidationError('<p>whatever</pee>', array('type'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        } catch (PHPUnit_Framework_SkippedTestError $e) {
            // If this gets fired, the test has passed. Therefore, return!
            // This is fired because when a test is marked as skipped a
            // PHPUnit_Framework_SkippedTestError error is fired.  We can't
            // test for this the normal way, with a setExpectedException,
            // because doing that still results in the inner test being shown
            // as having been skipped when we run this test.
            return;
        }
        
        // Therefore, if we get to here, the test has failed.
        $this->fail();
    }
    
    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlChunkProvider
     */
    public function testReturnsFalseWhenValidHtmlChunkTested($input) {
        $errors = $this->obj->getValidationError($input, array('type'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkProvider
     */
    public function testReturnsStringWhenInvalidHtmlChunkTested($input) {
        $errors = $this->obj->getValidationError($input, array('type'=>TheCodeTrainHtmlValidator::HTML_CHUNK));
        $this->assertType('string', $errors);
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validHtmlChunkWithPositionProvider
     */
    public function testReturnsFalseWhenValidHtmlChunkWithPositionTested($input) {
        $errors = $this->obj->getValidationError(
            $input[0], 
            array('type'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 'position'=>$input[1])
        );
        $this->assertFalse($errors);
    }
     
    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidHtmlChunkWithPositionProvider
     */
    public function testReturnsStringWhenInvalidHtmlChunkWithPositionTested($input) {
        $errors = $this->obj->getValidationError(
            $input[0], 
            array('type'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 'position'=>$input[1])
        );
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
?>