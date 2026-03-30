<?php
include 'auth.php';
$page = 'rule_student';
$page_title = '学生理由加减分';

$students = $pdo->query("SELECT * FROM student")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>学生理由加减分</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
<style>
.avatar-img{ width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:8px; vertical-align:middle; }
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
  <h4>学生理由加减分</h4>
</div>
<div class="card-body">

<div class="mb-3">
  <button class="btn btn-success" data-toggle="modal" data-target="#batchRuleAddModal">
    <i class="mdi mdi-plus"></i> 批量理由加分
  </button>
  <button class="btn btn-warning ml-2" data-toggle="modal" data-target="#batchRuleMinusModal">
    <i class="mdi mdi-minus"></i> 批量理由扣分
  </button>
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
    <button class="btn btn-sm btn-success" data-id="<?=$s['id']?>" onclick="openAddRule(this)">理由加分</button>
    <button class="btn btn-sm btn-warning" data-id="<?=$s['id']?>" onclick="openMinusRule(this)">理由扣分</button>
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

<!-- ====================== 单条 加分 ====================== -->
<div class="modal fade" id="singleAddRuleModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">选择理由加分</h4>
  </div>
  <div class="modal-body">
    <input type="hidden" id="add_student_id">
    <div class="form-group">
      <label>选择加分理由</label>
      <select id="add_rule_list" class="form-control"></select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="confirmAddRule">确认加分</button>
  </div>
</div>
</div>
</div>

<!-- ====================== 单条 扣分 ====================== -->
<div class="modal fade" id="singleMinusRuleModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">选择理由扣分</h4>
  </div>
  <div class="modal-body">
    <input type="hidden" id="minus_student_id">
    <div class="form-group">
      <label>选择扣分理由</label>
      <select id="minus_rule_list" class="form-control"></select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-warning" id="confirmMinusRule">确认扣分</button>
  </div>
</div>
</div>
</div>

<!-- ====================== 批量 加分 ====================== -->
<div class="modal fade" id="batchRuleAddModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">批量理由加分</h4>
  </div>
  <div class="modal-body">
    <div id="batchAddNames" class="alert alert-success mb-3">未选择任何学生</div>
    <div class="form-group">
      <label>选择加分理由</label>
      <select id="batch_add_rule" class="form-control"></select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-success" id="confirmBatchAddRule">确认批量加分</button>
  </div>
</div>
</div>
</div>

<!-- ====================== 批量 扣分 ====================== -->
<div class="modal fade" id="batchRuleMinusModal" tabindex="-1" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">批量理由扣分</h4>
  </div>
  <div class="modal-body">
    <div id="batchMinusNames" class="alert alert-warning mb-3">未选择任何学生</div>
    <div class="form-group">
      <label>选择扣分理由</label>
      <select id="batch_minus_rule" class="form-control"></select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-warning" id="confirmBatchMinusRule">确认批量扣分</button>
  </div>
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

// 获取选中
function getSelected(){
  let arr = [];
  $('.student-checkbox:checked').each(function(){
    arr.push({id:$(this).data('id'), name:$(this).data('name')});
  });
  return arr;
}

// 加载 加分理由（正数）
function loadAddRules(sel){
  $.getJSON('rule_get.php', function(res){
    let html = '';
    res.filter(r => r.score > 0).forEach(r => {
      html += `<option value="${r.id}">${r.title} (+${r.score}分)</option>`;
    });
    $(sel).html(html);
  });
}

// 加载 扣分理由（负数）
function loadMinusRules(sel){
  $.getJSON('rule_get.php', function(res){
    let html = '';
    res.filter(r => r.score < 0).forEach(r => {
      html += `<option value="${r.id}">${r.title} (${r.score}分)</option>`;
    });
    $(sel).html(html);
  });
}

// 单条加分
function openAddRule(btn){
  let id = $(btn).data('id');
  $('#add_student_id').val(id);
  loadAddRules('#add_rule_list');
  $('#singleAddRuleModal').modal('show');
}

// 单条扣分
function openMinusRule(btn){
  let id = $(btn).data('id');
  $('#minus_student_id').val(id);
  loadMinusRules('#minus_rule_list');
  $('#singleMinusRuleModal').modal('show');
}

// 确认单条加分
$('#confirmAddRule').click(function(){
  let sid = $('#add_student_id').val();
  let rid = $('#add_rule_list').val();
  if(!rid) { alert('请选择理由'); return; }
  $.post('rule_do.php', {id:sid, rid:rid}, function(){
    alert('加分成功');
    location.reload();
  });
});

// 确认单条扣分
$('#confirmMinusRule').click(function(){
  let sid = $('#minus_student_id').val();
  let rid = $('#minus_rule_list').val();
  if(!rid) { alert('请选择理由'); return; }
  $.post('rule_do.php', {id:sid, rid:rid}, function(){
    alert('扣分成功');
    location.reload();
  });
});

// 批量加分弹窗
$('#batchRuleAddModal').on('show.bs.modal', function(){
  let list = getSelected();
  $('#batchAddNames').html(list.length === 0 ? '未选择任何学生' : '已选择：'+list.map(i=>i.name).join('、'));
  loadAddRules('#batch_add_rule');
});

// 批量扣分弹窗
$('#batchRuleMinusModal').on('show.bs.modal', function(){
  let list = getSelected();
  $('#batchMinusNames').html(list.length === 0 ? '未选择任何学生' : '已选择：'+list.map(i=>i.name).join('、'));
  loadMinusRules('#batch_minus_rule');
});

// 确认批量加分
$('#confirmBatchAddRule').click(function(){
  let list = getSelected();
  if(list.length === 0) { alert('请选择学生'); return; }
  let rid = $('#batch_add_rule').val();
  if(!rid) { alert('请选择理由'); return; }
  
  $.post('rule_batch.php', {ids: list.map(i=>i.id), rid:rid}, function(){
    alert('批量加分成功');
    location.reload();
  });
});

// 确认批量扣分
$('#confirmBatchMinusRule').click(function(){
  let list = getSelected();
  if(list.length === 0) { alert('请选择学生'); return; }
  let rid = $('#batch_minus_rule').val();
  if(!rid) { alert('请选择理由'); return; }
  
  $.post('rule_batch.php', {ids: list.map(i=>i.id), rid:rid}, function(){
    alert('批量扣分成功');
    location.reload();
  });
});
</script>
</body>
</html>