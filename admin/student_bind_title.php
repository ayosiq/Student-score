<?php
include 'auth.php';
$page = 'student_bind_title';
$page_title = '学生绑定头衔';

$titles = $pdo->query("SELECT * FROM titles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$students = $pdo->query("SELECT s.*,t.name as t_name,t.color as t_color 
                        FROM student s 
                        LEFT JOIN titles t ON s.title_id = t.id 
                        ORDER BY s.class ASC,s.name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>学生绑定头衔</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
</head>
<body>
<div class="lyear-layout-web">
<div class="lyear-layout-container">

<?php include 'menu.php'; include 'header.php'; ?>

<main class="lyear-layout-content">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header"><h4>学生绑定头衔</h4></div>
<div class="card-body">

<div class="table-responsive">
<table class="table table-hover">
<thead>
<tr>
  <th>班级</th>
  <th>姓名</th>
  <th>当前头衔</th>
  <th>绑定操作</th>
</tr>
</thead>
<tbody>
<?php foreach($students as $s): ?>
<tr>
  <td><?=$s['class']?></td>
  <td><?=$s['name']?></td>
  <td>
    <?php if($s['title_id']): ?>
      <span style="color:<?=$s['t_color']?>;font-weight:bold">
        <?=$s['t_name']?>
      </span>
    <?php else: ?>
      <span class="text-muted">无头衔</span>
    <?php endif; ?>
  </td>
  <td>
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bindModal"
      data-sid="<?=$s['id']?>"
      data-sname="<?=$s['name']?>">选择头衔</button>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

</div>
</div>
</div>
</div>
</div>
</main>

<!-- 绑定弹窗 -->
<div class="modal fade" id="bindModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header"><h4 class="modal-title">绑定头衔</h4></div>
  <form action="student_do_bind.php" method="post">
  <input type="hidden" name="student_id" id="bind_sid">
  <div class="modal-body">
    <div class="form-group">
      <label>学生：<span id="bind_sname" style="font-weight:bold"></span></label>
    </div>
    <div class="form-group">
      <label>选择头衔</label>
      <select name="title_id" class="form-control">
        <option value="0">移除头衔</option>
        <?php foreach($titles as $t): ?>
        <option value="<?=$t['id']?>" style="color:<?=$t['color']?>">
          <?=$t['name']?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">确认绑定</button>
  </div>
  </form>
</div>
</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script src="js/main.min.js"></script>
<script>
$('#bindModal').on('show.bs.modal',function(e){
  let b = $(e.relatedTarget);
  $('#bind_sid').val(b.data('sid'));
  $('#bind_sname').text(b.data('sname'));
});
</script>
</body>
</html>