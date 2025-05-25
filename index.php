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
    <h1>ヒットアンドブロー</h1>
    <p>ヒットアンドブローは、数字を当てるゲームです。</p>
    <p>4桁の数字を当ててください。</p>

        <label for="guess">あなたの予想:</label>
        <input type="text" id="guess" name="guess"  maxlength="4" pattern="\d{4}" required>
        <button type="submit" id="submit">送信</button>
        <br>
        <br>
        <table id ="result" border="1">
            <tr id="count">
                <td>回数</td>
            </tr>
            <tr id="player_num">
                <td>入力値</td>
            </tr>
            <tr id="hit">
                <td>Hit</td>
            </tr>
            <tr id="blow">
                <td>Blow</td>
            </tr>
        </table>
        <p id="message"></p>
        <button id="ranking" style="display:none;">ランキングに登録する</button>
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
                    $("#count").append("<td>" + data.count + "</td>");
                    $("#player_num").append("<td>" + data.player_num + "</td>");
                    $("#hit").append("<td>" + data.hit + "</td>");
                    $("#blow").append("<td>" + data.blow + "</td>");

                    // ユーザーが正解した場合の処理(ランキングに登録するボタンを表示)
                    if (data.hit === 4) {
                        $("#ranking").text("ランキングに登録する");
                        $("#ranking").show();
                        $("#ranking").on("click", function() {
                            $.post({
                                url: "ranking.php",
                                data: { player_num: p_num },
                                dataType: "json",
                            }).done(function(rankingData) {
                                if (rankingData.result === "success") {
                                    alert("ランキングに登録されました。");
                                    location.reload(); // ページをリロードしてランキングを更新
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
