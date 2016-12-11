<?php

/**
 * Classe Connection responsável pela conexão com o banco de dados.
 */
class Connection {
    
    private $user;
    private $pass;
    private $host;
    private $dbname;
    private $dsn;
    private $con;
    
    /**
     * Cria a conexão com o banco e tem como retorno a conexão.
     * 
     * @return type $con
     */
    public function getConnection() {
        $this->user = "root"; // Nome do usuário do banco de dados.
        $this->pass = ""; // Senha do usuário do banco de dados.
        $this->host = "localhost"; // Host do banco de dados.
        $this->dbname = "bottelegram"; // Nome do banco de dados.
        $this->dsn = "mysql:host=" . $this->host .";dbname=" . $this->dbname;
        
        $this->con = new PDO($this->dsn, $this->user, $this->pass);
        
        return $this->con;
    }

}
