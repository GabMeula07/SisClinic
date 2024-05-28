<?php
session_start();
if (!isset($_SESSION["id_user"])) {
  if (isset($_COOKIE['id_user']) && isset($_COOKIE['email'])) {
    $_SESSION['email'] = $_COOKIE['email'];
    $_SESSION['id_user'] = $_COOKIE['id_user'];
  } else {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="psicosaude"');
    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/auth/login/';
    header('Location: ' . $url);
  }
}

$id_user = $_SESSION['id_user'];

require_once('./config.php');
$title = 'Agendamentos';

$data_atual = date('Y-m-d');
$data_limite = date('Y-m-d', strtotime('+15 days'));

require_once('./templates/head_html.php');
?>
<link rel="stylesheet" href="./assets/css/menu.css">
<link rel="stylesheet" href="./assets/css/index.css">
</head>

<body>
  <header>
    <img id="logo" src="./assets/imgs/logo.png" alt="logo">
    <nav>
      <a href="#">Agendamentos</a>
      <a href="#">Meu Perfil</a>
      <?php
      $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $query = "SELECT * FROM usuario where id_user=$id_user";
      $result = mysqli_query($con, $query);

      $row = mysqli_fetch_row($result);
      if ($row[3] == 1) {
        echo '<a href="#">Administração</a>';
      }
      mysqli_close($con);
      ?>
      <a href="/auth/logout/">Sair</a>
    </nav>
  </header>

  <h1>Bem vindo! </h1>

  <section class="modal">
    
    <form action="<?php $_SERVER['PHP_SELF'] ?>">
      <input id="agendamento" type="date" min="<?php echo $data_atual ?>" max="<?php echo $data_limite ?>" />
      <span>
        <input type="radio" name="Sala" id="" value="1" checked>
        <img src="" alt="Sala01" >
      </span>
      <span>
        <input type="radio" name="Sala" id="" value="2">
        <img src="" alt="Sala02">
      </span>
      <span>
        <input type="radio" name="Sala" id="" value="3">
        <img src="" alt="Sala03">
      </span>
      <span>
        <input type="radio" name="Sala" id="" value="4">
        <img src="" alt="Sala04">
      </span>
      <span>
        <input type="radio" name="Sala" id="" value="5">
        <img src="" alt="Sala05">
      </span>
      <span>
        <input type="radio" name="Sala" id="" value="6">
        <img src="" alt="Sala06">
      </span>

      <select id="disponivel">

      </select>

    </form>

  </section>
</body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="assets/js/verificaHorario.js"></script>

</html>