<?php
include 'auth.php';
$page = 'rule';
$page_title = '积分规则列表';

// 删除
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->prepare("DELETE FROM score_rules WHERE id=?")->execute([$id]);
    header("Location: rule_list.php");
    exit;
}

$rules = $pdo->query("SELECT * FROM score_rules ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>积分规则列表</title>
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
  <h4>积分规则列表</h4>
  <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">添加规则</button>
  <button class="btn btn-info pull-right mr-2" data-toggle="modal" data-target="#importModal">批量导入</button>
</div>
<div class="card-body">

<div class="table-responsive">
<table class="table table-hover">
<thead>
<tr>
  <th>ID</th>
  <th>规则名称</th>
  <th>变动分值</th>
  <th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($rules as $r): ?>
<tr>
  <td><?=$r['id']?></td> 
  <td><?=$r['title']?></td>
  <td>
    <?php if($r['score'] > 0): ?>
      <span class="text-success">+<?=$r['score']?></span>
    <?php else: ?>
      <span class="text-danger"><?=$r['score']?></span>
    <?php endif; ?>
  </td>
  <td>
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal"
      data-id="<?=$r['id']?>"
      data-title="<?=$r['title']?>"
      data-score="<?=$r['score']?>">编辑</button>

    <button class="btn btn-sm btn-danger" onclick="if(confirm('确定删除？'))location.href='?del=<?=$r['id']?>'">删除</button>
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

<!-- 添加弹窗 -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">添加积分规则</h4>
      </div>
      <form action="rule_save.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>规则名称</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>变动分值（正数加分，负数扣分）</label>
            <input type="number" name="score" class="form-control" required>
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

<!-- 编辑弹窗 -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">编辑积分规则</h4>
      </div>
      <form action="rule_save.php" method="post">
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-body">
          <div class="form-group">
            <label>规则名称</label>
            <input type="text" name="title" id="edit_title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>变动分值</label>
            <input type="number" name="score" id="edit_score" class="form-control" required>
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

<!-- 批量导入弹窗 -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">批量导入规则</h4>
      </div>
      <form action="rule_import.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>每行格式：名称,分值（正数加分 负数扣分）</label>
            <textarea name="content" class="form-control" rows="8" placeholder="按时上课,+2
迟到,-1
旷课,-5
表扬,+3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="submit" class="btn btn-primary">导入</button>
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
// 编辑弹窗赋值
$('#editModal').on('show.bs.modal',function(e){
  let b = $(e.relatedTarget);
  $('#edit_id').val(b.data('id'));
  $('#edit_title').val(b.data('title'));
  $('#edit_score').val(b.data('score'));
});
</script>
</body>
</html>