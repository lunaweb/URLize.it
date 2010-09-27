<?php
setlocale(LC_ALL, 'fr_FR@euro'); # or any other locale that can handle multibyte characters.

function replace_newline($string) {
  return (string)str_replace(array("\r", "\r\n", "\n"), '', $string);
}

function urlize($p_string) {
    $p_string = replace_newline($p_string);
    
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
    
    foreach($replacement as $to => $a_from) {
        $p_string = str_replace($a_from, $to, $p_string);
    }
    $p_string = preg_replace('#(-+)#', '-', preg_replace('#[\s]+#', '-', rtrim(trim(preg_replace('#[^a-z0-9_.\s]#', ' ', mb_strtolower($p_string, mb_internal_encoding()))))));

    return $p_string;
}

function file_adresse($p_file, $ext = true, $fullpath = false) {
    
    $a_info = pathinfo($p_file);
    $dirname = implode('/', array_map('urlize', explode('/', $a_info['dirname'])));
    
    if ($fullpath)
        return $dirname.'/'.urlize($a_info['filename']).'.'.mb_strtolower($a_info['extension']);
    
    if ($ext && !empty($a_info['extension']))
        return urlize($a_info['filename']).'.'.mb_strtolower($a_info['extension']);
    else 
        return urlize($a_info['filename']);
}