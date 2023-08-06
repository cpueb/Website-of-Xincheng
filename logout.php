<?php
session_start();
// 清除会话数据
session_unset();
session_destroy();
// 跳转到登录页面
header("Location: login.php");
exit;
?>
