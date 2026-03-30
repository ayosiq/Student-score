<?php
include 'auth.php';
header('Content-Type: application/json');

$id = (int)$_POST['id'];
$type = $_POST['avatar_type'] ?? '';
$avatar = '';

if ($id <= 0) {
    echo json_encode(['code' => 1, 'msg' => 'ID错误']);
    exit;
}

$uploadDir = __DIR__ . '/avatar/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

if ($type === 'url') {
    $avatar = trim($_POST['avatar_url']);
} elseif ($type === 'upload' && $_FILES['avatar_file']['error'] == 0) {
    $file = $_FILES['avatar_file'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = "student_$id_" . time() . ".$ext";
    move_uploaded_file($file['tmp_name'], $uploadDir . $name);
    $avatar = $name;
}

if (!empty($avatar)) {
    $pdo->prepare("UPDATE student SET avatar=? WHERE id=?")->execute([$avatar, $id]);
}

echo json_encode(['code' => 0, 'msg' => '成功']);
?>