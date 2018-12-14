<?php

namespace SsoSdk\Libraries;

/**
 * 读取配置文件
 *
 * @author jiang <mylampblog@163.com>
 */
class Config {

	/**
	 * 配置数组
	 * 
	 * @var array
	 */
	private $config;

	/**
	 * 初始化
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->config = require_once(__DIR__.'/../../config/config.php');
	}

	/**
	 * 获取配置
	 * 
	 * @param  string  $key     配置的key
	 * @param  mixed $default 默认值
	 * @return mixed           返回配置的值
	 * @access public
	 */
	public function get($key, $default = false)
	{
		if( ! isset($this->config[$key])) {
			if($default) return $default;
			return false;
		}
		return $this->config[$key];
	}
}