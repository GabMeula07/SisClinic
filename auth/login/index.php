<?php
session_start();
$title = 'Entrar';
require_once('../../config.php');

if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {

        if (!empty($_POST['email']) && !empty($_POST['pwd'])) {

        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['pwd']);

        $query = "SELECT * FROM usuario"
            . " WHERE email='$email' AND pwd=SHA('$password')";

        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_array($result);
            setcookie('id_user', $row['id_user'], time() + 60 * 60 * 24 * 30);
            setcookie('email', $row['email'], time() + 60 * 60 * 24 * 30);
            $_SESSION["id_user"] = $row["id_user"];
            $_SESSION['email'] = $row['email'];

            $url = 'http://' . $_SERVER['HTTP_HOST'];
            header('Location: ' . $url);
        } else {
            echo '<span class="error"><p>Email ou senha inválido.</p></span>';
        }
    }
    else{
        echo '<span class="error"><p>É necessário digitar todos os campos</p></span>';
    }
    }
}
require_once('../../templates/head_html.php');
?>

<link rel="stylesheet" href="../../assets/css/auth.css">
<link rel="stylesheet" href="../../assets/css/index.css">
</head>

<body>
    <main>
        <div class="container">

            <h1>Entrar</h1>
            <h2>A apenas um passo do seu espaço!</h2>
            <form action="<?PHP $_SERVER['PHP_SELF'] ?>" method="post">
                <input class="campo" type="email" name="email" id="email" placeholder="Email" />
                <input class="campo" type="password" name="pwd" id="pwd" placeholder="Senha" />
            
            <div class="form-buttons">
                <input class="submit" type="submit" value="Enviar" name="submit" />
                <a href="<?php
                            echo 'http://' . $_SERVER['HTTP_HOST'] . '/auth/register/'
                            ?>">Ainda não tenho conta</a>
            </div>
            </form>
        </div>
    </main>
</body>

</html>