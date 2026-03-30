<?php
include 'auth.php';
$page = 'title';
$page_title = '头衔管理';

if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->prepare("DELETE FROM titles WHERE id=?")->execute([$id]);
    header("Location: title_list.php");
    exit;
}

$titles = $pdo->query("SELECT * FROM titles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>头衔管理</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
</head>
<body>
<div class="lyear-layout-web">
<div class="lyear-layout-container">

<?php include 'menu.php'; ?>
<?php include 'header.php'; ?>

<main class="lyear-layout-content">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header">
  <h4>头衔管理</h4>
</div>
<div class="card-body">

<div class="mb-3">
  <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
    <i class="mdi mdi-plus"></i> 添加头衔
  </button>
</div>

<div class="table-responsive">
<table class="table table-hover">
<thead>
<tr>
  <th>ID</th>
  <th>头衔名称</th>
  <th>颜色预览</th>
  <th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($titles as $t): ?>
<tr>
  <td><?=$t['id']?></td>
  <td>
    <span style="color:<?=$t['color']?>;font-weight:bold">
      <?=$t['name']?>
    </span>
  </td>
  <td>
    <div style="width:60px;height:30px;background:<?=$t['color']?>;border-radius:4px"></div>
  </td>
  <td>
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal"
      data-id="<?=$t['id']?>"
      data-name="<?=$t['name']?>"
      data-color="<?=$t['color']?>">编辑</button>

    <button class="btn btn-sm btn-danger" onclick="if(confirm('确定删除？'))location.href='?del=<?=$t['id']?>'">删除</button>
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

<!-- 添加 -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header"><h4 class="modal-title">添加头衔</h4></div>
  <form action="title_save.php" method="post">
  <div class="modal-body">
    <div class="form-group">
      <label>头衔名称</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
      <label>头衔颜色</label>
      <input type="color" name="color" class="form-control" value="#333333" required>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">保存</button>
  </div>
  </form>
</div>
</div>
</div>

<!-- 编辑 -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header"><h4 class="modal-title">编辑头衔</h4></div>
  <form action="title_save.php" method="post">
  <input type="hidden" name="id" id="edit_id">
  <div class="modal-body">
    <div class="form-group">
      <label>头衔名称</label>
      <input type="text" name="name" id="edit_name" class="form-control" required>
    </div>
    <div class="form-group">
      <label>颜色</label>
      <input type="color" name="color" id="edit_color" class="form-control" required>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary">保存</button>
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
$('#editModal').on('show.bs.modal',function(e){
  let b = $(e.relatedTarget);
  $('#edit_id').val(b.data('id'));
  $('#edit_name').val(b.data('name'));
  $('#edit_color').val(b.data('color'));
});
</script>
</body>
</html>