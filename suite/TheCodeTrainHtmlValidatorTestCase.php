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
        $validator = new TheCodeTrainHtmlValidator($this->validatorUrl);

        $isValid = $validator->isValid($html, $options);
        
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