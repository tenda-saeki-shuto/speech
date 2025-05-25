<?php
session_start(); // セッションを有効化

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "guest";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>ヒットアンドブロー</title>
</head>
<body>
    <header>
        <?php require('header.php'); ?>
    </header>
    <div class="container">
        <div class="left">

        </div>
        <!--------- ゲームコンテンツ -------------------------------------------------------------->
        <div class="center">

        <p style="font-size: 18px;">ヒットアンドブローは、<br>数字を当てるゲームです。</p>
        <p style="font-size: 18pt;">4桁の数字を当ててください。</p>

        <input type="text" id="guess" name="guess"  maxlength="4" pattern="\d{4}" required style="font-size: 50px; width: 200px; height: 50px; text-align:center;">
        <br>
        <button type="submit" id="submit" style="font-size: 30px;">送信</button>
        <br>
        <br>
        <table id ="result" border=1>
            <tr id="result">
                <th style="width: 20%;">回数</th>
                <th style="width: 30%;">入力値</th>
                <th style="width: 25%;">HIT</th>
                <th style="width: 25%;">BLOW</th>
            </tr>
        </table>
        <p id="message" style="font-size: 20px;"></p>
        <button id="ranking" style="display:none;"><span>ランキングに登録する</span></button>
        </div>
        <!-- ランキング表示--------------------------------------------------------------------- -->
        <div class="right">
            <h2 style="font-size: 40px; text-align:center;" class="ranking">ランキング</h2>
            <div class="rank_dis">
                <span style="font-size: 20px;">表示件数</span>
                <select id="rank_display_num">
                    <option value=10>10</option>
                    <option value=20>20</option>
                    <option value=30>30</option>
                </select>
            </div>
            <table id="ranking_table" border=0>
                <tr id="rank">
                    <th>順位</th>
                    <th>ユーザー名</th>
                    <th>回数</th>
                </tr>
        </table>
    </div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="index.js"></script>
</html>
