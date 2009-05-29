<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainJsLinter {
    
//    const FILE_NOT_FOUND = -2;
    const NO_LINTER_RESPONSE = -1;
    const NO_ERROR = false;

    const FILE_IDENTIFIER = 'file://';
    const HTTP_IDENTIFIER = 'http://';
    
    const OPTIONS_RECOMMENDED = 1;
    const OPTIONS_GOOD_PARTS  = 2;
    
    const LINES_PER_ERROR = 3;
//    
//    protected $errorPointer = array('envBody', 'mmarkupvalidationresponse', 'mresult', 'merrors');
    
    public function __construct($lintCommand=null) {
        if ( !$lintCommand ) {
            throw new Exception('No Lint command given.');
            return false;
        }
        // TODO validate the lint command
        $this->lintCommand = $lintCommand;
    }
    
    public function getErrors() {
        if ( !isset($this->lastResult) || !$this->lastResult || count($this->lastResult) < self::LINES_PER_ERROR  ) {
            return self::NO_ERROR;
        }
        
        $numErrors = intval(count($this->lastResult) / self::LINES_PER_ERROR);
        
        $errors = array();
        for ( $i = 0; $i < $numErrors; $i++ ) {
            preg_match('/line (\d+) character (\d+): (.*)$/', $this->lastResult[self::LINES_PER_ERROR * $i], $matches);
            
            $temp = array();
            $temp['line'] = $matches[1];
            $temp['char'] = $matches[2];
            $temp['error'] = $matches[3];
            $temp['original_line'] = $this->lastResult[self::LINES_PER_ERROR * $i + 1];
            
            array_push($errors, $temp);
        }

        return $errors;
    }
    
    public function isValid($js, $aOptions = array()) {
        $extraRules = '';
        if ( isset($aOptions['options']) ) {
            switch ($aOptions['options']) {
                case self::OPTIONS_RECOMMENDED:
                    $extraRules = "/*jslint white: true, undef: true, nomen: true, eqeqeq: true, newcap: true */";
                    break;
                case self::OPTIONS_GOOD_PARTS:
                    $extraRules = "/*jslint white: true, undef: true, nomen: true, eqeqeq: true, plusplus: true, bitwise: true, regexp: true, onevar: true, newcap: true */";
                    break;
                default:
                    $extraRules = $aOptions['options'];
            }
        }
        
        if ( self::FILE_IDENTIFIER == mb_substr( $js, 0, mb_strlen(self::FILE_IDENTIFIER)) ) {
            // load from file instead of just using the given string
            $file = mb_substr( $js, mb_strlen(self::FILE_IDENTIFIER));
            $js = file_get_contents($file);
        } else if ( self::HTTP_IDENTIFIER == mb_substr( $js, 0, mb_strlen(self::HTTP_IDENTIFIER)) ) {
            // load from http instead of just using the given string
            $js = file_get_contents($js);
        }
        
        // save the JS (along with extra jslint options) to a temporary file
        $file = tempnam( "/tmp", "jslint-" );
        file_put_contents($file, $extraRules."\n".$js);

        // Build lint command to output stderr to OS variant of /dev/null to suppress Java/Rhino error messages.
        $lintCommand = $this->lintCommand . ' ' . $file;
        if ( PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows' ) {
            $lintCommand .= ' 2>nul';
        } else {
            $lintCommand .= ' 2>/dev/null';
        }

        // now actually run the linting command, capturing the exit code
        $exitCode = 0;
        $output = exec( $lintCommand, $result, $exitCode );

        // TODO: throw exceptions or provide error feedback under the error conditions
        // exit codes       output      meaning
        // -------------------------------------
        //  0               -           no linting errors
        //  1               empty       error launching Rhino
        //  1               not empty   jslint could not find temp file
        //  2               not empty   jslint found lintint errors
        //  3               -           ???
        //  4               empty       Rhino couldn't find jslint.js

        unlink( $file );

        $this->lastResult = $result;
        
        // Return no response if we got anything but linting success or failure from linting command
        if ( $exitCode != 0 && $exitCode != 2 ) {
            return self::NO_LINTER_RESPONSE;
        }
        
        return $exitCode == 0;
    }
    
}

#$linter = new TheCodeTrainJsLinter('java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js');
#$linter->isValid("_i=blah;\ncat='dog'");
#print_r($linter->getErrors());
#$linter->isValid("file:///Users/crosby/Sites/hoffify/hoffify.js");
#print_r($linter->getErrors());
#$linter->isValid("file:///Users/crosby/Sites/hoffify/hoffify.js", array('options'=>TheCodeTrainJsLinter::OPTIONS_GOOD_PARTS));
#print_r($linter->getErrors());
#$linter->isValid("file:///Users/crosby/Sites/hoffify/hoffify.js", array('options'=>TheCodeTrainJsLinter::OPTIONS_RECOMMENDED));
#print_r($linter->getErrors());

