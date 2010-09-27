<?php
include 'urilze.php';
// echo var_dump(stripslashes(htmlspecialchars($_POST['file_list'])));
// exit;
$dashes_or_underscores = (!empty($_POST['dashes_or_underscores'])) ? '_' : '-';
$file_list = !empty($_POST['file_list']) ? stripslashes(htmlspecialchars($_POST['file_list'])) : '';
    
if(!empty($file_list)) {
    
    $files = explode("\n", $file_list);
    
    $urlized_files = array();
    
    foreach($files as $file) {
        if (trim(rtrim($file)) != '')
            $urlized_files[] = array(
                'name'      =>    $file,
                'url'       =>    urlize($file, true, true, $dashes_or_underscores)
            );
    }
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>URLize.it</title>
    <meta name="Description" content="This tool turns dirty filenames into url-friendly filenames. Great to use before uploading files containing entities in their filenames." />
    <link rel="stylesheet" type="text/css" href="screen.css?v4" media="screen" />
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-7077758-6']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>
<body>
    <div class="headWrapper">
        <div class="head tinier">
            <h1><a href="http://urlize.it">URLize.it</a></h1>
            <h2>Thi$ HøRriBLE Fil€ näme.PDF <span>is-far-cleaner-this-way.pdf</span></h2>
            <p>Sometimes, clients email you documents with weird filenames. URLize the hell out of em.</p>
        </div>
    </div>

    <div class="page">
        <div class="body">
            
            <?php    if(!empty($urlized_files)):    ?>
            <div class="data simpleTable spec">
                    
                <table>
                    <caption class="h3">Great! We cleaned up your filenames:</caption>
                    <colgroup>
                        <col width="45%" />
                        <col width="55%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="firstTh">Old filename</th>
                            <th>New filename</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach($urlized_files as $file) {
                        echo '
                        <tr>
                            <th><small>'.$file['name'].'</small></th>
                            <td><input type="text" value=\''.$file['url'].'\' onclick="this.select()" style="width: 500px" /></td>
                        </tr>';
                    }

                    ?>
                    </tbody>
                </table>
            </div>

            <?php    endif;    ?>

            <form action="./" method="post">
                <div class="line">
                    <div class="unit size3of5">
                        <p class="txtC">
                            <label for="file_list">Paste some dirty filenames here,<span>we'll clean them up for you.</span></label>
                            <textarea name="file_list" id="file_list" rows="5" cols="40"><?php  if(!empty($file_list)) { echo $file_list; } ?></textarea>
                            <br />
                            <input type="submit" class="button" value="URLize.it!" /><a href="#void" id="showhelp">Need help?</a>
                        </p>
                    </div>
                    <div class="unit size2of5 lastUnit">
                         <fieldset>
                            <legend>Are you <strong>underscores or dashes</strong>?</legend>
                            <label for="dashes_or_underscores_1" class="label"><input type="radio" name="dashes_or_underscores" id="dashes_or_underscores_1" class="check-radio" value="0"<?php echo (($dashes_or_underscores == '-') ? ' checked="checked"' : ''); ?> /> format-with-dashes</label>
                            <label for="dashes_or_underscores_0" class="label"><input type="radio" name="dashes_or_underscores" id="dashes_or_underscores_0" class="check-radio" value="1"<?php echo (($dashes_or_underscores == '_') ? ' checked="checked"' : ''); ?> /> or_with_underscores</label>
                        </fieldset>
                    </div>
                </div>
                <div class="line" id="infotip" style="display: none;">
                    <div class="unit size3of5" style="position: relative;">
                        <span class="help"></span>
                        <div class="infotip">
                            <div class="inner tinier">
                                <div class="hd">
                                    <h4>Hold on, so how does it work?<br /><small>See for yourself: copy-paste these filenames into the text field above.</small></h4>
                                </div>
                                <div class="bd">
                                    <p class="code">/My Documents/Pictures/kïds/My kid is So-cute !.JPG<br />Thi$ öne îs tri©kiê®.xls<br />/tHis/path is/ ñot good/my doc.txt</p>
                                    <br />
                                    <p><strong>Mac tip:</strong> Select files in the Finder, hit +C and paste them directly in the text field.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="foot">
            <p class="right"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="kaelig" data-url="http://urlize.it" data-text="URLize.it: an easy way to get clean, url-friendly filenames.">Tweet</a></p>
            
            <p>
                URLize.it is an easy to use filename cleaning tool crafted by <a href="http://twitter.com/kaelig">Kaelig</a>, front-end developer at <a href="http://www.lunaweb.fr">LunaWeb</a>.<br />
                Support and suggestions: <a href="mailto:&#x6B;&#x61;&#x65;&#x6C;&#x69;&#x67;&#x40;&#x64;&#x65;&#x6C;&#x6F;&#x75;&#x6D;&#x65;&#x61;&#x75;&#x2E;&#x66;&#x72;?subject=URLize.it%20Support">kaelig@deloumeau.fr</a>.<br />
                An API is currently under developement. <strong>I need beta testers</strong>, please <a href="mailto:&#x6B;&#x61;&#x65;&#x6C;&#x69;&#x67;&#x40;&#x64;&#x65;&#x6C;&#x6F;&#x75;&#x6D;&#x65;&#x61;&#x75;&#x2E;&#x66;&#x72;?subject=URLize.it%20API%20Beta%20test">email-me</a>.
            </p>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> 
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('textarea').change(function() {
                if ($(this).val() != '') {
                    $('label[for=file_list]:visible').fadeOut();
                }
                else {
                    $('label[for=file_list]').delay(500).fadeIn();
                }
            }).focus(function() {
             $(this).change();
            }).click(function() {
             $(this).change();
            }).keyup(function() {
             $(this).change();
            });
            
            if ($('textarea').val() != '') {
                $('label[for=file_list]').hide();
            }
            
            $('#showhelp').click(function() {
                $('#infotip').fadeIn();
                return false;
            });
        });
        
    </script>
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</body>
</html>