<?php
    // Classes de e-mail e banco de dados
    require_once("../php/phpmailer/class.phpmailer.php");
    require_once("../php/class.dbconnection.php");

    // Função para enviar e-mail
    function EnviarEmail($for, $from, $from_name, $subject, $body) { 
        $mail = new PHPMailer();
        $mail->IsSMTP();		    // Ativar SMTP
        $mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
        $mail->SMTPAuth = true;		// Autenticação ativada
        $mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
        $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
        $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
        $mail->Username = 'enigmaweb42@gmail.com';
        $mail->Password = 'turistadaout25569';
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->IsHTML(true);
        $mail->AddAddress($for);
        if(!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) &&
        trim($_POST['username']) != "" && trim($_POST['email']) != "" && trim($_POST['password']) != "" && trim($_POST['password2']) != "" && 
        filter_var($_POST['username']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        if (strlen($_POST['username']) > 32) {
            $error = "Nome de usuário deve conter no máximo 32 caracteres";
        } else if (strlen($_POST['email']) > 128) {
            $error = "E-mail deve conter no máximo 128 caracteres";
        }
        else if ($_POST['password'] != $_POST['password2']) {
            $error = "Senhas não coincidem";
        } else {
            // Token de confirmação
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            // Hash da senha
            $hash = password_hash($_POST["password"], PASSWORD_DEFAULT); 
            
            try {
                $conn = new Connection();
                $conn->runQuery("E_AddUncorfimedUser ?, ?, ?, ?", array($_POST['username'], $_POST['email'], $hash, $token));
                if (!EnviarEmail($_POST['email'], "enigmaweb42@gmail.com", "Enigma Web", "Confirmar e-mail", "Olá jogador! Bem-vindo ao enigma!<br><a href='http://venus.cotuca.unicamp.br/u16168/coisas/outraaascoisas/enigma-web/cadastro/confirmar.php?token=" . $token . "'>Clique aqui</a> para confirmar seu e-mail e começar a jogar!")) {
                    $error = "Falha ao enviar e-mail de confirmação. Verifique se o e-mail está digitado corretamente ou tente novamente";
                }
                else {
                    $success = "Conta criada! Verifique seu e-mail para validar sua conta! <br> Caso você não receba o e-mail, tente criar uma conta novamente";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro</title>
        <link rel="icon" href="../favicon.png">
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body id="body-cadastro">
        <a id="voltar-cadastro" href="../">Voltar</a>
        <h1>Cadastro</h1>
        <form class="box" id="form-signup" method="POST">
            <div class="form-component">
                <input type="text" name="username" maxlength="32" required placeholder="Usuário">
            </div>
            
            <div class="form-component">
                <input type="email" name="email" maxlength="128" required placeholder="E-mail">
            </div>

            <div class="form-component">
                <input type="password" name="password" required placeholder="Senha">
            </div>

            <div class="form-component">
                <input type="password" name="password2" required placeholder="Confirmar Senha">
            </div>

            <input id="form-submit" type="submit" value="Enviar">
            
            <?php
                if (isset($error)) {
                    echo $error;
                }

                if (isset($success)) {
                    echo $success;
                }
            ?>
        </form>
    </body>
</html>