<?php
// auto load classes
spl_autoload_register('myAutoloader');
/*
-------------Import templates --------------
*/
// set which templates to user_error
$head = 'templates/header.html';
$body = 'templates/home.html';
$foot = 'templates/footer.html';
$loginWidget = file_get_contents("templates/widgets/login_modal.html");
$login_button = file_get_contents("templates/widgets/sign_in.html");
$logout = file_get_contents('templates/widgets/sign_out.html');

//load the content of templates
$tpl_a = file_get_contents($head);
$tpl_b = file_get_contents($body);
$tpl_c = file_get_contents($foot);

if (isset($_SESSION['login'])) {
    $tpl_logout = parseTemplate($logout, array('[+username+]' => $_SESSION['login']));
    $button = $tpl_logout;
    $modal = '';
} else {
    $button = $login_button;
    $modal = $loginWidget;
}

//build up our header HTML with function text_body
$final = parseTemplate($tpl_a, array(
    '[+button+]' => $button,
    '[+modal+]' => $modal
));
$data = DB::getInstance()->find('Select Image, Story from information where ID = ?', array(1));
$img = 'images/db_portfolio/' . $data[0]['Image'];
$story = htmlspecialchars_decode($data[0]['Story']);
$final .= parseTemplate($tpl_b, array(
    '[+img+]' => $img,
    '[+story+]' => $story
));
$final .= parseTemplate($tpl_c, array('[+date+]' => get_year()));

//display our template file with all placeholders
$content = $final;
echo $content;


