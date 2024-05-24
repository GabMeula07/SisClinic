<?php
    session_start();
    if(!isset($_SESSION["id_user"])){
      if(isset($_COOKIE['id_user']) && isset($_COOKIE['email'])){
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['id_user'] = $_COOKIE['id_user'];
      }
      else{
          header('HTTP/1.1 401 Unauthorized');
          header('WWW-Authenticate: Basic realm="psicosaude"');
          $url='http://' . $_SERVER['HTTP_HOST'] . '/auth/login/' ;
          header('Location: '. $url);
      }  
    }

    require_once('./templates/head_html.php');
?>

  </head>
  <body>
    <h1>SALA PSICO SAUDE</h1>
  </body>
</html>