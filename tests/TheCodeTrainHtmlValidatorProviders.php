<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidatorProviders {
    
    const DTD_401_STRICT_EXTENDED = '<!DOCTYPE HTML SYSTEM "http://dtd:8888/401_strict_extended.dtd">';
    
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

    public static function validHtmlChunkWithOptionsProvider() {
        return array(
            array(array('<p>Some text</p>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_BODY
            ))),
            array(array('<title>Some Title</title>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK,
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_HEAD
            ))),
            array(array('<div><iframe src="fishy.html"></iframe></div>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK,
                'doctype_override'=>self::DTD_401_STRICT_EXTENDED,
            ))),
            array(array('<ol start="5"><li>list item</li></ol>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK,
                'doctype_override'=>self::DTD_401_STRICT_EXTENDED,
            ))),
        );
    }

    public static function invalidHtmlChunkProvider() {
        return array(
            array('<p>Some text</pee>'),
            array('<p>Two errors in this<img src="whee.png"></pee>'),
            array("<title>This can't go in the body</title>"),
            array("<b><u>hello</b></u>"),
            array("<b><u>hello</b>"),
            array('<iframe src="fishy.html"></iframe>'),
            array('<ol start="5"><li>list item</li></ol>'),
        );
    }

    public static function invalidHtmlChunkWithOptionsProvider() {
        return array(
            array(array('<p>Some text</pee>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_BODY
            ))),
            array(array('<p>Two errors in this<img src="whee.png"></pee>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_BODY
            ))),
            array(array("<title>This can't go in the body</title>", array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_BODY
            ))),
            array(array("<p>This can't go in the head</p>", array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_HEAD
            ))),
            array(array('<p>Some text</pee>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_HEAD
            ))),
            array(array('<p>Two errors in this<img src="whee.png"></pee>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK, 
                'document_section_position'=>TheCodeTrainHtmlValidator::POSITION_HEAD
            ))),
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