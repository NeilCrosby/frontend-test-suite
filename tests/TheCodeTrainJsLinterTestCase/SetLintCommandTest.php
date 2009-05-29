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
            $this->obj->getLintErrors('var foo = "this is an unterminated string');
        } catch (PHPUnit_Framework_SkippedTestError $e) {
            $this->fail();
        }
    }

    /**
     * @dataProvider TheCodeTrainJsLinterProviders::invalidLintCommandProvider
     **/
    public function testSkipsTestWhenBadLintCommandGiven($input) {
        $this->obj = new ConcreteJsLinterTestCase();
        $this->obj->setLintCommand( $input );
        try {
            $this->obj->getLintErrors('var foo = "this is an unterminated string');
        } catch (PHPUnit_Framework_SkippedTestError $e) {
            // If this gets fired, the test has passed. Therefore, return!
            // This is fired because when a test is marked as skipped a
            // PHPUnit_Framework_SkippedTestError error is fired.  We can't
            // test for this the normal way, with a setExpectedException,
            // because doing that still results in the inner test being shown
            // as having been skipped when we run this test.
            return;
        }
        
        // Therefore, if we get to here, the test has failed.
        $this->fail();
    }
}
?>