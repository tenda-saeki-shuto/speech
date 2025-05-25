<?php
require("myPDO.php");

$disp_num = $_POST['optval'] ?? '';

//rankingテーブルからデータを取得
$db = new myPDO();
$sql = "SELECT user_name, count FROM ranking INNER JOIN user ON ranking.user_id = user.id ORDER BY count ASC";

$result = $db->query($sql);

$rankings = [];

//上位10件を取得
for ($i=0; $i < $disp_num; $i++){
    $row = $result[$i];
    // データが存在する場合のみ配列に追加
    if ($row) {
        $rankings[] = [
            'rank' => $i + 1,
            'user_name' => htmlspecialchars($row['user_name']),
            'count' => htmlspecialchars($row['count'])
        ];
    } else {
        break; // データがなくなったらループを抜ける
    }
}

// JSON形式でランキングデータを返す
echo json_encode($rankings);
header('Content-Type: application/json');

?>
