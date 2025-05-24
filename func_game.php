<?php
session_start();
require_once 'myPDO.php'; // 独自PDOクラスを読み込み

// 独自のランダムな4桁の数字を生成
$num = sprintf('%04d', mt_rand(0000,9999))


?>
