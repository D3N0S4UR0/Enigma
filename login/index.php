<?php
    session_start();

    // Classe de banco de dados
    require("../php/class.dbconnection.php");

    $erro;
    if (isset($_POST['username']) && isset($_POST['password']) && 
        trim($_POST['username']) != "" && trim($_POST['password']) != "" && 
        filter_var($_POST['username'])) {
        
        try {
            $conn = new Connection();
            $result = $conn->runQuery("select uPassword, uConfirmed from E_User where uName = ?", array($_POST['username']));
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        
        if (count($result) == 0) {
            $erro = "Combinação de usuário e senha incorreta";
        } else {
            if (!password_verify($_POST['password'], $result[0]["uPassword"])) {
                $erro = "Combinação de usuário e senha incorreta";
            } else if ($result[0]["uConfirmed"] == 0) {
                $erro = "Conta não foi ativada";
            } else {
                $_SESSION['username'] = $_POST['username'];
                header("Location: ../jogo/");
            }
        } 
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="icon" href="../favicon.png">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <meta charset="utf-8">
    </head>
    <body id="body-login">
        <a id="voltar-login" href="../">Voltar</a>
        <h1>Login</h1>
        <form class="box" id="form-signup" method="POST">
            <input type="text" name="username" required placeholder="Usuário">
            <input type="password" name="password" required placeholder="Senha">
            <input id="form-submit" type="submit" value="Entrar">
        </form>
        <?php
            if (isset($erro)) {
                echo $erro;
            }
        ?>
    </body>
</html>