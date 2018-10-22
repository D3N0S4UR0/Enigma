<?php
    class Connection {
        private $conn;

        public function __construct() {
            $server = "Regulus";
            $info = array("Database"=>"BD16168", "UID"=>"BD16168", "PWD"=>"DB16168", "CharacterSet" => "UTF-8");
            ini_set('mssql.charset', 'UTF-8');
            $this->conn = sqlsrv_connect($server, $info);

            if(!$this->conn) {
                throw new Exception("Problemas de conexão com o banco de dados. Contate um PROFISSIONAL TÉCNICO.");
            }
        }

        public function __destruct () {
            if (isset($conn)) {
                sqlsrv_close($conn);
            }
        }


        public function runQuery ($query, $params) {
            $stmt = sqlsrv_query($this->conn, $query, $params);

            if(!$stmt) {
                throw new Exception(trim(preg_replace('/\s*\[[^\]]*\]/', '', sqlsrv_errors()[0]['message'])));
            }

            $result = array();
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }

            return $result;
        }
    
    }
?>