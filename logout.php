<?php
//ログアウトの処理
session_start(); // セッションを開始
// セッション変数を全て解除
$_SESSION = array();
// セッションを破棄
session_destroy(); // セッションを破棄
// ログアウト後はindex.phpへリダイレクト
header('Location: index.php');
exit(); // スクリプトの実行を終了

?>
