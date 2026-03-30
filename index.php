<?php
// 数据库配置
require 'admin/config.php';

// 获取当前启用的主题
$cfg = $pdo->query("SELECT * FROM config LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$theme = $cfg['theme'] ?? 'default';

// 安全过滤，防止路径穿越
$theme = preg_replace('/[^a-z0-9_-]/i', '', $theme);

// 加载对应主题
$themeFile = "./themes/{$theme}/index.php";

if (file_exists($themeFile)) {
    require $themeFile;
} else {
    exit("❌ 主题文件不存在，请在后台切换主题！<br><a href='theme_select.php'>点击前往主题设置</a>");
}
?>