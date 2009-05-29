<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinterProviders {
    const DEFAULT_LINT_COMMAND = "java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js";
    
    public static function validJsProvider() {
        return array(
            array('var alice="bob";'),
        );
    }

    public static function invalidJsProvider() {
        return array(
            array('<p>Some text</pee>'),
            array('itvehrb jgskhg; fstoiaeoyufsfgoi'),
            array("p { bllllllllah;"),
            array("var alice='bob'"),
            array("var alice='bob;"),
            array("var alice='bob"),
        );
    }
    
    public static function validJsWithOptionsProvider() {
        return array(
            array(array('var alice = "bob";', array('options'=>TheCodeTrainJsLinter::OPTIONS_RECOMMENDED))),
            array(array('var alice = "bob";', array('options'=>TheCodeTrainJsLinter::OPTIONS_GOOD_PARTS))),
            array(array('var alice = "bob";', array('options'=>'/*jslint white: true */'))),
            array(array('file://assets/js/valid/valid.js', array('options'=>TheCodeTrainJsLinter::OPTIONS_RECOMMENDED))),
        );
    }

    public static function invalidJsWithOptionsProvider() {
        return array(
            array(array('var alice= "bob";', array('options'=>TheCodeTrainJsLinter::OPTIONS_RECOMMENDED))),
            array(array('var alice= "bob";', array('options'=>TheCodeTrainJsLinter::OPTIONS_GOOD_PARTS))),
            array(array('var alice= "bob";', array('options'=>'/*jslint white: true */'))),
            array(array('file://assets/js/invalid/invalid.js', array('options'=>TheCodeTrainJsLinter::OPTIONS_RECOMMENDED))),
        );
    }
    
    public static function validLintCommandProvider() {
        $lint_command = getenv( 'FETS_TEST_JS_LINT_COMMAND' );
        if ( empty( $lint_command ) ) {
            $lint_command = self::DEFAULT_LINT_COMMAND;
        }
        return array(
            array( $lint_command ),
        );
    }
    
    public static function invalidLintCommandProvider() {
        return array(
            // Totally mangled lint command
            array( "java or.molla.jaaript.tos.she.Man ~/Libry/JSLt/jsli.js" ),
            // Missing JSLint
            array( "java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/this-jslint-does-not-exist.js" ),
            // Missing Rhino
            array( "java nonexistant.java.class.for.rhino.Main ~/Library/JSLint/this-jslint-does-not-exist.js" ),            
        );
    }
    
}

?>