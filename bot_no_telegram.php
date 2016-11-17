<?php
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
//MegaSenafim
$request = file_get_contents($url . '/getUpdates');
$x = json_decode($request, true);
$xLen = count($x['result']);
for ($i = 0; $i < $xLen; $i++) {
    $id = $x['result'][$i]['message']['chat']['id'];
    $text = $x['result'][$i]['message']['text'];
    $message = $x['result'][$i]['update_id'];
    $ids[$i] = $id;
    $texts[$i] = $text;
    $messages[$i] = $message;
}

$str = file_get_contents($file);
$arrUpdateId = explode(',', $str);

for ($i = 0; $i < $xLen; $i++) {
    if (!in_array($messages[$i], $arrUpdateId)) {
        if ($texts[$i] == '/megaSena') {
            $enviar = $url . '/sendMessage?chat_id=' . $ids[$i] . '&text=' . $mega;
            file_get_contents($enviar);
            file_put_contents($file, $messages[$i] . ",", FILE_APPEND | LOCK_EX);
        }
    }
}
?>