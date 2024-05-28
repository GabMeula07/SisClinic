<?php

session_start();
if($_SESSION['id_user']){
    $SESSION = array();
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),'', time()-300000,'/');
    }
    session_destroy();
}
setcookie('id_user','', -50000,'/');
setcookie('email','', -50000,'/');
$url = 'http://' . $_SERVER['HTTP_HOST'];
header('Location: ' . $url);


