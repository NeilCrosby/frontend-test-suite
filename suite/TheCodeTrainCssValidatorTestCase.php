<?php

/**
 * TestCase class to inherit from to allow Unit Testing based checking of
 * CSS validity.
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainCssValidatorTestCase extends TheCodeTrainBaseValidatorTestCase {
    
    protected $validatorUrl   = 'http://jigsaw.w3.org/css-validator/validator';
    protected $validatorClass = 'TheCodeTrainCssValidator';
    
}
?>