<?php
require '../config.php';
header('Content-Type: application/json');

// 昨日 00:00:00 ~ 23:59:59
$yesterday = date('Y-m-d', strtotime('-1 day'));
$start = $yesterday . ' 00:00:00';
$end   = $yesterday . ' 23:59:59';

$stmt = $pdo->query("SELECT * FROM student");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as &$s) {
    $sid = $s['id'];

    // 昨日加分
    $add = $pdo->prepare("
        SELECT SUM(score) AS c FROM score_log 
        WHERE student_id=? AND type='add' 
        AND create_time BETWEEN ? AND ?
    ");
    $add->execute([$sid, $start, $end]);
    $yadd = $add->fetch()['c'] ?: 0;

    // 昨日扣分
    $minus = $pdo->prepare("
        SELECT SUM(score) AS c FROM score_log 
        WHERE student_id=? AND type='minus' 
        AND create_time BETWEEN ? AND ?
    ");
    $minus->execute([$sid, $start, $end]);
    $yminus = $minus->fetch()['c'] ?: 0;

    $s['yesterday_add'] = (int)$yadd;
    $s['yesterday_minus'] = (int)$yminus;
}

echo json_encode($students, JSON_UNESCAPED_UNICODE);
?>
