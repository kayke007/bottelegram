<html>
    <head>
        <title>Meu API</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
       // $file = 'updaeId.txt';
      //  file_put_contents($file, $updateId . ',', FILE_APPEND | LOCK_X);

        //RESPONDE AS MESSAGEM PARA O TELEGRAM.
        function sendMessage($chatId, $text) {
            file_get_contents("https://api.telegram.org/bot262367862:AAHEEt28-_QDnzr75NVj-zLvPamcNKXmHHY/sendMessage?chat_id=" . $chatId . "&text=" . $text);
        }

        //FIM DA RESPOSTA.
        $url = "https://api.telegram.org/bot262367862:AAHEEt28-_QDnzr75NVj-zLvPamcNKXmHHY/getUpdates"; //PEGA PELA URL API DO MEU TELEGRAM
        $conteudo = file_get_contents($url);
        $to = json_decode($conteudo, true); //TRATA AS MESSAGEM DO TELEGRAM
        $run = count($to["result"]);
        $ids = array();
        $textos = array();
        // RECUPERA TEXTO EM IDS
        for ($i = 0; $i < $run; $i++) {
            $id = $to["result"][$i]["message"]["chat"]["id"];
            $texto = $to["result"][$i]["message"]["text"];
            $data = $to["result"][$i]["message"]["date"];
            $idTexto = $to["result"][$i]["update_id"];

            $ids[$i] = $id;
            $textos[$i] = $texto;
           // echo "Nome: " . $texto . "<br/>";
           // echo "Nome: " . $data . "<br/>";
        }
      //$str = file_get_contents($file);
      // $arrUpdateId = explode(',', $str);

        $ids = array_unique($ids); //UNIFICA OS ARRAY
        $ids = array_values($ids); //RETORNA OS VALORES
        $contagem = count($ids); //AQUI FAZ A CONTAGEM DOS ARRAY UNICOS
        $contMsg = count($textos);

        if (!in_array($updateId, $arrUpdateId)) {
            echo "Foi enviado sua msg";
        }
        //GERA NUMERO MEGASENA
        for ($c = 0; $c <= 6; $c++) {
            $numeroMega[] = rand(1, 60);
        }
        //SORTIA OS NUMEROS
        sort($numeroMega);
        $var1 = implode(" - ", $numeroMega);

        for ($i = 0; $i < $contagem; $i++) {

            for ($p = 0; $p < $contMsg; $p++) {
                if ($textos[$p] == "/megasena")
                    sendMessage($ids[$i], "Ola " . $var1);
                else
                    sendMessage($ids[$i], "Não e essa");
            }
        }
        ?>
    </body>
</html>