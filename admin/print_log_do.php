<?php
include 'auth.php';

$start = $_GET['start_time'] ?? '';
$end   = $_GET['end_time'] ?? '';
$type  = $_GET['type'] ?? 'all';

if (!$start || !$end) {
    exit('请选择时间范围');
}

$where = [];
$where[] = "l.create_time BETWEEN ? AND ?";
$params = [$start, $end];

if ($type === 'add') {
    $where[] = "l.type = 'add'";
} elseif ($type === 'minus') {
    $where[] = "l.type = 'minus'";
}

$whereSql = implode(' AND ', $where);

$sql = "
    SELECT 
        l.*,
        s.name, s.class,
        r.title as rule_title
    FROM score_log l
    LEFT JOIN student s ON l.student_id = s.id
    LEFT JOIN score_rules r ON l.rule_id = r.id
    WHERE $whereSql
    ORDER BY l.create_time DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>积分日志打印</title>
<style>
    *{box-sizing:border-box}
    body{font-family:"Microsoft YaHei",sans-serif;padding:20px;background:#fff;}
    .print-wrap{max-width:1200px;margin:0 auto;}
    .print-title{text-align:center;font-size:24px;font-weight:bold;margin-bottom:10px;}
    .info-bar{text-align:center;font-size:14px;color:#666;margin-bottom:20px;line-height:1.8}
    table{width:100%;border-collapse:collapse;margin-bottom:30px;}
    table th,table td{border:1px solid #333;padding:10px;text-align:center;font-size:12px;}
    table th{background:#f5f5f5;font-weight:bold;}
    .add{color:#28a745;font-weight:bold;}
    .minus{color:#dc3545;font-weight:bold;}
    .time{font-size:12px;color:#666;}
    .reason{font-size:12px;color:#333;}
    @media print{
        body{padding:0;}
        .no-print{display:none !important;}
    }
</style>
</head>
<body>

<div class="print-wrap">
    <div class="print-title">班级积分操作日志</div>
    <div class="info-bar">
        时间范围：<?=htmlspecialchars($start)?> ～ <?=htmlspecialchars($end)?><br>
        类型：<?php
            if($type=='add') echo '仅加分';
            elseif($type=='minus') echo '仅扣分';
            else echo '全部操作';
        ?>　
        打印时间：<?=date('Y-m-d H:i:s')?>
    </div>

    <table>
        <thead>
            <tr>
                <th>序号</th>
                <th>操作时间</th>
                <th>班级</th>
                <th>姓名</th>
                <th>类型</th>
                <th>积分变动</th>
                <th>理由/备注</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($logs as $log): ?>
            <tr>
                <td><?=$i++?></td>
                <td class="time"><?=$log['create_time']?></td>
                <td><?=$log['class']?></td>
                <td><?=$log['name']?></td>
                <td class="<?=$log['type']?>">
                    <?=$log['type']=='add' ? '加分' : '扣分'?>
                </td>
                <td class="<?=$log['type']?>">
                    <?=$log['type']=='add' ? '+' : '-'?><?=$log['score']?>
                </td>
                <td class="reason">
                    <?=!empty($log['rule_title']) ? $log['rule_title'] : '手动操作'?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="text-align:right;font-size:12px;color:#666;">
        打印时间：<?=date('Y-m-d H:i:s')?>
    </div>
</div>

<div class="no-print" style="text-align:center;margin-top:30px;">
    <button onclick="window.print()" style="padding:10px 30px;font-size:16px;">打印日志</button>
    <button onclick="window.close()" style="padding:10px 30px;font-size:16px;margin-left:10px;">关闭</button>
</div>

</body>
</html>