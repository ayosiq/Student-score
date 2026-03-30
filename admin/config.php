<?php
// 数据库配置（统一修改这里）
$host = '127.0.0.1';
$dbname = '192_168_1_3';
$user = '192_168_1_3';
$pass = 'y5i5nbX8ha';

// PDO 连接
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败");
}
?>
