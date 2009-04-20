<?php
ini_set('display_errors', true);

require_once( 'PHPUnit/Framework/TestCase.php' );
require_once( 'PHPUnit/TextUI/TestRunner.php' );

if ( !function_exists('__autoload') ) {
    function __autoload($class) {
        $class = str_replace( '_', '/', $class );

        if ( file_exists( $class.'.php' ) ) {
            include_once( $class.'.php' );
            return;
        }

        $aLocations = array('.', dirname(__FILE__));

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

class TheCodeTrainEasyFrontendTestSuite extends PHPUnit_Framework_TestSuite {
    
    public static $aOptions = array();
    
    public static function suite($aOptions = array()) {
        self::$aOptions = $aOptions;
        
        $suite = new TheCodeTrainEasyFrontendTestSuite();
        $suite->addTestSuite('TheCodeTrainEasyFrontendTestSuiteHtmlValidatorTestCase');
        $suite->addTestSuite('TheCodeTrainEasyFrontendTestSuiteCssValidatorTestCase');
        $suite->addTestSuite('TheCodeTrainEasyFrontendTestSuiteJsLinterTestCase');

        return $suite;
    }
    
    public static function getValidatorUrl($type='html') {
        if ( !isset(self::$aOptions) || !isset(self::$aOptions[$type]) || !isset(self::$aOptions[$type]['validator']) ) {
            return null;
        }
        return self::$aOptions[$type]['validator'];
    }
    
    public static function dataProvider($type = 'html') {
        if ( !isset(self::$aOptions) || !isset(self::$aOptions[$type]) || !isset(self::$aOptions[$type]['tests']) ) {
            return array();
        }
        
        $tests = self::$aOptions[$type]['tests'];
        
        if ( isset(self::$aOptions[$type]['options']) ) {
            $defaultOptions = self::$aOptions[$type]['options'];
            foreach ( $tests as $key=>$value ) {
                if ( !is_array($value) ) {
                    $value = array($value);
                }
                
                if ( isset($value[1]) ) {
                    $value[1] = array_merge($defaultOptions, $value[1]);
                } else {
                    $value[1] = $defaultOptions;
                }
                $tests[$key] = $value;
            }
        }
        
        foreach ( $tests as $key=>$value ) {
            if ( !is_array($value) ) {
                $value = array($value);
            }
            
            if ( !isset($value[1]) ) {
                $value[1] = array();
            }
            $tests[$key] = $value;
        }
        
        
        return $tests;
    }
    
    public static function htmlProvider() {
        return self::dataProvider('html');
    }
    
    public static function cssProvider() {
        return self::dataProvider('css');
    }
    
    public static function jsProvider() {
        return self::dataProvider('js');
    }
    
}

class TheCodeTrainEasyFrontendTestSuiteHtmlValidatorTestCase extends TheCodeTrainHtmlValidatorTestCase {
    public function setup() {
        $this->setValidatorUrl(TheCodeTrainEasyFrontendTestSuite::getValidatorUrl('html'));
    }
    
    /**
     * @dataProvider TheCodeTrainEasyFrontendTestSuite::htmlProvider
     */
    public function testHtmlValidity($input, $options) {
        $this->assertFalse($this->getValidationErrors($input, $options));
    }
    
}

class TheCodeTrainEasyFrontendTestSuiteCssValidatorTestCase extends TheCodeTrainCssValidatorTestCase {
    public function setup() {
        $this->setValidatorUrl(TheCodeTrainEasyFrontendTestSuite::getValidatorUrl('css'));
    }
    
    /**
     * @dataProvider TheCodeTrainEasyFrontendTestSuite::cssProvider
     */
    public function testCssValidity($input, $options) {
        $this->assertFalse($this->getValidationErrors($input, $options));
    }
    
}

class TheCodeTrainEasyFrontendTestSuiteJsLinterTestCase extends TheCodeTrainJsLinterTestCase {
    public function setup() {
        $this->setLintCommand(TheCodeTrainEasyFrontendTestSuite::getValidatorUrl('js'));
    }
    
    /**
     * @dataProvider TheCodeTrainEasyFrontendTestSuite::jsProvider
     */
    public function testJsValidity($input, $options) {
        $this->assertFalse($this->getLintErrors($input, $options));
    }
    
}

#PHPUnit_TextUI_TestRunner::run(TheCodeTrainEasyFrontendTestSuite::suite(
#    array(
#        'html' => array(
#            'validator' => 'http://htmlvalidator/check',
#            'options' => array(
#                'doctype_override' => null,
#                'document_section' => null,
#                'document_section_position' => null,                
#            ),
#            'tests' => array(
#                array('http://wordpress:8888/'),
#                array('http://htmlvalidator/'),
#                array('file://../tests/assets/html/invalid/valid-401-strict-extended.html', array(
#                    'doctype_override' => '<!DOCTYPE HTML SYSTEM "http://dtd:8888/401_strict_extended.dtd">'
#                )),
#                array('<p>Why hello there</p>', array(
#                    'document_section' => TheCodeTrainHtmlValidator::HTML_CHUNK
#                )),
#            )
#        ),
#        'css' => array(
#            'validator' => 'http://127.0.0.1:8080/css-validator/validator',
#            'options' => array(
#                'exceptions' => null,
#            ),
#            'tests' => array(
#                array('p{display: inline;}'),
#                array('http://htmlvalidator/style/base.css'),
#                array('file://../tests/assets/css/yui-reset-fonts-grids.css', array(
#                    'exceptions' => array(
#                        'yui_hacks' => TheCodeTrainCssValidator::ALLOW,
#                        'star_prop' => TheCodeTrainCssValidator::ALLOW,
#                        'underscore_prop' => TheCodeTrainCssValidator::ALLOW,
#                    )
#                )),
#            )
#        ),
#        'js' => array(
#            'validator' => 'java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js',
#            'options' => array(
#                'options' => null,
#            ),
#            'tests' => array(
#                array('var jane="bob";'),
#                array('file://../tests/assets/js/valid/valid.js'),
#            )
#        )
#    )
#));

?>