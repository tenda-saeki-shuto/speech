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

        <p>ヒットアンドブローは、数字を当てるゲームです。</p>
        <p>4桁の数字を当ててください。</p>

        <label for="guess">あなたの予想:</label>
        <input type="text" id="guess" name="guess"  maxlength="4" pattern="\d{4}" required>
        <button type="submit" id="submit">送信</button>
        <br>
        <br>
        <table id ="result" border=1>
            <tr id="result">
                <th>回数</th>
                <th>入力値</th>
                <th>HIT</th>
                <th>BLOW</th>
            </tr>
        </table>
        <p id="message"></p>
        <button id="ranking" style="display:none;">ランキングに登録する</button>
        </div>
        <!-- ランキング表示--------------------------------------------------------------------- -->
        <div class="right">
            <h2>ランキング</h2>
            <table id="ranking_table" border="1">
                <tr>
                    <th>順位</th>
                    <th>ユーザー名</th>
                    <th>回数</th>
                </tr>
                <?php
                // require('ranking.php'); // ランキングの表示を行う
                ?>
        </table>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(function(){
        $("#submit").on("click", function(event){

            var p_num = $("#guess").val();

            $.post({
                url:"func_game.php",
                data: { player_num: p_num },
                dataType: "json",
            }).done(function(data) {
                if (data.result === "success") {
                    alert("ヒット: " + data.hit + ", ブロー: " + data.blow);
                    $("#message").text(data.message);
                    let newRow = `<tr>
                                <td>${data.count}</td>
                                <td>${data.player_num}</td>
                                <td>${data.hit}</td>
                                <td>${data.blow}</td>
                                </tr>`;

                    $("#result").append(newRow); // `#result` テーブルに追加


                    console.log(data.answer); // 正解の数字をコンソールに表示

                    // ユーザーが正解した場合の処理(ランキングに登録するボタンを表示)
                    if (data.hit === 4) {
                        $("#ranking").text("ランキングに登録する");
                        $("#ranking").show();
                        $("#ranking").on("click", function() {
                            $.post({
                                url: "ranking.php",
                                data: { action: "registration" }, // 修正点
                                dataType: "json",
                            }).done(function(rankingData) {
                                if (rankingData.result === "success") {
                                    alert("ランキングに登録されました。");
                                    location.reload();
                                } else {
                                    alert("エラー: " + rankingData.message);
                                }
                            }).fail(function() {
                                alert("ランキング登録に失敗しました。");
                            });

                                                });

                    } else {
                        $("#ranking").hide(); // 正解でない場合はボタンを非表示
                    }


                } else {
                    alert("エラー: " + data.message);
                }
            }).fail(function() {
                alert("4桁の数字を入力してください。");
            });
        })
    })



    // ページがリロードされたときにセッションを破壊する
    $(window).on("beforeunload", function () {
    navigator.sendBeacon("reload.php");
    });

</script>
</html>
