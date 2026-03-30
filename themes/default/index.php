<?php
$students = $pdo->query("SELECT s.*, t.name as t_name, t.color as t_color
                         FROM student s
                         LEFT JOIN titles t ON s.title_id = t.id
                         ORDER BY s.score DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>班级积分排行</title>
<style>
*{box-sizing:border-box}
body{margin:0;padding:20px;background:#f7f8fc;font-family:Microsoft YaHei}
.container{max-width:1000px;margin:auto}
.title{text-align:center;font-size:26px;font-weight:bold;margin-bottom:30px}
.card{background:#fff;border-radius:12px;padding:15px 20px;margin-bottom:12px;display:flex;align-items:center;box-shadow:0 2px 10px rgba(0,0,0,0.05)}
.rank{width:32px;height:32px;line-height:32px;text-align:center;border-radius:50%;background:#f2f3f7;margin-right:12px;font-weight:bold}
.rank1{background:#ffd700;color:#fff}
.rank2{background:#c0c0c0;color:#fff}
.rank3{background:#cd7f32;color:#fff}
.avatar{width:44px;height:44px;border-radius:50%;object-fit:cover;margin-right:12px}
.info{flex:1}
.name{font-weight:bold}
.title-tag{color:<?=$t['color']?>;font-size:12px;padding:2px 6px;border-radius:4px}
.score{font-weight:bold;color:#28a745}
</style>
</head>
<body>
<div class="container">
<div class="title">🏆 班级积分排行榜</div>

<?php $r=1;foreach($students as $s):?>
<div class="card">
<div class="rank <?=$r<=3?'rank'.$r:''?>"><?=$r?></div>
<img src="<?=empty($s['avatar'])?'../admin/avatar/default.png':'..admin/avatar/'.$s['avatar']?>" class="avatar">
<div class="info">
<div class="name">
<?=$s['name']?>
<?php if($s['t_name']):?>
<span class="title-tag" style="color:<?=$s['t_color']?>">【<?=$s['t_name']?>】</span>
<?php endif;?>
</div>
<div class="text-muted text-sm"><?=$s['class']?> · <?=$s['code']?></div>
</div>
<div class="score"><?=$s['score']?> 分</div>
</div>
<?php $r++;endforeach;?>
</div>
</body>
</html>