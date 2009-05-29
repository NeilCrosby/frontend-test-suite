<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidator_IsValidTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $urls = TheCodeTrainCssValidatorProviders::validValidatorUrlProvider();
        $this->obj = new TheCodeTrainCssValidator($urls[0][0]);
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::invalidValidatorUrlProvider
     */
    public function testReturnsNoValidatorResponseWhenBadUrlGiven($input) {
        $validator = new TheCodeTrainCssValidator($input);
        $this->assertEquals(
            TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE,
            $validator->isValid('anything')
        );
    }

   /**
    * @dataProvider TheCodeTrainCssValidatorProviders::validCssProvider
    */
   public function testReturnsTrueWhenGivenValidCss($input) {
       $isValid = $this->obj->isValid($input);
       if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
           $this->markTestSkipped();
       }
       $this->assertTrue($isValid);
   }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::invalidCssProvider
     */
    public function testReturnsFalseWhenGivenInvalidCss($input) {
        $isValid = $this->obj->isValid($input);
        if ( TheCodeTrainCssValidator::NO_VALIDATOR_RESPONSE === $isValid ) {
            $this->markTestSkipped();
        }
        $this->assertFalse($isValid);
    }
    
}
?>