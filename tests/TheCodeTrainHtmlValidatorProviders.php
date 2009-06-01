<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainHtmlValidatorProviders {
    const DEFAULT_VALIDATOR_URL = 'http://htmlvalidator/check';
    const DEFAULT_ASSETS_BASE_URL = 'http://dtd:8888/';
    const DTD_401_STRICT_EXTENDED = '<!DOCTYPE HTML SYSTEM "{assets-base-url}/dtd/401_strict_extended.dtd">';
    
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
        $assets_base_url = getenv( 'FETS_TEST_ASSETS_BASE_URL' );
        if ( empty( $assets_base_url ) ) {
            $assets_base_url = self::DEFAULT_ASSETS_BASE_URL;
        }
        
        $doctype = strtr( self::DTD_401_STRICT_EXTENDED, array(
            '{assets-base-url}' => $assets_base_url 
        ) );
        
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
                'doctype_override'=>$doctype,
            ))),
            array(array('<ol start="5"><li>list item</li></ol>', array(
                'document_section'=>TheCodeTrainHtmlValidator::HTML_CHUNK,
                'doctype_override'=>$doctype,
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
        $validator_url = getenv( 'FETS_TEST_HTML_VALIDATOR_URL' );
        if ( empty( $validator_url ) ) {
            $validator_url = self::DEFAULT_VALIDATOR_URL;
        }
        return array(
            array( $validator_url )
        );
    }
    
    public static function invalidValidatorUrlProvider() {
        return array(
            array('http://thisdefinitelydoesntexist.thecodetrain.co.uk/'),
        );
    }
    
    public static function validHtmlWithDoctypeOverrideProvider() {
        $assets_base_url = getenv( 'FETS_TEST_ASSETS_BASE_URL' );
        if ( empty( $assets_base_url ) ) {
            $assets_base_url = self::DEFAULT_ASSETS_BASE_URL;
        }
        
        $doctype = strtr( self::DTD_401_STRICT_EXTENDED, array(
            '{assets-base-url}' => $assets_base_url 
        ) );
        
        return array(
            // External file
            array( 
                $assets_base_url . '/html/invalid/valid-401-strict-extended.html',
                array(
                    'doctype_override' => $doctype
                )
            ),
            // Local file
            array(
                'file://' . dirname( __FILE__ ) . '/assets/html/invalid/valid-401-strict-extended.html',
                array(
                    'doctype_override' => $doctype
                )
            ),
            // HTML Chunk
            array(
                '<ol start="5"><li>foo</li></ol>',
                array(
                    'doctype_override' => $doctype,
                    'document_section' => TheCodeTrainHtmlValidator::HTML_CHUNK,
                    'document_section_position' => TheCodeTrainHtmlValidator::POSITION_BODY
                )
            )
        );
    }
}

?>