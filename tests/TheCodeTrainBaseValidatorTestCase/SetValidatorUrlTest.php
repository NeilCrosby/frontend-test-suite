<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainBaseValidatorTestCase_SetValidatorUrlTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    public function testNotSettingResultsInFailedTest() {
        $this->markTestIncomplete();
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::invalidValidatorUrlProvider
     **/
    public function testSettingToBadUrlResultsInSkippedTest() {
        $this->markTestIncomplete();
    }

    /**
     * @dataProvider TheCodeTrainHtmlValidatorProviders::validValidatorUrlProvider
     **/
    public function testSettingToGoodUrlResultsInSkippedTest() {
        $this->markTestIncomplete();
    }
}

class ConcreteValidatorTestCase extends TheCodeTrainBaseValidatorTestCase {
    
}

?>