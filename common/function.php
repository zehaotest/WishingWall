<?php
/**
 * 接受用户输入
 * @param array $method 输出的数组
 * @param string $home 从数组中取出的变量名
 * @param string $type 表示类型的字符串（s=字符串，d=整形，a=数组）
 * @param mixed $default 变量不存在时使用的默认值 
 * @return mixed 接受结果
 */
 function input($method,$name,$type ='s',$default='')
 {
 	switch ($method){
		case 'get' : $method = $_GET;
			break;
		case 'post' : $method = $_POST;
			break;
 	}
	
 	$data = isset($method[$name]) ? $method[$name] : $default;
	switch ($type){
		case 's' : return is_string($data) ? $data : $default;
		case 'd' : return (int) $data;
		case 'a' : return is_array($data) ? $data :[];
		default : trigger_error('不存在的过滤类型“' . $type .'”');
	}
 }
 /**
  * 格式化日期
  * @param type $time 给定时间戳
  * @return string 从给定时间到现在经过了多少时间（天/小时/分钟/秒）
  */
 
 function format_date($time)
 {
 	$diff = time() - $time;
	$format = [86400 => '天' ,3600 => '小时', 60 => '分钟', 1 => '秒'];
	foreach ($format as $k => $v) {
		$result = floor($diff / $k);
		if ($result) {
			return $result . $v;
		}
	}
	return '0.5秒';
 }
 /**
  * 获取LIMIT的参数
  * @param int $page 当前页码值
  * @param int $size 每页显示的条数
  * @return string 生成后的结果
  */
	function page_sql($page, $size)
  {
  	return ($page - 1) * $size . ',' . $size;
  }
  
  /**
   * 生成分页导航HTML
   * @param string $url 链接地址（示例“./index.php?page=”）
   * @param int $total 总记录数
   * @param init $page 当前页码数
   * @param int $size 每页显示的条数
   * @return string 生成的HTML结果
   */
   function page_html($url,$total,$page,$size)
   {
   	// 计算总页数
   	$maxpage = max(ceil($total / $size), 1);
	// 如果不足2页，则不显示分页导航
	if ($maxpage <= 1){
		return '';
	}
	if ($page == 1) {
		$first = '<span>首页</span>';
		$prev = '<span>上一页</span>';
	}else {
		$first = "<a href=\"{$url}1\">首页</a>";
		$prev = '<a href="' . $url . ($page - 1) . '">上一页 </a>';
	}
	if ($page == $maxpage){
		$next = '<span>下一页</span>';
		$last = '<span>尾页</span>';
	}else {
		$next = '<a href="' . $url . ($page + 1) . '">下一页</a>';
		$last = "<a href=\"{$url}{$maxpage}\">尾页</a>";
	}
	// 组合最终样式
	return "<p>当前位于：$page/$maxpage</p>$first $prev $next $last";
   }
?>