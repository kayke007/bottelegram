<?php
require_once'conection.php';
$file = "message_id.txt";
$fileToken = "fileToken.txt";

$token = file_get_contents($fileToken);

$url = 'https://api.telegram.org/bot' . $token;

//MegaSena
for ($i = 1; $i <= 6; $i++) {//gera os 6 numeros
    $n[] = str_pad(rand(1, 60), 2, '0', STR_PAD_LEFT);
}
sort($n); //ordena os n�meros
$mega = implode(' - ', $n); //exibe os numeros


$request = file_get_contents($url . '/getUpdates');
$x = json_decode($request, true);
$var = count($x['result'])-1;
for ($i = 0; $i > -1; $i--) {
    $nome = $x['result'][$i]['message']['from']['first_name'];echo "<br/>";
    $id = $x['result'][$i]['message']['chat']['id'];echo "<br/>";
    $text = $x['result'][$i]['message']['text'];echo "<br/>";
    $message = $x['result'][$i]['update_id'];echo "<br/>";
    $ids[$i] = $id;
    $texts[$i] = $text;
    $messages[$i] = $message;
 
}
   echo $nome." : ". $text."<BR>". "RESULTADO :".$mega;
//MegaSenafim

mysqli_query($con,"INSERT INTO resposta (updateid,comando,texto) VALUES ('$id','$text','$mega')");
mysqli_close($con);

$str = file_get_contents($file);
$arrUpdateId = explode(',', $str);

for ($i = 0; $i < $var; $i++) {
    if (!in_array($messages[$i], $arrUpdateId)) {
        if ($texts[$i] == '/megaSena') {
            $enviar = $url . '/sendMessage?chat_id=' . $ids[$i] . '&text=' . $mega;
            file_get_contents($enviar);
            file_put_contents($file, $messages[$i] . ",", FILE_APPEND | LOCK_EX);
        }
    }
}

?>


