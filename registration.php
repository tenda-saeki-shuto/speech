<?php
require_once 'myPDO.php'; // 独自PDOクラスを読み込み


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // データベース接続
            $db = new myPDO();

            // ユーザー名の重複チェック
            $sql = "SELECT COUNT(*) FROM user WHERE user_name = \"$username\"";
            $result = $db->inputSQL($sql);
            $result = $result[0]['COUNT(*)'];


            if ($result > 0) {
                $error_msg = "このユーザー名はすでに使用されています。";
            }
            else
            {
                // ユーザー情報の登録
                $sql = "INSERT INTO user (user_name, password) VALUES (\"$username\", \"$password\")";
                $stmt = $db->inputSQL($sql);

                // 登録成功後、ログインページへリダイレクト
                header('Location: login.php');
                exit();
            }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_style.css">
    <title>新規登録</title>
</head>
<body>
    <div class="contents">
    <h1>新規登録</h1>
    <p>ユーザー名とパスワードを入力してください。</p>
    <font color="red">
    <?php echo isset($error_msg) ? $error_msg : ''; ?>
    </font>
    <form action="registration.php" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" class="btn_03">登録</button>
        <br>
        <a href="login.php" class="btn_26">ログイン</a>
    </form>
    </div>

</body>
</html>
