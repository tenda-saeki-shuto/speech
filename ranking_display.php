<?php
require("myPDO.php");

$disp_num = $_POST['opt'] ?? '';

//rankingテーブルからデータを取得
$db = new myPDO();
$sql = "SELECT user_name, count FROM ranking INNER JOIN user ON ranking.user_id = user.id ORDER BY count ASC";

$result = $db->inputSQL($sql);

$rankings = [];


// 上位件数を取得
for ($i = 0; $i < $disp_num; $i++) {
    if (isset($result[$i])) {
        $rankings[] = [
            'rank' => $i + 1,
            'username' => htmlspecialchars($result[$i]['user_name']), // 修正
            'count' => htmlspecialchars($result[$i]['count'])
        ];
    } else {
        break;
    }
}

// JSON形式でランキングデータを返す
header('Content-Type: application/json');
echo json_encode($rankings);


?>
