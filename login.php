<?php
session_start();

//postリクエストが送信された場合
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ここでデータベース接続とユーザー認証を行います
    // 例: データベースからユーザー情報を取得し、パスワードを照合する

    // 認証成功の場合
    if($username === 'admin' && $password === 'password') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php'); // index.phpへリダイレクト
        exit();
    } else {
        echo "ユーザー名またはパスワードが間違っています。";
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
    <form action="login.php" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">ログイン</button>
</body>
</html>
