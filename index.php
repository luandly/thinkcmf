<?php
$GoTo="public/admin/index";// 如果这里的目标链接取自数据库就实现了动态转向
// $GoTo="public/user/login/index.html";// 如果这里的目标链接取自数据库就实现了动态转向
//http://10.5.45.107/ourfirst/public/admin/index/index.html 后台登录系统
// http://10.5.45.107/ourfirst/public/admin/public/login.html  //跳转到后台登录界面后台
// http://10.5.45.107/ourfirst/public/admin/index  //跳转到系统的登录界面后台
header(sprintf("Location: %s", $GoTo));
?>