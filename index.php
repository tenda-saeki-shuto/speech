<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヒットアンドブロー</title>
</head>
<body>
    <h1></h1>ヒットアンドブロー</h1>
    <p>ヒットアンドブローは、数字を当てるゲームです。</p>
    <p>4桁の数字を当ててください。</p>

    <form action="game.php" method="post">
        <label for="guess">あなたの予想:</label>
        <input type="text" id="guess" name="guess" required pattern="\d{4}" title="4桁の数字を入力してください">
        <button type="submit">送信</button>
    </form>

</body>
</html>
