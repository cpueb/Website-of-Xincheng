<?php
session_start();
// 检查用户是否已登录，如果未登录则跳转到登录页面
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
// 处理用户提交的留言表单
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $message = $_POST['message'];
    
    // 获取当前时间和用户名
    $time = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    
    // 将留言存储在会话中
    if(!isset($_SESSION['messages'])){
        $_SESSION['messages'] = array();
    }
    $_SESSION['messages'][] = array(
        'time' => $time,
        'username' => $username,
        'message' => $message
    );
    
    // 将留言保存到 ly.txt 文件中
    $file = fopen("ly.txt", "a");
    fwrite($file, "[$time] $username: $message" . PHP_EOL);
    fclose($file);
}
// 读取 ly.txt 文件中的留言
$messages = array();
if(file_exists("ly.txt")){
    $file = fopen("ly.txt", "r");
    while(!feof($file)){
        $line = fgets($file);
        if(trim($line) != ""){
            $messages[] = $line;
        }
    }
    fclose($file);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新城中学留言板</title>
    <style>
     body {
      background: linear-gradient(to right, #23074d, #cc5333);
      color: white;
      font-size: 24px;
        }
        
        h3 {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
    <h2>欢迎 <?php echo $_SESSION['username']; ?>!</h2>
    
    <h3>留下一句话吧……</h3>
    <form action="" method="POST">
        <textarea name="message" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="发送">
    </form>
    
    <h3>留言板</h3>
    <?php if(empty($messages)): ?>
        <p>没有留言！</p>
    <?php else: ?>
        <ul>
            <?php foreach($messages as $message): ?>
                <li><?php echo $message; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <p><a href="logout.php">退出登陆</a></p>
    <p><a href="https://pyxczx.cn/">返回主页</a></p>
</body>
</html>
