<?php
// wikipediaのh1を取得
require_once("./phpQuery-onefile.php");
$html = file_get_contents("https://ja.wikipedia.org/wiki/%E3%82%A6%E3%82%A7%E3%83%96%E3%82%B9%E3%82%AF%E3%83%AC%E3%82%A4%E3%83%94%E3%83%B3%E3%82%B0");
$message=phpQuery::newDocument($html)->find("h1")->text();

$token = 'aUSbEuyw0BJuw6XrfMB5DPNUkr8grcMf2TW5g2vw9nj';

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
