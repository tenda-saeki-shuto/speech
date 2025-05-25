<?php

$user_name = $_SESSION['username'];

?>

<h1>ヒットアンドブロー</h1>

<?php if ($user_name === "guest") : ?>
    <p>ゲストユーザーとしてプレイしています。<br>
    <a href="login.php">ログイン</a>または<a href="registration.php">新規登録</a>してください。</p>
<?php
else : ?>
    <p>ようこそ、<?php echo htmlspecialchars($user_name); ?>さん！</p>
    <a href="logout.php">ログアウト</a>
<?php endif; ?>
