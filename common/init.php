<?php
// 判断当前PHP是否为PHP5.4或以上
if (version_compare(PHP_VERSION, '5.4','<')){
	exit('最低要求PHP版本5.4');
}
// 判断有没有开启mbstring扩展
if (!extension_loaded('mbstring')){
	// echo '未开启mbstring扩展';
	exit ('未开启mbstring扩展');
}
// 项目中设置时区
	date_default_timezone_set('Asia/Shanghai');
	
// 配置mbstring扩展的字符集
	mb_internal_encoding('UTF-8');

// 连接数据库

$link = new mysqli ('localhost' ,'root' ,'' ,'account_pdo_db');
if(!$link){
	exit('数据库连接失败：' . mysqli_connect_error());
}

mysqli_set_charset($link, 'utf8');
?>