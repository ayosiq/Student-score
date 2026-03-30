<?php
include 'auth.php';
$page = 'add';
$page_title = '新增学生';

if ($_POST) {
    $name  = $_POST['name'];
    $code  = $_POST['code'];
    $class = $_POST['class'];
    $score = $_POST['score'] ?: 100;

    $stmt = $pdo->prepare("INSERT INTO student(name, code, class, score) VALUES (?,?,?,?)");
    $stmt->execute([$name, $code, $class, $score]);

    header("Location: student_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>新增学生</title>
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
            <h4>新增学生</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal">
              <div class="form-group">
                <label class="col-sm-2 control-label">姓名 *</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">学号</label>
                <div class="col-sm-10">
                  <input type="text" name="code" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">班级 *</label>
                <div class="col-sm-10">
                  <input type="text" name="class" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">初始积分</label>
                <div class="col-sm-10">
                  <input type="number" name="score" class="form-control" value="100">
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary">保存</button>
                </div>
              </div>
            </form>
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
