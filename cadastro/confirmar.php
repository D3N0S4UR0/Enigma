<?php
    require_once("../php/dbconnection.php");
    if (isset($_GET['token']) && trim($_GET['token']) != "") {
        $conn = new Connection();
        try {
            $conn->runQuery("E_AuthenticateUser ?", array($_GET['token']));
            header("Location: ../login/");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
?>