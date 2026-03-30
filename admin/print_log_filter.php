<?php
include 'auth.php';
$page_title = '积分日志打印';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>积分日志打印</title>
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
<div class="card-header"><h4>积分日志打印筛选</h4></div>
<div class="card-body">

<form action="print_log_do.php" method="get" target="_blank">
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label>开始时间</label>
        <input type="datetime-local" name="start_time" class="form-control" required>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>结束时间</label>
        <input type="datetime-local" name="end_time" class="form-control" required>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label>操作类型</label>
        <select name="type" class="form-control">
          <option value="all">全部</option>
          <option value="add">仅加分</option>
          <option value="minus">仅扣分</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary btn-block">
          <i class="mdi mdi-printer"></i> 生成打印页面
        </button>
      </div>
    </div>
  </div>
</form>

</div>
</div>
</div>
</div>
</div>
</main>

</div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script src="js/main.min.js"></script>
</body>
</html>