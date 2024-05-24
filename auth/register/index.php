<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once('../../config.php');

if (isset($_POST['submit'])) {
    if (!empty($_POST['email']) && !empty($_POST['pwd']) && !empty($_POST['pwd2'])) {

        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['pwd']);
        $password2 = mysqli_real_escape_string($con, $_POST['pwd2']);

        $query = "SELECT * FROM usuario WHERE email='$email'";
        $result = mysqli_query($con, $query);



        if (mysqli_num_rows($result) > 0) {
            echo '<span class="error"><p>Esse email já está sendo utilizado. </p></span>';
        } else {

            if (!$password != $password2) {
                if (strlen($password) < 8) {
                    echo '<span class="error"><p>A sua senha deve conter mais de 8 caracteres</p></span>';
                } else {
                    $query = "INSERT INTO usuario VALUES (0, '$email',SHA('$password'));";
                    $result = mysqli_query($con, $query) or die('Erro no banco ' . mysqli_error($con));
                    mysqli_close($con);
                    $url = "http://" . $_SERVER['HTTP_HOST'] . '/auth/login/';
                    header('Location: ' . $url);
                }
            } else {
                echo '<span class="error"><p>As duas senhas tem que ser iguais</p></span>';
            }
        }
    } else {
        echo '<span class="error"><p>É necessário digitar todos os campos</p></span>';
    }

    
}

$title='Cadastrar';
?>
<?php require_once('../../templates/head_html.php')?>

  <link rel="stylesheet" href="../../assets/css/auth.css">
  <link rel="stylesheet" href="../../assets/css/index.css">

</head>


<body>
    <main>
    <div class="container">
      <h1>Crie sua conta</h1>
      <h2>O caminho para o seu espaço!</h2>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input class="campo" type="email" name="email" id="email" placeholder="Email" />
        <input class="campo" type="password" name="pwd" id="pwd" placeholder="Senha" />
        <input class="campo" type="password" name="pwd2" id="pwd2" placeholder="Repita sua Senha" />
        <div class="form-buttons">
           <input class="submit" type="submit" value="Enviar" name="submit" />
           <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . '/auth/login/'; ?>">Eu já tenho uma conta</a>
        </div>
      </form>
     </div>
    </main>
    
</body>

</html>