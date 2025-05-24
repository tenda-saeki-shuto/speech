<?php
session_start(); // セッションを有効化

$player_num = $_POST['player_num'] ?? null; // ユーザーの予想を取得

if ($player_num === null) {
    echo json_encode(['result' => 'error', 'message' => '予想が送信されていません。']);
    exit;
}

// 正解の数字を生成
function generateAnswer() {
    $digits = range(0, 9);
    shuffle($digits);
    return implode('', array_slice($digits, 0, 4)); // 4桁の異なる数字を生成
}

// 初回ゲーム開始時の処理
if (!isset($_SESSION['answer'])) {
    $_SESSION['answer'] = generateAnswer();
    $_SESSION['count'] = 0; // ゲーム開始時にカウントを初期化
}

$answer = $_SESSION['answer'];

// ヒットとブローの計算
function calculateHitAndBlow($player_num, $answer) {
    $hit = 0;
    $blow = 0;
    $used_indices_hit = []; // ヒットで使用済みのインデックスを記録
    $used_indices_blow = []; // ブローで使用済みのインデックスを記録
    $answer_array = str_split($answer); // 正解を配列化

    // Hit の判定
    for ($i = 0; $i < 4; $i++) {
        if ($player_num[$i] === $answer[$i]) {
            $hit++;
            $used_indices_hit[] = $i; // Hit のインデックスを記録
        }
    }

    // Blow の判定（Hit で使用済みのインデックスを除外）
    for ($i = 0; $i < 4; $i++) {
        if (!in_array($i, $used_indices_hit)) { // すでに Hit になったインデックスはスキップ
            for ($j = 0; $j < 4; $j++) {
                if (!in_array($j, $used_indices_hit) && !in_array($j, $used_indices_blow) && $player_num[$i] === $answer_array[$j]) {
                    $blow++;
                    $used_indices_blow[] = $j; // Blow のインデックスを記録
                    break; // 1回カウントしたらループを抜ける
                }
            }
        }
    }

    // セッションにカウントを保存
    $_SESSION['count']++;

    return ['hit' => $hit, 'blow' => $blow, 'count' => $_SESSION['count']];
}


// ユーザーの予想と正解を比較してヒットとブローを計算
$result = calculateHitAndBlow($player_num, $answer);

// 結果を JSON 形式で返す
echo json_encode([
    'result' => 'success',
    'hit' => $result['hit'],
    'blow' => $result['blow'],
    'count' => $result['count'],
    'player_num' => $player_num,
    'answer' => $answer
]);
?>
