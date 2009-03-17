<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainBaseValidatorTestCase extends PHPUnit_Framework_TestCase {
    
    protected $validatorUrl = '';
    
    public function setValidatorUrl($url) {
        $this->validatorUrl = $url;
    }
   
    public function getValidationError($input, $options = array()) {
        $class = $this->validatorClass;
        $validator = new $class($this->validatorUrl);
        $isValid = $validator->isValid($input, $options);
        
        if ( TheCodeTrainBaseValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped('No validator');
        } else if ( $isValid ) {
            return false;
        }
        
        $result = $validator->getErrors();
        
        return $result[0];
    }
}
?>