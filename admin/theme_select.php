<?php
include 'auth.php';
$page_title = "前台主题选择";

// 保存主题
if (!empty($_POST['theme'])) {
    $theme = trim($_POST['theme']);
    $pdo->prepare("UPDATE config SET theme=?")->execute([$theme]);
    header("Location: theme_select.php?ok=1");
    exit;
}

// 获取当前主题
$cfg = $pdo->query("SELECT * FROM config LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$currentTheme = $cfg['theme'] ?? 'default';

// 扫描所有主题
$themes = [];
$themeDir = "../themes/";

if (is_dir($themeDir)) {
    $handle = opendir($themeDir);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != ".." && is_dir($themeDir . $file)) {
            $themes[] = $file;
        }
    }
    closedir($handle);
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<title>主题模板选择</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
<style>
.theme-card {
    transition: all .2s;
    border-width: 2px;
}
.theme-card.active {
    border-color: #0099ff;
}
.theme-preview {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 4px;
    background: #f5f5f5;
}
</style>
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
<div class="card-header"><h4>🎨 前台主题模板选择</h4></div>
<div class="card-body">

<?php if (isset($_GET['ok'])): ?>
<div class="alert alert-success">✅ 主题切换成功！前台已生效！</div>
<?php endif; ?>

<form method="post">
<div class="row">
<?php foreach ($themes as $t): ?>
<?php
$preview = '';
if (file_exists("../themes/$t/preview.jpg")) {
    $preview = "../themes/$t/preview.jpg";
} elseif (file_exists("../themes/$t/preview.png")) {
    $preview = "../themes/$t/preview.png";
}
?>
<div class="col-md-4 mb-4">
<div class="card theme-card p-2 <?php echo $t == $currentTheme ? 'active border-primary' : ''; ?>">
    <?php if ($preview): ?>
        <img src="<?php echo $preview; ?>" class="theme-preview mb-2">
    <?php else: ?>
        <div class="theme-preview d-flex align-items-center justify-content-center text-muted">
            暂无预览图
        </div>
    <?php endif; ?>

    <h5 class="text-center mb-2"><?php echo $t; ?></h5>

    <div class="text-center">
        <label class="mb-0">
            <input type="radio" name="theme" value="<?php echo $t; ?>" <?php echo $t == $currentTheme ? 'checked' : ''; ?>>
            使用此主题
        </label>
    </div>
</div>
</div>
<?php endforeach; ?>
</div>

<button class="btn btn-primary btn-lg btn-block">✅ 保存并应用主题</button>
</form>
</div>
</div>

<div class="card mt-3">
<div class="card-header"><h4>使用说明</h4></div>
<div class="card-body">
<ul>
<li>主题存放目录：<code>/themes/</code></li>
<li>预览图命名：<code>preview.jpg</code> 或 <code>preview.png</code></li>
<li>前台访问：<code>index.php</code></li>
</ul>
<a href="../index.php" target="_blank" class="btn btn-success">
👉 前往前台预览
</a>
</div>
</div>

</div>
</div>
</div>
</main>
</div></div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script src="js/main.min.js"></script>
</body>
</html>