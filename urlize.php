<?php
/**
 * URLize.it Functions
 *
 * @author Kaelig
 * @package URLizeIt
 **/

/**
 * replace_newline function
 * Returns unix (\n) linebreaks
 *
 * @author Kaelig
 * @param string $string A multibyte string
 * @return string
 **/

function replace_newline( $string ) {
    return (string)str_replace(array("\r", "\r\n", "\n"), '', $string);
}

/**
 * slugify function
 * Converts a multibyte string to an slugified string
 *
 * @author Kaelig
 * @param string $string A multibyte string
 * @param string $separator Optional. Default is a dash (-). Sets the separator between words. One char (a dash or an underscore).
 * @return string
 **/

function slugify( $string, $separator = '-' ) {
    
    $string = replace_newline($string);
    
    $replacement = array(
        'a'         =>    array('à', 'á', 'â', 'ã', 'å', 'À', 'Á', 'Â', 'Ã', 'Å'),
        'ae'        =>    array('æ', 'Æ', 'ä', 'Ä'),
        'and'       =>    array('&amp;', '&'),
        'c'         =>    array('ç', 'Ç', '©'),
        'd'         =>    array('∂'),
        'e'         =>    array('è', 'é', 'ê', 'ë', 'È', 'É', 'Ê', 'Ë', '€'),
        'i'         =>    array('ì', 'í', 'î', 'ï', 'Ì', 'Í', 'Î', 'Ï'),
        'n'         =>    array('ñ', 'Ñ'),
        'o'         =>    array('ò', 'ó', 'ô', 'õ', 'ø', 'Ò', 'Ó', 'Ô', 'Õ', 'Ø'),
        'oe'        =>    array('œ', 'Œ', 'ö', 'Ö'),
        'r'         =>    array('®'),
        's'         =>    array('$'),
        'ss'        =>    array('ß'),
        'u'         =>    array('ù', 'ú', 'û', 'µ', 'Ù', 'Ú', 'Û'),
        'ue'        =>    array('ü', 'Ü'),
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
 * @author Kaelig
 * @param string $filename A multibyte string
 * @param bool $showextension Optional. Default is true. Will show the extension at the end of the slugified filename if $filename has an extension
 * @param bool $showfullpath Optional. Default is true. If false, function will return a filename without a directory path.
 * @param string $separator Optional. Default is a dash (-). Sets the separator between words. One char (a dash or an underscore).
 * @return string
 **/

function urlize( $filename, $showextension = true, $showfullpath = true, $separator = '-') {
    
    setlocale(LC_ALL, 'fr_FR@euro'); // Needed for pathinfo to deal with multibyte strings
    
    $pathinfo = pathinfo($filename);
    if (!empty($pathinfo['dirname'])) {
        $pathparts = explode('/', $pathinfo['dirname']);
        $dirname = implode('/', array_map('slugify', $pathparts, array_fill(0, count($pathparts), $separator)));
        if ($showfullpath && $dirname != '.') {
            return $dirname.(($dirname == '/') ? '' : '/')
                .slugify($pathinfo['filename'], $separator)
                .(($showextension && !empty($pathinfo['extension'])) ? '.'.mb_strtolower($pathinfo['extension']) : '');
        }
    }

    if ($showextension && !empty($pathinfo['extension']))
        return slugify($pathinfo['filename'], $separator).'.'.mb_strtolower($pathinfo['extension']);
    else 
        return slugify($pathinfo['filename'], $separator);
}