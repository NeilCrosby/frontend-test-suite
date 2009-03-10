<?php

/**
 * TestCase class to inherit from to allow Unit Testing based checking of
 * CSS validity.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainCssValidatorTestCase extends PHPUnit_Framework_TestCase {
    
    private $validatorUrl = 'http://127.0.0.1:8080/css-validator/validator';
    
    public function setValidatorUrl($url) {
        $this->validatorUrl = $url;
    }
   
    public function getValidationError($css, $options = array()) {
        $validator = new TheCodeTrainCssValidator($this->validatorUrl);
        $isValid = $validator->isValid($css, $options);
        
        if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped('No validator');
        } else if ( $isValid ) {
            return false;
        }
        
        $result = $validator->getErrors();
        
        return $result[0];
    }
    
}
?>