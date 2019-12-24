<?php
// auto load classes
spl_autoload_register('myAutoloader');
if (! isset($_SESSION['login'])){
    redirectPage('index.php');
}
/*
-------------Import templates --------------
*/
// set which templates to user_error
$head = 'templates/header.html';
$body = 'templates/admin.html';
$foot = 'templates/footer.html';
$logout = file_get_contents('templates/widgets/sign_out.html');

//load the content of templates
$tpl_a = file_get_contents($head);
$tpl_b = file_get_contents($body);
$tpl_c = file_get_contents($foot);

$tpl_logout = parseTemplate($logout, array('[+username+]' => $_SESSION['login']));
$button = $tpl_logout;
$modal = '';

//build up our header HTML with function text_body
$final  = parseTemplate($tpl_a, array(
	'[+button+]' => $button,
	'[+modal+]' => $modal
));
$final .= $tpl_b;
$final .= parseTemplate($tpl_c, array('[+date+]' => get_year()));

//display our template file with all placeholders
$content = $final;
echo $content;
