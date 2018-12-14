<?php

namespace SsoSdk\Libraries;

/**
 * 常用函数
 *
 * @author jiang <mylampblog@163.com>
 */
class Help {

	/**
	 * 跳转
	 * 
	 * @param  string $url 跳转的url
	 */
	static public function redrect($url)
	{
		header("Location:$url");
		exit;
	}
	
}