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
                } else {
                    alert("エラー: " + data.message);
                }
            }).fail(function() {
                alert("4桁の数字を入力してください。");
            });
        })
    })
</script>
</html>
