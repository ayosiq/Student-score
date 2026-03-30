<?php
include 'auth.php';
$students = $pdo->query("SELECT * FROM student ORDER BY class ASC, score DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>学生积分总表 - 打印</title>
<style>
*{box-sizing:border-box}
body{font-family:"Microsoft YaHei",sans-serif;margin:0;padding:20px;background:#fff}
.print-box{max-width:1000px;margin:0 auto}
.print-title{text-align:center;font-size:24px;font-weight:bold;margin-bottom:10px}
.print-subtitle{text-align:center;font-size:16px;margin-bottom:30px;color:#666}
table{width:100%;border-collapse:collapse;margin-bottom:30px}
table th,table td{border:1px solid #333;padding:10px;text-align:center;font-size:14px}
table th{background:#f5f5f5;font-weight:bold}
.score-high{color:#28a745;font-weight:bold}
.score-low{color:#dc3545}
@media print{
  body{padding:0}
  .no-print{display:none !important}
}
</style>
</head>
<body>

<div class="print-box">
  <div class="print-title">学生积分总表</div>
  <div class="print-subtitle">统计时间：<?=date('Y-m-d H:i')?></div>

  <table>
    <thead>
      <tr>
        <th>序号</th>
        <th>班级</th>
        <th>姓名</th>
        <th>学号</th>
        <th>当前积分</th>
        <th>等级评价</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1;foreach($students as $s): ?>
      <tr>
        <td><?=$i++?></td>
        <td><?=$s['class']?></td>
        <td><?=$s['name']?></td>
        <td><?=$s['code']?></td>
        <td class="<?=$s['score']>=0 ? 'score-high' : 'score-low'?>">
          <?=$s['score']?>
        </td>
        <td>
          <?php
            $sc = $s['score'];
            if($sc>=80) echo "优秀";
            else if($sc>=60) echo "良好";
            else if($sc>=30) echo "合格";
            else if($sc>=0) echo "待进步";
            else echo "需整改";
          ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div style="text-align:right;font-size:14px;color:#666;margin-top:40px">
    打印时间：<?=date('Y-m-d H:i:s')?>
  </div>
</div>

<!-- 打印按钮 -->
<div style="text-align:center;margin-top:30px" class="no-print">
  <button onclick="window.print()" style="padding:10px 30px;font-size:16px;cursor:pointer">
    点击打印
  </button>
  <button onclick="window.close()" style="padding:10px 30px;font-size:16px;cursor:pointer;margin-left:10px">
    关闭页面
  </button>
</div>

</body>
</html>