<?php
//hit and blow ゲームの機能を実装するためのPHPコード
session_start();
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
$count = $_SESSION['count'];

// ヒットとブローの計算
function calculateHitAndBlow($player_num, $answer) {
    $hit = 0;
    $blow = 0;

    for ($i = 0; $i < 4; $i++) {
        if ($player_num[$i] === $answer[$i]) {
            $hit++;
        } elseif (strpos($answer, $player_num[$i]) !== false) {
            $blow++;
        }
    }

    $_SESSION['count'] += 1; // カウントを増やしセッションに保存

    return ['hit' => $hit, 'blow' => $blow, 'count' => $_SESSION['count']];
}


// ユーザーの予想と正解を比較してヒットとブローを計算
$result = calculateHitAndBlow($player_num, $answer);


// 結果をJSON形式で返す
echo json_encode(['result' => 'success', 'hit' => $result['hit'], 'blow' => $result['blow'], "count" => $result['count']]);


?>
