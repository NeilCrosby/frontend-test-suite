<?php

/**
 * TestCase class to inherit from to allow Unit Testing based checking of
 * HTML validity.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainHtmlValidatorTestCase extends TheCodeTrainBaseValidatorTestCase {
    
    protected $validatorUrl = 'http://htmlvalidator/check';
    protected $validatorClass = 'TheCodeTrainHtmlValidator';
    
}
?>