<?php

/**
 * The base TestSuite that I build my test suites from.  It expects a Suite's
 * tests to be contained within a subdirectory with the same name as the base
 * of the suite.  So, if the suite was called `VCardTestSuite` the tests
 * would be in a directory called `VCard`.  Class names follow the PHPUnit
 * style and are a concatenation of the directory and filename.  So, a file
 * named `ExpectedMethodsTest.php` in the directory `VCard` would have the
 * class name of `VCard_ExpectedMethodsTest`. 
 *
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 *
 * Example Usage:
 * 
 *     class VCardTestSuite extends TheCodeTrainBaseTestSuite {
 *          public static function main() {
 *              PHPUnit_TextUI_TestRunner::run(self::suite());
 *          }
 *     
 *          public static function suite() {
 *              $tests = self::getTests(__FILE__);
 *     
 *              $suite = new VCardTestSuite();
 *              foreach ( $tests as $test ) {
 *      			$suite->addTestSuite($test);
 *              }
 *     
 *              return $suite;
 *          }
 *     }
 *     
 **/
class TheCodeTrainBaseTestSuite extends PHPUnit_Framework_TestSuite {
    public static function main() {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    /**
     * Finds all Tests associated with this TestSuite.
     *
     * @param $baseFile the full file path of the calling class
     *
     * @return An array containing the classnames of the associated Tests
     **/
    protected function getTests( $baseFile ) {
        $return = array();
        
        $pathParts = pathinfo($baseFile);
        $dir = $pathParts['dirname'];
        $class = $pathParts['filename'];
        
        $includeDir = substr( $class, 0, -strlen('TestSuite') );
        
        if ($handle = opendir("$dir/$includeDir")) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if ( 'Test.php' == substr($file, -strlen('Test.php')) ) {
                        array_push($return, $includeDir.'_'.substr($file, 0, -strlen('.php')));
                    }
                }
            }
            closedir($handle);
        }
        
        return $return;
    }
 
}

?>