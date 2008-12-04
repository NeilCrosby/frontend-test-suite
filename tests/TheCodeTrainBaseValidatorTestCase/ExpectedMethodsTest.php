<?php

class TheCodeTrainBaseValidatorTestCase_ExpectedMethodsTest extends TheCodeTrainBaseExpectedMethodsTestCase {
    public function setUp() {
        $this->class = 'TheCodeTrainBaseValidatorTestCase';
        $this->classFile = __FILE__;
    }

    public function tearDown() {
    }

    public static function expectedMethodsProvider() {
        return array(
            array('setValidatorUrl'),
            array('getValidationError'),
        );
    }
}
?>