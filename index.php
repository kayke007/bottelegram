<?php

// Inclui a classe Funcoes.
require_once 'Funcoes.php'; 

// Cria uma instancia da classe Funcoes
$funcoes = new Funcoes();

// Chama o método getUpdates() da classe Funcoes. Retorno: array json.
$response = $funcoes->getUpdates();

// Conta quantos elementos tem dentro do array.
$contador = count($response['result']) - 1;

// Percorre o array $response decrementando-o.
for ($i = $contador; $i > -1; $i--) {
    $update_id = $response['result'][$i]['update_id']; // Recupera o update_id.
    $id = $response['result'][$i]['message']['from']['id']; // Recupera o id do usuário.
    $nome = $response['result'][$i]['message']['from']['first_name']; // Recupera o nome do usuário.

    // Verifica se o índice text foi inicializado.
    if (isset($response['result'][$i]['message']['text'])) {
        // Recupera o texto.
        $text = $response['result'][$i]['message']['text'];

        // Compara o texto com o comando
        if (strcasecmp($text, '/megasena') == 0) {
            $bancoUpdateId = $funcoes->recuperaUpdateId(); // Recupera os Updates_id do banco.
            // Verifica se já existe no banco.
            if (!in_array($update_id, $bancoUpdateId)) {
                $megasena = megaSena(); // Chama a função megaSena().
                /**
                 * Chama a função sendMessage, passando o id e a mensagem
                 * de resposta do bot como parâmetros.
                 */
                $funcoes->sendMessage($id, $megasena); 
                /**
                 * Chama a função inserirDados, passando o update_id, o nome do usuário,
                 * o texto que o usuário digitou e a mensagem de resposta do bot como
                 * parâmetros.
                 */
                $funcoes->inserirDados($update_id, $nome, $text, $megasena);
            }
        }
    }
    // Imprime o nome do usuário e o que ele digitou na página web.
    echo $nome . " : " . $text . "<br/>"; 
}

/**
 * Função Mega-Sena
 * 
 * Gera os 6 números aleatórios, ordena-os e concatena-os com "-".
 * Retorna uma string com todos os números gerados.
 * 
 * @return type $mega
 */
function megaSena() {
    // Gera os 6 numeros.
    for ($i = 1; $i <= 6; $i++) {
        $n[] = str_pad(rand(1, 60), 2, '0', STR_PAD_LEFT);
    }
    
    // Ordena os números.
    sort($n); 
    
    // Concatena-os com "-".
    $megasena = implode(' - ', $n); 
    
    return $megasena;
}