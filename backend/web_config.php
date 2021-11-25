
<?php
    function load_top()
    {
        require('top.php');
    }
    function load_footer()
    {
        require('footer.php');
    }
    
?>
<?php
    function ch_title($title){
    $output = ob_get_contents();
    if ( ob_get_length() > 0) { ob_end_clean(); }
    $patterns = array("/<title>(.*?)<\/title>/");
    $replacements = array("<title>$title</title>");
    $output = preg_replace($patterns, $replacements,$output);
    echo $output;
}
?>