<?php
require_once 'library/simple_html_dom.php';
$html = 'MIERDA!';
if (isset($_GET['r']) && filter_var($_GET['r'], FILTER_VALIDATE_URL)) {
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, $_GET['r']);  
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);  
    $str = curl_exec($curl);  
    curl_close($curl);  

    $html = new simple_html_dom();
    $html->load($str); 

    foreach ($html->find('meta') as $meta) {
        if ($meta->name == 'viewport') {
            $meta->outertext = '';
        }
    }

    foreach ($html->find('img') as $img) {
        $lazy = $img->getAttribute('data-lazy-src');
        if (isset($lazy)) {
            $img->src = $lazy;
        }
    }

    $head = $html->find('head', 0);
    if (isset($head)) {
        $head->innertext = '<meta name="viewport" content="width=device-width,initial-scale=1">' . $head->innertext ;
    } else {
        $main_html = $html->find('html', 0);
        if (isset($main_html)) {
            $main_html->innertext = '<head><meta name="viewport" content="width=device-width,initial-scale=1"></head>' . $main_html->innertext;
        }
    }
    $html->save();
    echo $html;
} 

?>
<script>
(function() {
    readConvertLinksToFootnotes = false;
    readStyle = 'style-apertura';
    readSize = 'size-x-large';
    readMargin = 'margin-x-narrow';
    _readability_script = document.createElement('script');
    _readability_script.type = 'text/javascript';
    _readability_script.src = 'library/read/js/readability.js?x=' + (Math.random());
    document.documentElement.appendChild(_readability_script);
    _readability_css = document.createElement('link');
    _readability_css.rel = 'stylesheet';
    _readability_css.href = 'library/read/css/readability.css?1';
    _readability_css.type = 'text/css';
    _readability_css.media = 'all';
    document.documentElement.appendChild(_readability_css);
    _readability_print_css = document.createElement('link');
    _readability_print_css.rel = 'stylesheet';
    _readability_print_css.href = 'library/read/css/readability-print.css';
    _readability_print_css.media = 'print';
    _readability_print_css.type = 'text/css';
    document.getElementsByTagName('head')[0].appendChild(_readability_print_css);
})()
</script>
