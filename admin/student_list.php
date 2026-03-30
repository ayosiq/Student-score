<?php
include 'auth.php';
$page = 'list';
$page_title = '学生列表';

if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $pdo->prepare("DELETE FROM student WHERE id=?")->execute([$id]);
    header("Location: student_list.php");
    exit;
}

$students = $pdo->query("SELECT * FROM student")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>学生列表</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
<style>
.avatar-img{ width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:8px; vertical-align:middle; }
.avatar-preview{ width:160px; height:160px; border-radius:8px; object-fit:cover; border:2px solid #ddd; }
.upload-box{ width:160px; height:160px; border:2px dashed #ccc; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:22px; cursor:pointer; color:#888; }
</style>
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
  <h4>学生列表</h4>
</div>
<div class="card-body">

<div class="mb-3">
  <button class="btn btn-success" data-toggle="modal" data-target="#batchAddModal">
    <i class="mdi mdi-plus"></i> 批量加分
  </button>
  <button class="btn btn-warning ml-2" data-toggle="modal" data-target="#batchMinusModal">
    <i class="mdi mdi-minus"></i> 批量扣分
  </button>
  <a href="print_student.php" target="_blank" class="btn btn-primary ml-2">
    <i class="mdi mdi-printer"></i> 打印学生积分表
  </a>
</div>

<div class="table-responsive">
<table class="table table-hover">
<thead>
<tr>
  <th><input type="checkbox" id="checkAll"> 全选</th>
  <th>头像</th>
  <th>姓名</th>
  <th>学号</th>
  <th>班级</th>
  <th>当前积分</th>
  <th>操作</th>
</tr>
</thead>
<tbody>
<?php foreach($students as $s): ?>
<tr>
  <td><input type="checkbox" class="student-checkbox" data-id="<?=$s['id']?>" data-name="<?=$s['name']?>"></td>
  <td>
    <?php
      $avt = $s['avatar'] ?? '';
      if(empty($avt)){
          $avt_src = './avatar/default.png';
      } else if(strpos($avt, 'http') === 0){
          $avt_src = $avt;
      } else {
          $avt_src = './avatar/'.$avt;
      }
    ?>
    <img src="<?=$avt_src?>" class="avatar-img">
  </td>
  <td><?=$s['name']?></td>
  <td><?=$s['code']?></td>
  <td><?=$s['class']?></td>
  <td><?=$s['score']?></td>
  <td>
  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal"
    data-id="<?=$s['id']?>"
    data-name="<?=$s['name']?>"
    data-code="<?=$s['code']?>"
    data-class="<?=$s['class']?>">编辑</button>

  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#avatarModal"
    data-id="<?=$s['id']?>"
    data-avatar="<?=$s['avatar']?>">头像</button>

  <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addScoreModal" data-id="<?=$s['id']?>">增加积分</button>
  <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#minusScoreModal" data-id="<?=$s['id']?>">减少积分</button>

  <!-- 打印明细 -->
  <button class="btn btn-sm btn-info"
    onclick="window.open('print_single.php?id=<?=$s['id']?>','_blank')">
    打印明细
  </button>

  <a href="?del=<?=$s['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('确定删除？')">删除</a>
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

<!-- 信息编辑弹窗 -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">编辑学生</h4>
      </div>
      <form action="student_edit.php" method="post">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>姓名</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>学号</label>
            <input type="text" name="code" id="edit_code" class="form-control">
          </div>
          <div class="form-group">
            <label>班级</label>
            <input type="text" name="class" id="edit_class" class="form-control" required>
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

<!-- 头像编辑弹窗 -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">编辑头像</h4>
      </div>
      <form id="avatarForm" enctype="multipart/form-data">
      <div class="modal-body text-center">
        <input type="hidden" id="avatar_id" name="id">
        <input type="hidden" name="avatar_type" id="avatar_type" value="url">

        <img id="currentAvatar" src="./avatar/default.png" class="avatar-preview mb-3">

        <div class="form-group text-left">
          <label>上传方式</label>
          <select id="avatarType" class="form-control">
            <option value="url">URL 网络地址</option>
            <option value="upload">本地上传</option>
          </select>
        </div>

        <div id="urlSection" class="form-group text-left">
          <label>头像 URL</label>
          <input type="text" name="avatar_url" class="form-control" placeholder="https://">
        </div>

        <div id="uploadSection" class="form-group text-center d-none">
          <div class="upload-box" onclick="document.getElementById('avatarFile').click()">
             <i class="mdi mdi-plus"></i>
          </div>
          <input type="file" id="avatarFile" name="avatar_file" accept="image/*" class="d-none">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-info" id="saveAvatar">保存头像</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- 批量加分弹窗 -->
<div class="modal fade" id="batchAddModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">批量加分</h4>
  </div>
  <div class="modal-body">
    <div id="batchAddNames" class="alert alert-info mb-3">未选择任何学生</div>
    <div class="form-group">
      <label>增加分数</label>
      <input type="number" id="batchAddScore" class="form-control" min="1" required>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="confirmBatchAdd">确认加分</button>
  </div>
</div>
</div>
</div>

<!-- 批量扣分弹窗 -->
<div class="modal fade" id="batchMinusModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">批量扣分</h4>
  </div>
  <div class="modal-body">
    <div id="batchMinusNames" class="alert alert-warning mb-3">未选择任何学生</div>
    <div class="form-group">
      <label>扣除分数</label>
      <input type="number" id="batchMinusScore" class="form-control" min="1" required>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-warning" id="confirmBatchMinus">确认扣分</button>
  </div>
</div>
</div>
</div>

<!-- 单加分 -->
<div class="modal fade" id="addScoreModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header"><h4 class="modal-title">增加积分</h4></div>
  <form action="score_handle.php?act=add" method="post">
    <div class="modal-body">
      <input type="hidden" name="id" id="add_id">
      <div class="form-group"><label>积分数量</label><input type="number" name="num" class="form-control" required></div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      <button type="submit" class="btn btn-success">确认</button>
    </div>
  </form>
</div>
</div>
</div>

<!-- 单扣分 -->
<div class="modal fade" id="minusScoreModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header"><h4 class="modal-title">减少积分</h4></div>
  <form action="score_handle.php?act=minus" method="post">
    <div class="modal-body">
      <input type="hidden" name="id" id="minus_id">
      <div class="form-group"><label>积分数量</label><input type="number" name="num" class="form-control" required></div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      <button type="submit" class="btn btn-warning">确认</button>
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
// 全选
$('#checkAll').click(function(){
  $('.student-checkbox').prop('checked', $(this).is(':checked'));
});

// 获取选中学生
function getSelectedStudents(){
  let arr = [];
  $('.student-checkbox:checked').each(function(){
    arr.push({ id: $(this).data('id'), name: $(this).data('name') });
  });
  return arr;
}

// 编辑弹窗赋值
$('#editModal').on('show.bs.modal', function (e) {
  var btn = $(e.relatedTarget);
  $('#edit_id').val(btn.data('id'));
  $('#edit_name').val(btn.data('name'));
  $('#edit_code').val(btn.data('code'));
  $('#edit_class').val(btn.data('class'));
});

// 头像弹窗
$('#avatarModal').on('show.bs.modal', function(e){
  let btn = $(e.relatedTarget);
  let id = btn.data('id');
  let avatar = btn.data('avatar');
  $('#avatar_id').val(id);

  let src = './avatar/default.png';
  if(avatar && avatar.trim() !== ''){
    if(avatar.indexOf('http') === 0){
      src = avatar;
    } else {
      src = './avatar/' + avatar;
    }
  }
  $('#currentAvatar').attr('src', src);
  $('#avatarType').val('url').trigger('change');
  // 清空上次选择
  $('#avatar_url').val('');
  $('#avatarFile').val('');
});

// 头像方式切换
$('#avatarType').change(function(){
  let v = $(this).val();
  $('#avatar_type').val(v);
  if(v === 'url'){
    $('#urlSection').removeClass('d-none');
    $('#uploadSection').addClass('d-none');
  } else {
    $('#urlSection').addClass('d-none');
    $('#uploadSection').removeClass('d-none');
  }
});

// 保存头像（修复版）
$('#saveAvatar').click(function(){
  let formData = new FormData($('#avatarForm')[0]);

  // 验证
  let type = $('#avatar_type').val();
  if(type === 'url' && !$('#avatar_url').val().trim()){
    alert('请输入URL地址');
    return;
  }
  if(type === 'upload' && $('#avatarFile')[0].files.length === 0){
    alert('请选择图片');
    return;
  }

  $.ajax({
    url: 'avatar_upload.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function(res){
      if(res.code === 0){
        alert('保存成功');
        location.reload();
      } else {
        alert('失败：' + res.msg);
      }
    },
    error: function(xhr){
      alert('请求失败：' + xhr.responseText);
    }
  });
});

// 批量加分弹窗
$('#batchAddModal').on('show.bs.modal', function(){
  let list = getSelectedStudents();
  let html = list.length === 0 ? '未选择任何学生' : '已选择：' + list.map(i=>i.name).join('、');
  $('#batchAddNames').html(html);
});

// 批量扣分弹窗
$('#batchMinusModal').on('show.bs.modal', function(){
  let list = getSelectedStudents();
  let html = list.length === 0 ? '未选择任何学生' : '已选择：' + list.map(i=>i.name).join('、');
  $('#batchMinusNames').html(html);
});

// 批量加分提交
$('#confirmBatchAdd').click(function(){
  let list = getSelectedStudents();
  if(list.length === 0){ alert('请选择学生'); return; }
  let num = parseInt($('#batchAddScore').val());
  if(!num || num < 1){ alert('请输入正确分数'); return; }
  if(!confirm('确定对 '+list.length+' 名学生 +'+num+' 分？')) return;

  $.post('batch_score.php', { act: 'add', ids: list.map(i=>i.id), num: num }, function(){
    alert('操作成功'); location.reload();
  });
});

// 批量扣分提交
$('#confirmBatchMinus').click(function(){
  let list = getSelectedStudents();
  if(list.length === 0){ alert('请选择学生'); return; }
  let num = parseInt($('#batchMinusScore').val());
  if(!num || num < 1){ alert('请输入正确分数'); return; }
  if(!confirm('确定对 '+list.length+' 名学生 -'+num+' 分？')) return;

  $.post('batch_score.php', { act: 'minus', ids: list.map(i=>i.id), num: num }, function(){
    alert('操作成功'); location.reload();
  });
});

// 单积分
$('#addScoreModal').on('show.bs.modal', function(e){ $('#add_id').val($(e.relatedTarget).data('id')); });
$('#minusScoreModal').on('show.bs.modal', function(e){ $('#minus_id').val($(e.relatedTarget).data('id')); });
</script>
</body>
</html>