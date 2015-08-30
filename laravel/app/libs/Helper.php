<?php

class Helper {

    public static function splitStringIntoParagraphs($string, $attribs = null)
    {
        $paragraphs = preg_split('#(\r\n?|\n)+#', $string);
        $return = '';

        foreach ($paragraphs as $paragraph)
        {
            $return .= '<p' . Helper::parseAttributes($attribs) .'>' . $paragraph . '</p>';
        }

        return $return;
    }

    public static function splitStringIntoListItems($string, $attribs = null)
    {
        $items = preg_split('#(\r\n?|\n)+#', $string);
        $return = '';

        foreach ($items as $item)
        {
            $return .= '<li' . Helper::parseAttributes($attribs) .'>' . $item . '</li>';
        }

        return $return;
    }

    private static function parseAttributes($attribs = null)
    {
        $attrib = '';

        if( ! is_null($attribs))
        {
            foreach ($attribs as $key => $value)
            {
                $attrib .= ' ' . $key . '="' . $value . '"';
            }
        }

        return $attrib;
    }
}