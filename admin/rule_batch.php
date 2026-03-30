<?php
include 'auth.php';
$ids = $_POST['ids'] ?? [];
$rid = (int)$_POST['rid'];

// 获取理由分数
$rule = $pdo->prepare("SELECT score FROM score_rules WHERE id = ?");
$rule->execute([$rid]);
$score = $rule->fetchColumn();
$type = $score > 0 ? 'add' : 'minus';
$final_score = $score;

foreach ($ids as $student_id) {
    $student_id = (int)$student_id;
    
    // 更新积分
    $pdo->prepare("UPDATE student SET score = score + ? WHERE id = ?")
         ->execute([$final_score, $student_id]);
    
    // 写入日志（自动区分 add / minus）
    $pdo->prepare("INSERT INTO score_log (student_id, rule_id, type, score, create_time) 
                   VALUES (?,?,?,?,NOW())")
        ->execute([$student_id, $rid, $type, abs($final_score)]);
}

echo 'ok';
?>