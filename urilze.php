<?php

/**
 * replace_newline function
 * Returns unix (\n) linebreaks
 *
 * @return string
 * @author Kaelig
 * @param string $string A multibyte string
 **/

function replace_newline( $string ) {
    return (string)str_replace(array("\r", "\r\n", "\n"), '', $string);
}

/**
 * slugify function
 * Converts a multibyte string to an slugified string
 *
 * @return string
 * @author Kaelig
 * @param string $string A multibyte string
 * @param string $separator Optional. Default is a dash (-). Sets the separator between words. One char (a dash or an underscore).
 **/

function slugify( $string, $separator = '-' ) {
    
    $string = replace_newline($string);
    
    $replacement = array(
        'a'         =>    array('à', 'á', 'â', 'ã', 'ä', 'å', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å'),
        'ae'        =>    array('æ', 'Æ'),
        'and'       =>    array('&amp;', '&'),
        'c'         =>    array('ç', 'Ç', '©'),
        'd'         =>    array('∂'),
        'e'         =>    array('è', 'é', 'ê', 'ë', 'È', 'É', 'Ê', 'Ë', '€'),
        'i'         =>    array('ì', 'í', 'î', 'ï', 'Ì', 'Í', 'Î', 'Ï'),
        'n'         =>    array('ñ', 'Ñ'),
        'O'         =>    array('Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø'),
        'o'         =>    array('ò', 'ó', 'ô', 'õ', 'ö', 'ø'),
        'oe'        =>    array('œ', 'Œ'),
        'r'         =>    array('®'),
        's'         =>    array('$'),
        'ss'        =>    array('ß'),
        'u'         =>    array('ù', 'ú', 'û', 'ü', 'µ', 'Ù', 'Ú', 'Û', 'Ü'),
        'y'         =>    array('ÿ', 'Ÿ', '¥'),
        'tm'        =>    array('™'),
        'pi'        =>    array('∏', 'π', 'Π'),
        ' '         =>    array("'", "`"),
    );
    
    foreach($replacement as $output => $input) {
        $string = str_replace($input, $output, $string);
    }
    $string = preg_replace('#('.$separator.'+)#', $separator, preg_replace('#[\s]+#', $separator, rtrim(trim(preg_replace('#[^a-z0-9.\s]#', ' ', mb_strtolower($string, mb_internal_encoding()))))));

    return $string;
}


/**
 * urlize function
 * Converts a filename or a path to a properly urlized string
 *
 * @return string
 * @author Kaelig
 * @param string $filename A multibyte string
 * @param bool $showextension Optional. Default is true. Will show the extension at the end of the slugified filename if $filename has an extension
 * @param bool $showfullpath Optional. Default is true. If false, function will return a filename without a directory path.
 * @param string $separator Optional. Default is a dash (-). Sets the separator between words. One char (a dash or an underscore).
 **/

function urlize( $filename, $showextension = true, $showfullpath = true, $separator = '-') {
    
    setlocale(LC_ALL, 'fr_FR@euro'); // Needed for pathinfo to deal with multibyte strings
    
    $pathinfo = pathinfo($filename);
    if (!empty($pathinfo['dirname'])) {
        $pathparts = explode('/', $pathinfo['dirname']);
        $dirname = implode('/', array_map('slugify', $pathparts, array_fill(0, count($pathparts), $separator)));
        if ($showfullpath && $dirname != '.')
            return $dirname.(($dirname == '/') ? '' : '/').slugify($pathinfo['filename'], $separator).'.'.mb_strtolower($pathinfo['extension']);
    }

    if ($showextension && !empty($pathinfo['extension']))
        return slugify($pathinfo['filename'], $separator).'.'.mb_strtolower($pathinfo['extension']);
    else 
        return slugify($pathinfo['filename'], $separator);
}