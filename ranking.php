<?php
session_start();
require_once 'myPDO.php'; // DB接続用のクラスを読み込み

function registration(){
    $user_id = $_SESSION['userid'];
    $count = $_SESSION['count'];

    $db = new myPDO();

    //ランキングテーブルにデータを挿入
    $sql = "INSERT INTO ranking (user_id, count) VALUES ('$user_id', '$count')";
    $db->inputSQL($sql);

    echo json_encode(['result' => 'success']);
    exit();
}

// `$_POST['action']` の存在を確認して関数を実行
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'registration') {
    registration();
} else {
    echo json_encode(['result' => 'error', 'message' => 'リクエストが不正です']);
}
?>
