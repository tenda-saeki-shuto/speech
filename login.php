<?php
session_start();
require_once 'myPDO.php'; // 独自PDOクラスを読み込み

//postリクエストが送信された場合
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ここでデータベース接続とユーザー認証を行います
    // データベースからユーザー情報を取得し、パスワードを照合する
    $sql = "SELECT * FROM user WHERE user_name = \"$username\"";
    $select = new myPDO();
    $result = $select->inputSQL($sql);

    $username_db = $result[0]['user_name'];
    $password_db = $result[0]['password'];
    $userid_db = $result[0]['id'];

    // 認証成功の場合
    if($username === $username_db && $password === $password_db) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid_db; // ユーザーIDをセッションに保存
        header('Location: index.php'); // index.phpへリダイレクト
        exit();
    } else {
        $error_msg = "ユーザー名またはパスワードが間違っています。";
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>
    <p>ユーザー名とパスワードを入力してください。</p>
    <form action="login.php" method="post">
        <font color="red">
        <?php echo isset($error_msg) ? $error_msg : ''; ?>
        </font>
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">ログイン</button>
</body>
</html>
