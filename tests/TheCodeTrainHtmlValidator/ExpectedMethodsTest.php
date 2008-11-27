<?php

class TheCodeTrainHtmlValidator_ExpectedMethodsTest extends TheCodeTrainBaseExpectedMethodsTestCase {
    public function setUp() {
        $this->class = 'TheCodeTrainHtmlValidator';
        $this->classFile = __FILE__;
    }

    public function tearDown() {
    }

    public static function expectedMethodsProvider() {
        return array(
            array('__construct'),
            array('isValid'),
            array('getErrors'),
        );
    }
}
?>