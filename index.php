<?php
require './common/init.php';
require './common/function.php';
//var_dump($link);

// 获取当前码数，限制最小值为1
$page = max(input('get','page','d'), 1);
// 每页显示的条数
$size = 4 ;

//查询愿望的总数量
$sql = 'select count(*) from wish';
if (!$res = mysqli_query($link, $sql)){
	exit("SQL[$sql]执行失败：" . mysqli_error($link));
}

$total = (int)mysqli_fetch_row($res)[0];

// 分页查询愿望
$sql = 'select id ,name ,content ,time ,color from wish order by id desc limit ' . page_sql($page, $size);

if (!$res = mysqli_query($link ,$sql)){
	exit("SQL[sql]执行失败：". mysqli_error($link));
}

$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);

$id = max (input('get','id','d'),0);
$action = input('get','action','s');
if ($id)
{
	$password = input('post','password','s');
	$sql = 'select name ,content , color ,password from wish where id = ' . $id;
	if (!$res = mysqli_query($link, $sql)) 
	{
		exit("SQL[$sql]执行失败：" . mysqli_error($link) . $sql);
	}
	if (!$edit = mysqli_fetch_assoc($res))
	{
		exit('该愿望不存在！');
	}
	mysqli_free_result($res);
	
	// true 密码为空不需要验证 ： 用户没有提交输入密码表单 false有密码，需要进行验证 用户提交了表单
	$checked = isset($_POST['password']) || empty($edit['password']);
	if ($checked && $password !== $edit['password']){
		$tips = '密码不正确！';
		$checked = false; // 验证失败，还需要再次验证
	}
	
	// 删除愿望
	if ($checked && $action == 'delete') {
		$sql = 'delete from wish where id =' . $id;
		if(!mysqli_query($link, $sql)){
			exit('SQL执行失败：' . mysqli_error($link));
		}
		header ('Location: index.php');
		exit;
	}
}

mysqli_close($link);

// 查询结果为空时，自动返回第一页
if(empty($data) && $page > 1){
	header('Location: index.php?page=1');
	exit;
}
require './view/common2/add.html';
require './view/index.html';


?>