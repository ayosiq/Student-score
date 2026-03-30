<?php
$current = basename($_SERVER['SCRIPT_NAME']);
?>
<!-- 左侧导航 -->
<aside class="lyear-layout-sidebar">
  <div id="logo" class="sidebar-header">
    <a href="index.php"><img src="https://ct.inskyo.cn/uploads/20260130/18d7d3e600ba2d0ca0d22bf2e7dd9261.png" alt="LightYear" /></a>
  </div>
  <div class="lyear-layout-sidebar-scroll"> 
    <nav class="sidebar-main">
      <ul class="nav nav-drawer">

        <!-- 控制台 -->
        <li class="nav-item <?php if($current=='index.php') echo 'active' ?>">
          <a href="index.php"><i class="mdi mdi-home"></i> 控制台</a>
        </li>

        <!-- 学生功能 -->
        <li class="nav-item nav-item-has-subnav 
          <?php if(in_array($current,['student_list.php','student_add.php','student_import.php','theme_select.php'])) echo 'active open' ?>">
          
          <a href="javascript:void(0)" class="dropdown-toggle">
            <i class="mdi mdi-account-group"></i> 学生功能 <span class="caret"></span>
          </a>
          
          <ul class="nav nav-subnav">
            <li class="<?php if($current=='student_list.php') echo 'active' ?>">
              <a href="student_list.php">学生列表</a>
            </li>
            <li class="<?php if($current=='student_add.php') echo 'active' ?>">
              <a href="student_add.php">新增学生</a>
            </li>
            <li class="<?php if($current=='student_import.php') echo 'active' ?>">
              <a href="student_import.php">批量导入</a>
            </li>
         
        </li>
   <li class="<?php if($current=='theme_select.php') echo 'active' ?>">
              <a href="theme_select.php">前台模板</a>
            </li>
            </ul>
        </li>
        <!-- 理由加减分功能 -->
        <li class="nav-item nav-item-has-subnav 
          <?php if(in_array($current,['rule_list.php','student_rule.php'])) echo 'active open' ?>">
          
          <a href="javascript:void(0)" class="dropdown-toggle">
            <i class="mdi mdi-format-list-bulleted"></i> 理由扣分 <span class="caret"></span>
          </a>
          
          <ul class="nav nav-subnav">
            <li class="<?php if($current=='rule_list.php') echo 'active' ?>">
              <a href="rule_list.php">理由列表</a>  
            </li>
            <li class="<?php if($current=='student_rule.php') echo 'active' ?>">
              <a href="student_rule.php">理由加减分</a>
            </li>
           </ul>
        </li>
       
        <!-- 积分日志 -->
   <li class="nav-item nav-item-has-subnav 
          <?php if(in_array($current,['score_log.php','print_log_filter.php'])) echo 'active open' ?>">
          
          <a href="javascript:void(0)" class="dropdown-toggle">
            <i class="mdi mdi-format-list-bulleted"></i> 日志管控 <span class="caret"></span>
          </a>
          
          <ul class="nav nav-subnav">
            <li class="<?php if($current=='score_log.php') echo 'active' ?>">
              <a href="score_log.php">积分日志</a>  
            </li>
            <li class="<?php if($current=='student_rule.php') echo 'active' ?>">
              <a href="print_log_filter.php">日志打印</a>
            </li>
          </ul>
        </li>
<!-- 头衔管理 -->
<li class="nav-item nav-item-has-subnav 
<?php if(in_array($current,['title_list.php','student_bind_title.php'])) echo 'active open' ?>">
  <a href="javascript:void(0)" class="dropdown-toggle">
    <i class="mdi mdi-crown"></i> 头衔管理 <span class="caret"></span>
  </a>
  <ul class="nav nav-subnav">
    <li class="<?php if($current=='title_list.php') echo 'active' ?>">
      <a href="title_list.php">头衔列表</a>
    </li>
    <li class="<?php if($current=='student_bind_title.php') echo 'active' ?>">
      <a href="student_bind_title.php">学生绑定</a>
    </li>
  </ul>
</li>

  

    <div class="sidebar-footer">
      <p class="copyright">Copyright &copy; 2025 <a href="https://blog.inlyra.cn" target="_blank" style="color:inherit;">菱华科技</a></p>
    </div>

  </div>
</aside>