<?php
session_start();
header('Content-Type: text/plain');

// リロードされたらセッションを破壊する
unset($_SESSION['answer']); // 全セッション変数を解除


echo "セッションがクリアされました";
?>
