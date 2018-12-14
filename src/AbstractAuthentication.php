<?php

namespace SsoSdk;

/**
 * 登录验证处理
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class AbstractAuthentication {

    /**
     * 是否已经登录
     */
    abstract public function handler();

    /**
     * 设置登录成功的session
     *
     * @param array $userInfo 登录用户的数据
     */
    abstract public function setSession($userinfo);
    
}