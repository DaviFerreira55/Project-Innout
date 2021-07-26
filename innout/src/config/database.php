<?php

class Database {

    // função realiza a conexão com o banco de dados
    public static function getConnection() {
    // pega o caminho do arquivo de conexão
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');
            // aloca as informações em um array

        $env = parse_ini_file($envPath);
        // cria a variavel conn para fazer a conexão com o banco de dados, passando os parametros
        $conn = new mysqli($env['host'], $env['username'],
            $env['password'], $env['database']);
        // verifica se possui algum erro
        if($conn->connect_error) {
            die("Erro: " . $conn->connect_error);
        }

        return $conn;
    }

        // função para pegar o resultado  de uma consulta pelo banco de dados
    public static function getResultFromQuery($sql) {
    //pega a conexão com o banco de dados
        $conn = self::getConnection();
   //Aloca na variavel result o comando sql necessário.
        $result = $conn->query($sql);
        //fecha a conexão
        $conn->close();
        //retorna o resultado

        return $result;
    }

    public static function executeSQL($sql) {
        $conn = self::getConnection();
        if(!mysqli_query($conn, $sql)) {
            throw new Exception(mysqli_error($conn));
        }
        $id = $conn->insert_id;
        $conn->close();
        return $id;
    }
}