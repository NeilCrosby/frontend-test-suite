<?php

if ( !function_exists('__autoload') ) {
    function __autoload($class) {
        $class = str_replace( '_', '/', $class );
        $aLocations = array('../suite', '.');

        foreach( $aLocations as $location ) {
            $file = "$location/$class.php";
            if ( file_exists( $file ) ) {
                include_once( $file );
                return;
            }
        }

        // Check to see if we managed to declare the class
        if (!class_exists($class, false)) {
            trigger_error("Unable to load class: $class", E_USER_WARNING);
        }
    }
}

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainBaseValidatorTestCaseTestSuite extends TheCodeTrainBaseTestSuite {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite() {
        $tests = self::getTests(__FILE__);

        $suite = new TheCodeTrainBaseValidatorTestCaseTestSuite();
        foreach ( $tests as $test ) {
            $suite->addTestSuite($test);
        }

        return $suite;
    }
    
    protected function setUp() {
    }
 
    protected function tearDown() {
    }
}

class ConcreteValidatorTestCase extends TheCodeTrainBaseValidatorTestCase {

}

if (PHPUnit_MAIN_METHOD == 'TheCodeTrainBaseValidatorTestCaseTestSuite::main') {
     TheCodeTrainHtmlValidatorTestSuite::main();
}
?>