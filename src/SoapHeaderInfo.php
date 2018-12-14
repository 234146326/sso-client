<?php

namespace SsoSdk;

use SsoSdk\AbstractSoapHeaderInfo;

/**
 * soap header验证需要的信息载体，必须要实现AbstractSoapHeaderInfo类
 *
 * @author jiang <mylampblog@163.com>
 */
class SoapHeaderInfo extends AbstractSoapHeaderInfo {

    /**
     * 设置soap header所需要的参数
     * 
     * @param array $headerUser
     * @access public
     */
    public function setHeaderUser($headerUser)
    {
        $this->headerUser = $headerUser;
        return $this;
    }

    /**
     * 设置soap header所需要的参数
     * 
     * @param array $headerUser
     * @access public
     */
    public function setHeaderPassword($headerPassword)
    {
        $this->headerPassword = $headerPassword;
        return $this;
    }

    /**
     * 设置soap header所需要的参数
     * 
     * @param array $headerUser
     * @access public
     */
    public function setHeaderToken($headerToken)
    {
        $this->headerToken = $headerToken;
        return $this;
    }
    
}