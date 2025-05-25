$(function () {
  $("#submit").on("click", function (event) {
    var p_num = $("#guess").val();

    $.post({
      url: "func_game.php",
      data: { player_num: p_num },
      dataType: "json",
    })
      .done(function (data) {
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
            $("#ranking").on("click", function () {
              $.post({
                url: "ranking_registration.php",
                data: { action: "registration" }, // 修正点
                dataType: "json",
              })
                .done(function (rankingData) {
                  if (rankingData.result === "success") {
                    alert("ランキングに登録されました。");
                    location.reload();
                  } else {
                    alert("エラー: " + rankingData.message);
                  }
                })
                .fail(function () {
                  alert(
                    "ランキング登録に失敗しました。\n新規登録をしてもう一度ゲームをプレイしてください"
                  );
                });
            });
          } else {
            $("#ranking").hide(); // 正解でない場合はボタンを非表示
          }
        } else {
          alert("エラー: " + data.message);
        }
      })
      .fail(function () {
        alert("4桁の数字を入力してください。");
      });
  });
});

$(document).ready(function () {
  fetchRanking(10); // 初期表示（例: 10件）
});

$("#rank_display_num").on("change", function () {
  let optval = $(this).val();
  fetchRanking(optval); // プルダウン変更時に表示件数を変更
});

function fetchRanking(limit) {
  $.post({
    url: "ranking_display.php",
    data: { opt: limit },
    dataType: "json",
  })
    .done(function (data) {
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
    })
    .fail(function () {
      alert("ランキングの表示に失敗しました。");
    });
}

// ページがリロードされたときにセッションを破壊する
$(window).on("beforeunload", function () {
  navigator.sendBeacon("reload.php");
});
