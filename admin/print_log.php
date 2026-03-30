<?php
include 'auth.php';
$logs = $pdo->query("
  SELECT l.*, s.name, s.code, s.class
  FROM score_log l
  LEFT JOIN student s ON l.student_id = s.id
  ORDER BY l.create_time DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>积分操作日志 - 打印</title>
<style>
body{font-family:"Microsoft YaHei";padding:20px;background:#fff}
h2{text-align:center}
table{width:100%;border-collapse:collapse;margin:20px 0}
table th,table td{border:1px solid #333;padding:8px;text-align:center}
th{background:#f5f5f5}
.add{color:green}.minus{color:red}
@media print{.no-print{display:none}}
</style>
</head>
<body>
<h2>积分操作日志总表</h2>
<div style="text-align:center">打印时间：<?=date('Y-m-d H:i')?></div>

<table>
  <tr>
    <th>时间</th>
    <th>班级</th>
    <th>姓名</th>
    <th>操作</th>
    <th>积分</th>
  </tr>
  <?php foreach($logs as $l): ?>
  <tr>
    <td><?=$l['create_time']?></td>
    <td><?=$l['class']?></td>
    <td><?=$l['name']?></td>
    <td class="<?=$l['type']?>"><?=$l['type']=='add'?'加分':'扣分'?></td>
    <td class="<?=$l['type']?>"><?=$l['type']=='add'?'+' : '-'?><?=$l['score']?></td>
  </tr>
  <?php endforeach; ?>
</table>

<div style="text-align:center;margin-top:30px" class="no-print">
  <button onclick="window.print()" style="padding:10px 30px">打印日志</button>
</div>
</body>
</html>