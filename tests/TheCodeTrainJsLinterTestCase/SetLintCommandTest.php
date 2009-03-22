<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinterTestCase_SetLintCommandTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::validLintCommandProvider
     **/
    public function testSettingToGoodCommandResultsInTestOcurring($input) {
        $this->obj = new ConcreteJsLinterTestCase();
        $this->obj->setLintCommand($input);
        try {
            $this->obj->getLintErrors('<p>whatever</pee>');
        } catch (PHPUnit_Framework_SkippedTestError $e) {
            $this->fail();
        }
    }
}
?>