<?php
include 'auth.php';
$page = 'import';
$page_title = '批量导入学生';

if ($_POST) {
    $lines = explode("\n", trim($_POST['lines']));
    $class = $_POST['class'];
    $score = $_POST['score'] ?: 100;

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        $arr = explode(' ', $line, 2);
        $name = $arr[0];
        $code = isset($arr[1]) ? $arr[1] : '';

        $stmt = $pdo->prepare("INSERT INTO student(name, code, class, score) VALUES (?,?,?,?)");
        $stmt->execute([$name, $code, $class, $score]);
    }

    header("Location: student_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>批量导入学生</title>
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
            <h4>批量导入学生</h4>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="form-group">
                <label>格式：姓名 学号（一行一个）</label>
                <textarea name="lines" rows="12" class="form-control" required placeholder="张三 2026001
李四 2026002
王五 2026003"></textarea>
              </div>

              <div class="form-group">
                <label>班级 *</label>
                <input type="text" name="class" class="form-control" required>
              </div>

              <div class="form-group">
                <label>初始积分</label>
                <input type="number" name="score" class="form-control" value="100">
              </div>

              <button type="submit" class="btn btn-primary">导入</button>
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
