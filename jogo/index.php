<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <?php
            session_start();
            
            if (isset($_SESSION['token'])) {
                if (isset($_GET['fase'])) {
                    echo "<title>" . "{NOME DA FASE}" . "</title>\n";
                    echo "\t</head>\n";
                    echo "\t<body>\n";
                    if (isset($_GET['answer'])) {
                        // o cara tentou responder

                        
                        






                    } else {
                        // o cara não tentou responder
                    }
                } else {
                    echo "<title>Fases</title>\n";





                }
            } else {
                // header("Location: http://www.google.com");
            }
            
        ?>
        <center>
        <img src="fase.png" width="600" height="600">
        </center>
    </body>
</html>