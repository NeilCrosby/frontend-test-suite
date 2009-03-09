<?php

/**
 * TestCase class to inherit from to allow Unit Testing based checking of
 * HTML validity.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainHtmlValidatorTestCase extends PHPUnit_Framework_TestCase {
    
    private $validatorUrl = 'http://htmlvalidator/check';
    
    public function setValidatorUrl($url) {
        $this->validatorUrl = $url;
    }
   
    public function getValidationError($html, $options = array()) {
        $type     = isset($options['type'])     ? $options['type']     : null;
        $position = isset($options['position']) ? $options['position'] : TheCodeTrainHtmlValidator::POSITION_BODY;
        
        $validator = new TheCodeTrainHtmlValidator($this->validatorUrl);

        if ( TheCodeTrainHtmlValidator::HTML_CHUNK == $type ) {
            if ( TheCodeTrainHtmlValidator::POSITION_HEAD == $position ) {
                $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
$html
</head>
<body>
<p>Empty body</p>
</body></html>
HTML;
            } else {
                $html = <<< HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>title</title></head>
<body>
$html
</body></html>
HTML;
            }
        }

        $isValid = $validator->isValid($html);
        
        if ( TheCodeTrainHtmlValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped('No validator');
        } else if ( $isValid ) {
            return false;
        }
        
        $result = $validator->getErrors();
        
        return $result[0];
    }
    
}
?>