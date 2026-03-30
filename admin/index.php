<?php
include 'auth.php';
$page = 'index';
$page_title = '控制台';

// 学生总数
$total = $pdo->query("SELECT COUNT(*) FROM student")->fetchColumn();

// 今日
$today = date('Y-m-d');

// 今日加分
$addToday = $pdo->prepare("SELECT SUM(score) FROM score_log WHERE type='add' AND DATE(create_time) = ?");
$addToday->execute([$today]);
$today_add = $addToday->fetchColumn() ?: 0;

// 今日扣分
$minusToday = $pdo->prepare("SELECT SUM(score) FROM score_log WHERE type='minus' AND DATE(create_time) = ?");
$minusToday->execute([$today]);
$today_minus = $minusToday->fetchColumn() ?: 0;

// 昨日加分
$yesterday = date('Y-m-d', strtotime('-1 day'));
$addYes = $pdo->prepare("SELECT SUM(score) FROM score_log WHERE type='add' AND DATE(create_time) = ?");
$addYes->execute([$yesterday]);
$yesterday_add = $addYes->fetchColumn() ?: 0;

// 昨日扣分
$minusYes = $pdo->prepare("SELECT SUM(score) FROM score_log WHERE type='minus' AND DATE(create_time) = ?");
$minusYes->execute([$yesterday]);
$yesterday_minus = $minusYes->fetchColumn() ?: 0;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>控制台</title>
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

  <!-- 数据卡片 -->
  <div class="row">
    <div class="col-sm-6 col-lg-3">
      <div class="card bg-primary">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white">学生总数</p>
            <p class="h3 text-white"><?=$total?></p>
          </div>
          <div class="pull-left">
            <span class="img-avatar img-avatar-48 bg-translucent">
              <i class="mdi mdi-account fa-1-5x"></i>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card bg-success">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white">今日加分</p>
            <p class="h3 text-white">+<?=$today_add?></p>
          </div>
          <div class="pull-left">
            <span class="img-avatar img-avatar-48 bg-translucent">
              <i class="mdi mdi-arrow-up fa-1-5x"></i>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card bg-danger">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white">今日扣分</p>
            <p class="h3 text-white">-<?=$today_minus?></p>
          </div>
          <div class="pull-left">
            <span class="img-avatar img-avatar-48 bg-translucent">
              <i class="mdi mdi-arrow-down fa-1-5x"></i>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card bg-info">
        <div class="card-body clearfix">
          <div class="pull-right">
            <p class="h6 text-white">昨日总加分</p>
            <p class="h3 text-white">+<?=$yesterday_add?></p>
          </div>
          <div class="pull-left">
            <span class="img-avatar img-avatar-48 bg-translucent">
              <i class="mdi mdi-calendar-check fa-1-5x"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- 文本公告块 -->
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>📌 系统公告</h4>
        </div>
        <div class="card-body">
          <div class="alert alert-primary">
            <h5 class="alert-heading">欢迎使用时显和积分看板于一体的积分管理系统</h5>
            <p class="mb-0">
              支持学生管理、积分增减、日志记录、昨日/今日积分榜单展示。<br>
              前端大屏页面可实时查看班级排名，后台可统一管理。
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>
</main>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script src="js/main.min.js"></script>
</body>
</html>
