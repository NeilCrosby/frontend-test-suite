<?php
#require_once('TheCodeTrainJsLinter.php');
#require_once('/Applications/MAMP/bin/php5/lib/php/PHPUnit/Framework/TestCase.php');

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
abstract class TheCodeTrainJsLinterTestCase extends PHPUnit_Framework_TestCase {
    
    protected $listCommand = '';
    
    public function setLintCommand($command) {
        $this->listCommand = $command;
    }
   
    public function getLintErrors($input, $options = array()) {
        $validator = new TheCodeTrainJsLinter($this->listCommand);
        $isValid = $validator->isValid($input, $options);
        
        if ( TheCodeTrainJsLinter::NO_LINTER_RESPONSE === $isValid ) {
            $this->markTestSkipped('No Linter');
        } else if ( $isValid ) {
            return false;
        }
        
        $result = $validator->getErrors();
        
        return $result;
    }
}

#class ConcreteLinterTestCase extends TheCodeTrainJsLinterTestCase {}
#
#$linter = new ConcreteLinterTestCase();
#$linter->setLintCommand('java org.mozilla.javascript.tools.shell.Main ~/Library/JSLint/jslint.js');
#$result = $linter->getLintErrors("_i=blah;\ncat='dog'");
#print_r($result);

?>