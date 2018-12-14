<?php

namespace SsoSdk;

/**
 * soap header验证需要的信息载体
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class AbstractSoapHeaderInfo {

    /**
     * soap header所需要的参数
     * 
     * @var array
     */
    public $headerUser;

    /**
     * soap header所需要的参数
     * 
     * @var array
     */
    public $headerPassword;

    /**
     * soap header所需要的参数
     * 
     * @var array
     */
    public $headerToken;

    /**
     * 设置soap header所需要的参数
     * 
     * @param array $headerUser
     * @access public
     */
    abstract public function setHeaderUser($headerUser);

    /**
     * 设置soap header所需要的参数
     * 
     * @param array $headerUser
     * @access public
     */
    abstract public function setHeaderPassword($headerPassword);

    /**
     * 设置soap header所需要的参数
     * 
     * @param array $headerUser
     * @access public
     */
    abstract public function setHeaderToken($headerToken);

}