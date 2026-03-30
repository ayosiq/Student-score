<?php
include 'auth.php';
$page = 'log';
$page_title = '积分操作日志';

// 分页
$page_size = 20;
$page_no = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page_no - 1) * $page_size;

// 筛选条件
$student_id = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;
$where = [];
$params = [];

if ($student_id > 0) {
    $where[] = "l.student_id = ?";
    $params[] = $student_id;
}

$where_sql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

// 总数
$stmt = $pdo->prepare("SELECT COUNT(*) FROM score_log l $where_sql");
$stmt->execute($params);
$total = $stmt->fetchColumn();
$total_page = (int)ceil($total / $page_size);

// 查询列表（关联显示理由名称）
$sql = "SELECT l.*, s.name, s.code, sr.title AS rule_title
        FROM score_log l
        LEFT JOIN student s ON l.student_id = s.id
        LEFT JOIN score_rules sr ON l.rule_id = sr.id
        $where_sql
        ORDER BY l.create_time DESC
        LIMIT $start, $page_size";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 学生列表
$students = $pdo->query("SELECT id, name FROM student ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>积分日志</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/materialdesignicons.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
<style>
.label {padding:3px 8px;border-radius:4px;font-size:13px;color:#fff;}
.label.add {background:#28a745;}
.label.minus {background:#dc3545;}
.rule-label {margin-left:8px; padding:2px 6px; background:#17a2b8; color:#fff; border-radius:4px; font-size:12px;}
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
<div class="card-header"><h4>积分操作日志</h4></div>
<div class="card-body">

<form method="get" class="form-inline mb-3">
    <div class="form-group mr-3">
        <label>学生：</label>
        <select name="student_id" class="form-control ml-2">
            <option value="">全部</option>
            <?php foreach($students as $st): ?>
                <option value="<?=$st['id']?>" <?=$student_id==$st['id']?'selected':''?>>
                    <?=$st['name']?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary btn-sm" type="submit">筛选</button>
    <a href="score_log.php" class="btn btn-outline-secondary btn-sm ml-2">重置</a><br><br>
    <a href="print_log.php" target="_blank" class="btn btn-info btn-sm ml-2">
  <i class="mdi mdi-printer"></i> 打印全部日志
</a>
</form>
<br>
<div class="table-responsive">
<table class="table table-bordered table-hover">
<thead>
<tr>
<th>ID</th>
<th>学生</th>
<th>学号</th>
<th>类型</th>
<th>变动分数</th>
<th>理由</th> <!-- 只加了这一列 -->
<th>时间</th>
</tr>
</thead>
<tbody>
<?php foreach($list as $item): ?>
<tr>
<td><?=$item['id']?></td>
<td><?=$item['name'] ?: '已删除'?></td>
<td><?=$item['code'] ?: '-'?></td>
<td>
    <?php if($item['type']=='add'): ?>
        <span class="label add">加分</span>
    <?php else: ?>
        <span class="label minus">扣分</span>
    <?php endif; ?>
</td>
<td><?=$item['score']?></td>
<td>
    <?php if(!empty($item['rule_title'])): ?>
        <span class="rule-label"><?=$item['rule_title']?></span>
    <?php else: ?>
        <span style="color:#999;">手动操作</span>
    <?php endif; ?>
</td>
<td><?=$item['create_time']?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<nav>
<ul class="pagination justify-content-center">
    <li class="page-item <?=$page_no<=1?'disabled':''?>">
        <a class="page-link" href="?page=<?=$page_no-1?>&student_id=<?=$student_id?>">上一页</a>
    </li>
    <?php for($i=1;$i<=$total_page;$i++): ?>
        <li class="page-item <?=$i==$page_no?'active':''?>">
            <a class="page-link" href="?page=<?=$i?>&student_id=<?=$student_id?>"><?=$i?></a>
        </li>
    <?php endfor; ?>
    <li class="page-item <?=$page_no>=$total_page?'disabled':''?>">
        <a class="page-link" href="?page=<?=$page_no+1?>&student_id=<?=$student_id?>">下一页</a>
    </li>
</ul>
</nav>

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