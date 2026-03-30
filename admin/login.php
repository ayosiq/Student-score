<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>登录 - 光年后台管理系统</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
</head>
<body class="lyear-layout-web">
<div class="lyear-layout-container">
<main class="lyear-layout-content">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="card">
                <div class="card-header"><h4>管理员登录</h4></div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label>账号</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">登 录</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</div>

<?php
if ($_POST) {
  if ($_POST['username'] === 'admin' && $_POST['password'] === '123456') {
    $_SESSION['admin'] = 'admin';
    header("Location: index.php");
    exit;
  } else {
    echo "<script>alert('账号或密码错误');</script>";
  }
}
?>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script src="js/main.min.js"></script>
</body>
</html>
