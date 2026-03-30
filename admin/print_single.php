<?php
include 'auth.php';
$id = (int)$_GET['id'];

// 学生信息
$stu = $pdo->prepare("SELECT * FROM student WHERE id=?");
$stu->execute([$id]);
$student = $stu->fetch(PDO::FETCH_ASSOC);

// 积分日志
$log = $pdo->prepare("SELECT * FROM score_log WHERE student_id=? ORDER BY create_time DESC");
$log->execute([$id]);
$logs = $log->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>个人积分明细 - 打印</title>
<style>
*{box-sizing:border-box}
body{font-family:"Microsoft YaHei",sans-serif;padding:20px;background:#fff}
.print-title{text-align:center;font-size:22px;font-weight:bold;margin-bottom:10px}
.info{font-size:16px;line-height:1.8;margin-bottom:20px}
table{width:100%;border-collapse:collapse;margin:20px 0}
table th,table td{border:1px solid #333;padding:8px;text-align:center}
th{background:#f5f5f5}
.add{color:green;font-weight:bold}
.minus{color:red;font-weight:bold}
@media print{.no-print{display:none}}
</style>
</head>
<body>

<div class="print-title">个人积分明细单</div>
<div style="text-align:center;margin-bottom:20px">打印时间：<?=date('Y-m-d H:i')?></div>

<div class="info">
  <strong>姓名：</strong> <?=$student['name']?> &nbsp;&nbsp;&nbsp;
  <strong>学号：</strong> <?=$student['code']?> &nbsp;&nbsp;&nbsp;
  <strong>班级：</strong> <?=$student['class']?> &nbsp;&nbsp;&nbsp;
  <strong>当前积分：</strong> <?=$student['score']?>
</div>

<table>
  <tr>
    <th>时间</th>
    <th>类型</th>
    <th>积分变动</th>
    <th>备注</th>
  </tr>
  <?php foreach($logs as $l): ?>
  <tr>
    <td><?=$l['create_time']?></td>
    <td class="<?=$l['type']?>"><?=$l['type']=='add'?'加分':'扣分'?></td>
    <td class="<?=$l['type']?>">
      <?=$l['type']=='add' ? '+' : '-'?><?=$l['score']?>
    </td>
    <td><?=$l['rule_id']>0 ? '规则扣分' : '手动操作'?></td>
  </tr>
  <?php endforeach; ?>
</table>

<div style="text-align:right;margin-top:40px">
  打印时间：<?=date('Y-m-d H:i:s')?>
</div>

<div style="text-align:center;margin-top:30px" class="no-print">
  <button onclick="window.print()" style="padding:10px 30px">打印</button>
  <button onclick="window.close()" style="padding:10px 30px;margin-left:10px">关闭</button>
</div>

</body>
</html>