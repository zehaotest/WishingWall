<?php
require './common/init.php';
require './common/function.php';

// 接受变量
$id = max(input('get','id','d'), 0);
$name = trim(input('post','name','s'));
$color = input('post','color','s');
$content = trim(input('post','content','s'));
$password = input('post','password','s');

// 限制名称最多占用12个字符位置（1个汉字占用2个位置）
$name = mb_strimwidth($name, 0, 12);

// 当名称为空时，使用“匿名” 作为默认值
$name = $name ? : '匿名';

// 限制颜色值在合法的范围内，使用“green” 作默认值
if(!in_array($color, ['blue','yellow','green','red']))
{
	$color = 'green';
}

// 限制内容长度最多占用80个字符位置
$content = mb_strimwidth($content, 0, 80);

// 限制密码长度最多为6位
$password = (string) substr($password, 0, 6);

// 保存用户的发布时间
$time = time();

if ($id) 
{
	//验证密码是否正确
	$sql = 'select password from wish where id =' . $id;
	if (!$res = mysqli_query($link, $sql)) {
		exit("SQL[$sql]执行失败：" . mysqli_error($link));
	}
	if (!$data = mysqli_fetch_assoc($res)){
		exit('该愿望不存在！');
	}
	if ($data['password'] !== $password) {
		exit('密码不正确！');
	}
	
	// 有id就是修改
	$sql = 'update wish set name =?,color = ?, content =? where id=?';
	if (!$stmt = mysqli_prepare($link, $sql))
	{
		exit("SQL[$sql]预处理失败：" . mysqli_error($link));
	}
	mysqli_stmt_bind_param($stmt, 'sssi', $name, $color, $content , $id); 
	
}else{
	// 没有id就是添加
	$sql = 'insert into wish (name, color ,content,password,time) values (?,?,?,?,?)';
	if (!$stmt = mysqli_prepare($link, $sql))
	{
	exit("SQL[$sql]预处理失败：" . mysqli_error($link));	
	}

	mysqli_stmt_bind_param($stmt, 'ssssi' , $name ,$color, $content ,$password, $time);
}


if (!mysqli_stmt_execute($stmt)) 
{
	exit('数据库操作失败：' . mysqli_stmt_error($stmt));	
}

$page = max(input('get','page','d'),1);
header("Location: ./index.php?page=$page");
