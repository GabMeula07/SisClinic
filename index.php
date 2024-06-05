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

if (isset($_POST['submit'])) {
  if (
    !empty($_POST['data_agendamento'])
    && !empty($_POST['Sala']) && !empty($_POST['horario'])
  ) {

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $data_agendamento = $_POST['data_agendamento'];
    $sala = $_POST['Sala'];
    $horario = $_POST['horario'];
    $fixo = $_POST['fixo'];


    $insert = "INSERT INTO agendamento" . "(id_agendamento, id_user, data_agendamento, id_sala, id_horario, fixo, data_criacao)
    VALUES(0, $id_user, '$data_agendamento', $sala, $horario, $fixo, now());";

    $r = mysqli_query($con, $insert);
    echo '<span class="error"><p>Horário agendado com sucesso</p></span>';
    mysqli_close($con);
  } else {
    echo '<span class="error"><p>É necessário preencher todos os campos</p></span>';
  }
}

require_once('./templates/head_html.php');
?>
<link rel="stylesheet" href="./assets/css/menu.css">
<link rel="stylesheet" href="./assets/css/index.css">
<link rel="stylesheet" href="./assets/css/padrao.css">

</head>

<body>
  <header>
    <img id="logo" src="./assets/imgs/logo.png" alt="logo">
    <nav>
      <div class="container-menu">
        <a href="#">Agenda</a>
        <a href="#">Meu Perfil</a>
        <?php
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $query = "SELECT * FROM usuario where id_user=$id_user";
        $result = mysqli_query($con, $query);

        $row = mysqli_fetch_row($result);
        if ($row[3] == 1) {
          echo '<a href="#">Administração</a>';
        }

        ?>


      </div>
    </nav>
    <a class="sair" href="/auth/logout/">Sair</a>
  </header>
  <div class="container-titulo">
    <h4>Meus Agendamentos</h4>
  </div>

  <button id="novo_agendamento">Novo Agendamento</button>

  <main>
    <article>
      <h3>Regras de uso</h3>
      <ul>
        <li>Regra 01</li>
        <li>Regra 02</li>
        <li>Regra 03</li>
        <li>Regra 04</li>
      </ul>
    </article>

    <section class="container-agendamento">
    <h3>Horários Agendados</h3>
    <div class="agendado-header"><p>Data </p> <p>Sala </p> <p>Horário </p></div>
      <?php
      $sql_agendamentos = "SELECT data_criacao, data_agendamento, s.nome_sala as sala, h.horario as horario 
          FROM agendamento a, horario h, sala s 
          WHERE id_user=$id_user AND a.id_sala=s.id_sala AND a.id_horario = h.id_horario 
          ORDER BY a.data_agendamento DESC;";
      $result = mysqli_query($con, $sql_agendamentos);


      if (mysqli_num_rows($result) == 0) {
        echo 'Você ainda não tem nenhum agendamento';
      } else {

        while ($row = mysqli_fetch_array($result)) {
          date_default_timezone_set('America/Sao_Paulo');
          $data_agend_raiz = DateTime::createFromFormat('Y-m-d', $row["data_agendamento"]);

          $data_check = (string) $row["data_agendamento"] . " " . $row['horario'];
          $data_check_btn = DateTime::createFromFormat("Y-m-d H:i" , $data_check);
          
          $data_atual_check = new DateTime('now', $timezone);
          
          $timestamp = strtotime($data_check_btn->format('Y-m-d H:i'), false);
          $nova_data = $timestamp - (24*3600);
          $data_24_horas_atras = date('d/m/Y H:i', $timestamp-(24*3600), );


         echo '<div class="agendado">' . '<p> ' . $data_agend_raiz->format('d/m/Y') . '</p><p>' 
          . $row['sala'] . '</p><p> ' . $row['horario'] . '</p>'; 
          
          if ( $data_24_horas_atras > $data_atual_check->format('d/m/Y H:i') ){
            echo "<a href='#'>Cancelar</a>";
          }
          else{
            echo '<a></a>';
          }

         echo '</div>';
        }
      }
      mysqli_close($con);
      ?>
    </section>
  </main>


  <section class="modal closed">
    <div class="header_modal">
      <h2>Novo Agendamento</h2>
      <button id='close'>close</button>
    </div>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

      <div>
        <p>Data: </p>
        <input id="agendamento" name="data_agendamento" type="date" min="<?php echo $data_atual ?>" max="<?php echo $data_limite ?>" />
      </div>
      <div>

        <p>Sala: </p>
        <div class="container-sala">
          <span>
            <input id="sala01" type="radio" name="Sala" value="1">
            <label for="sala01"><img src="./assets/imgs/imgs/sala03/sala03-3.jpeg" alt="Sala01"></label>
          </span>
          <span>
            <input id="sala02" type="radio" name="Sala" value="2">
            <label for="sala02"><img src="./assets/imgs/imgs/sala03/sala03-3.jpeg" alt="Sala01"></label>
          </span>
          <span>
            <input id="sala03" type="radio" name="Sala" value="3">
            <label for="sala03"><img src="./assets/imgs/imgs/sala03/sala03-3.jpeg" alt="Sala01"></label>
          </span>
          <span>
            <input id="sala04" type="radio" name="Sala" value="4">
            <label for="sala04"><img src="./assets/imgs/imgs/sala03/sala03-3.jpeg" alt="Sala01"></label>
          </span>
          <span>
            <input id="sala05" type="radio" name="Sala" value="5">
            <label for="sala05"><img src="./assets/imgs/imgs/sala03/sala03-3.jpeg" alt="Sala01"></label>
          </span>
          <span>
            <input id="sala06" type="radio" name="Sala" value="6">
            <label for="sala06"><img src="./assets/imgs/imgs/sala03/sala03-3.jpeg" alt="Sala01"></label>
          </span>
        </div>
      </div>
      <div>
        <p>Horario</p>
        <select id="disponivel" name="horario">
        </select>
      </div>
      <div class="container-btn">
        <select name="fixo" id="fixo">
          <option value="0">Extra</option>
          <option value="1">Fixo</option>
        </select>
        <input id="btn-submit" type="submit" name="submit" value="Agendar" />
      </div>
    </form>
  </section>





  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="assets/js/verificaHorario.js"></script>
  <script src="assets/js/modal.js"></script>
</body>

</html>