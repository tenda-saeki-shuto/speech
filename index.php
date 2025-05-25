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

        <p>ヒットアンドブローは、<br>数字を当てるゲームです。</p>
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
        <p id="message"></p>
        <button id="ranking" style="display:none;">ランキングに登録する</button>
        </div>
        <!-- ランキング表示--------------------------------------------------------------------- -->
        <div class="right">
            <h2>ランキング</h2>
            <div class="rank_dis">
                表示件数
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
                                url: "ranking_registration.php",
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

    $(document).ready(function () {
        fetchRanking(10); // 初期表示（例: 10件）
    });

    $('#rank_display_num').on("change", function(){
        let optval = $(this).val();
        fetchRanking(optval); // プルダウン変更時に表示件数を変更
    });

    function fetchRanking(limit) {
        $.post({
            url: 'ranking_display.php',
            data: { opt: limit },
            dataType: 'json',
        }).done(function(data){
            console.log(data);

            let rankingTable = $("#ranking_table tbody");
            $("#ranking_table tr:gt(0)").remove(); // 1行目（ヘッダー）を残して行を削除

            for (let i = 0; i < data.length; i++) {
                let rankingRow = `<tr>
                                    <td>${data[i].rank}</td>
                                    <td>${data[i].username}</td>
                                    <td>${data[i].count}</td>
                                    </tr>`;
                rankingTable.append(rankingRow);
            }
        }).fail(function(){
            alert("ランキングの表示に失敗しました。");
        });
    }


    // ページがリロードされたときにセッションを破壊する
    $(window).on("beforeunload", function () {
    navigator.sendBeacon("reload.php");
    });

</script>
</html>
