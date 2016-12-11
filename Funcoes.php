<?php

// Inclui a classe Connection.
require_once 'Connection.php'; 

// Define como constante o token do bot recuperado o arquivo txt.
define('TOKEN', file_get_contents('fileToken.txt'));

// Define a URL com o TOKEN do bot.
define('URL', 'https://api.telegram.org/bot' . TOKEN);

/**
 * Classe Funções reune todas as funções utilizadas nesta aplicação.
 */
class Funcoes {

    private $connection;
    private $con;

    /**
     * Construtor da classe Funcoes que já instancia a classe Connection
     * e recupera a conexão através do método getConnection().
     */
    public function __construct() {
        $this->connection = new Connection();
        $this->con = $this->connection->getConnection();
    }

    /**
     * 
     * Função que faz a inserção dos dados na tabela resposta do banco de dados.
     * 
     * @param type $update_id
     * @param type $nome
     * @param type $comando
     * @param type $bot_resposta
     */
    public function inserirDados($update_id, $nome, $comando, $bot_resposta) {
        $sql = "insert into resposta(update_id, nome, comando, bot_resposta) values (?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $update_id);
        $stmt->bindParam(2, $nome);
        $stmt->bindParam(3, $comando);
        $stmt->bindParam(4, $bot_resposta);
        $stmt->execute();
    }

    /** 
     * Pesquisa e retorna da base de dados, na tabela resposta, a coluna update_id.
     * A função retorno todas as linhas da consulta em um array.
     * 
     * @return type $update_id
     */
    public function recuperaUpdateId() {
        $update_id = array();

        $rs = $this->con->query("select update_id from resposta");

        while ($linha = $rs->fetch(PDO::FETCH_ASSOC)) {
            $update_id[] = $linha['update_id'];
        }

        return $update_id;
    }

    /**
     * Faz a requisição de dados no servidor do telegram, pega o resultado,
     * decodifica e retorna o JSON com os dados.
     * 
     * @return type $response
     */
    public function getUpdates() {
        $request = file_get_contents(URL . '/getUpdates');
        $response = json_decode($request, TRUE);

        return $response;
    }

    /**
     * Função que envia mensagem de volta, respondendo o usuário.
     * Recebe os parâmetros:
     * ID do usuário;
     * Mensagem que vai ser enviada;
     * 
     * @param type $id
     * @param type $mensagem
     */
    public function sendMessage($id, $mensagem) {
        $enviar = URL . '/sendMessage?chat_id=' . $id . '&text=' . urlencode($mensagem);
        file_get_contents($enviar);
    }

}
