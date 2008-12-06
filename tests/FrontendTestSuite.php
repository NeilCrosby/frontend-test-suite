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
class FrontendTestSuite extends PHPUnit_Framework_TestSuite {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite() {
        // TODO do something similar to TheCodeTrainBaseTestSuite to
        // automagically find other TestSuites in this directory and add them.
        $suite = new FrontendTestSuite();
        $suite->addTestSuite('TheCodeTrainBaseValidatorTestCaseTestSuite');
        $suite->addTestSuite('TheCodeTrainHtmlValidatorTestSuite');
        return $suite;
    }
 
    protected function setUp() {
    }
 
    protected function tearDown() {
    }
}


if (PHPUnit_MAIN_METHOD == 'FrontendTestSuite::main') {
     TTWRTestSuite::main();
}
?>