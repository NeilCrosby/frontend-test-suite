<?php

//require_once('TheCodeTrainBaseTestSuite.php');

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

class TheCodeTrainHtmlValidatorTestSuite extends TheCodeTrainBaseTestSuite {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite() {
        $tests = self::getTests(__FILE__);

        $suite = new TheCodeTrainHtmlValidatorTestSuite();
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

if (PHPUnit_MAIN_METHOD == 'TheCodeTrainHtmlValidatorTestSuite::main') {
     TheCodeTrainHtmlValidatorTestSuite::main();
}
?>