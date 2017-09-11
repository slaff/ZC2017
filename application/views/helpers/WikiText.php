<?php

/**
 * Filter for rendering wiki text as HTML
 *
 */
class Zend_View_Helper_WikiText extends Zend_View_Helper_Abstract
{
    public function wikitext($value)
    {
        // handle bold text
        $value = preg_replace('/{{{(.*?)}}}/', '<span class="bold">$1</span>', $value);
        
        // handle H2 text
        $value = preg_replace('/{{(.*?)}}/', '<span class="header2">$1</span>', $value);
        
        // handle H1 text
        $value = preg_replace('/{(.*?)}/', '<span class="header1">$1</span>', $value);
        
        // handle url links
        $value = preg_replace('/\[(.*?)\|(.*?)\]/', '<a href="$2" target="_blank">$1</a>', $value);
        
        // handle internal url links 
        $value = preg_replace('/\[(.*?)\]/', '<a href="/article/view/title/$1">$1</a>', $value);
        
        // Handle linebreaks
        $value = nl2br($value);

        return $value;
    }
}
