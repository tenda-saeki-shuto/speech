<?php

header('Content-Type: application/json; charset=UTF-8');
$name = $_POST['name'] ?? '';
$age = (int)$_POST['age'] ?? '';

$arr=array(
    'name' => $name,
    'age' => $age,
    'message' => "こんにちは、{$name}さん！あなたは{$age}歳ですね。"
);

echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();

?>
