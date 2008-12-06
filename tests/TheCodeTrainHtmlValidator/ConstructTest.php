<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidator_ConstructTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    /**
     * @dataProvider validationUrlProvider
     */
    public function testInstantiatesIfValidationUrlGiven( $input ) {
        $obj = new TheCodeTrainHtmlValidator($input);
        $this->assertThat(
            $obj,
            $this->isInstanceOf('TheCodeTrainHtmlValidator')
        );
    }

    public function testExceptionRaisedIfNoValidationUrlGiven( ) {
        $this->setExpectedException('Exception');
        $obj = new TheCodeTrainHtmlValidator();
    }

    public static function validationUrlProvider() {
        return array(
            array('http://somevalidator.localhost'),
        );
    }


}
?>