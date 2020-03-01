<?php
// wikipediaのh1を取得
require_once("./phpQuery-onefile.php");
$html = file_get_contents("https://ja.wikipedia.org/wiki/LINE_(%E4%BC%81%E6%A5%AD)");
$message=phpQuery::newDocument($html)->find("h1")->text();

// トークンのベタ打ちはセキュリティ上、良くない
$token = '各トークンの入力';

// リクエストヘッダの作成
$query = http_build_query(['message' => $message]);
$header = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $token,
        'Content-Length: ' . strlen($query)
];

$ch = curl_init('https://notify-api.line.me/api/notify');
$options = [
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_POST            => true,
    CURLOPT_HTTPHEADER      => $header,
    CURLOPT_POSTFIELDS      => $query,
    CURLINFO_HEADER_OUT => true
];

curl_setopt_array($ch, $options);
curl_exec($ch);
// 送信リクエストの確認
var_dump(curl_getinfo($ch, CURLINFO_HEADER_OUT));
// レスポンスが出ない
var_dump($response);
curl_close($ch);
