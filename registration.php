<?php
require_once 'myPDO.php'; // 独自PDOクラスを読み込み


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // データベース接続
        try {
            $db = new myPDO();
            $sql = "INSERT INTO user (user_name, password) VALUES (:username, :password)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            if ($stmt->execute()) {
                echo "<p>登録が完了しました。</p>";
            } else {
                echo "<p>登録に失敗しました。</p>";
            }
        } catch (PDOException $e) {
            echo "<p>エラー: " . $e->getMessage() . "</p>";
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
</head>
<body>
    <h1></h1>新規登録</h1>
    <p>ユーザー名とパスワードを入力してください。</p>
    <form action="registration.php" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">登録</button>
    </form>


</body>
</html>
