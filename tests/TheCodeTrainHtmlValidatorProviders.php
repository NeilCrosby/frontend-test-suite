<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidatorProviders {
    
    public static function fileProvider($path) {
        $return = array();
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    array_push($return, array('file://'.$path.$file));
                }
            }
            closedir($handle);
        }
        return $return;
    }
    
    public static function validHtmlDocumentProvider() {
        return self::fileProvider('assets/html/valid/');
    }
    
    public static function invalidHtmlDocumentProvider() {
        return self::fileProvider('assets/html/invalid/');
    }
    
    public static function validHtmlChunkProvider() {
        return array(
            array('<p>Some text</p>'),
        );
    }

    public static function validHtmlChunkWithPositionProvider() {
        return array(
            array(array('<p>Some text</p>', TheCodeTrainHtmlValidator::POSITION_BODY)),
            array(array('<title>Some Title</title>', TheCodeTrainHtmlValidator::POSITION_HEAD)),
        );
    }

    public static function invalidHtmlChunkProvider() {
        return array(
            array('<p>Some text</pee>'),
            array('<p>Two errors in this<img src="whee.png"></pee>'),
            array("<title>This can't go in the body</title>"),
            array("<b><u>hello</b></u>"),
            array("<b><u>hello</b>"),
        );
    }

    public static function invalidHtmlChunkWithPositionProvider() {
        return array(
            array(array('<p>Some text</pee>', TheCodeTrainHtmlValidator::POSITION_BODY)),
            array(array('<p>Two errors in this<img src="whee.png"></pee>', TheCodeTrainHtmlValidator::POSITION_BODY)),
            array(array("<title>This can't go in the body</title>", TheCodeTrainHtmlValidator::POSITION_BODY)),
            array(array("<p>This can't go in the head</p>", TheCodeTrainHtmlValidator::POSITION_HEAD)),
            array(array('<p>Some text</pee>', TheCodeTrainHtmlValidator::POSITION_HEAD)),
            array(array('<p>Two errors in this<img src="whee.png"></pee>', TheCodeTrainHtmlValidator::POSITION_HEAD)),
        );
    }

    public static function validValidatorUrlProvider() {
        return array(
            array('http://htmlvalidator/check'),
        );
    }
    
    public static function invalidValidatorUrlProvider() {
        return array(
            array('http://thisdefinitelydoesntexist.thecodetrain.co.uk/'),
        );
    }
    
}

?>