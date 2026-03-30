<?php
include 'auth.php';

$act = $_POST['act'] ?? '';
$ids = $_POST['ids'] ?? [];
$num = (int)($_POST['num'] ?? 0);

if(!in_array($act, ['add','minus']) || empty($ids) || $num <= 0){
    exit('参数错误');
}

foreach($ids as $student_id){
    $student_id = (int)$student_id;

    // 更新积分
    if($act == 'add'){
        $pdo->prepare("UPDATE student SET score=score+? WHERE id=?")->execute([$num, $student_id]);
        $type = 'add';
        $final_score = $num;
    }else{
        $pdo->prepare("UPDATE student SET score=score-? WHERE id=?")->execute([$num, $student_id]);
        $type = 'minus';
        $final_score = -$num;
    }

    // 写入日志（保留你原来所有字段 + 加 rule_id=0 兼容新功能）
    $pdo->prepare("INSERT INTO score_log (student_id, rule_id, type, score, create_time) 
                   VALUES (?,?,?,?,NOW())")
        ->execute([$student_id, 0, $type, $num]);
}

echo 'ok';
?>