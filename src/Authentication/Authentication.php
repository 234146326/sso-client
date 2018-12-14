<?php

namespace SsoSdk\Authentication;

use SsoSdk\AbstractAuthentication;
use SsoSdk\Libraries\Session;

/**
 * 登录验证处理，这里只是一个例子，所有的实现必需要继承自AbstractAuthentication
 *
 * @author jiang <mylampblog@163.com>
 */
class Authentication extends AbstractAuthentication
{
    /**
     * 登录session标识
     */
    CONST LOGIN_SESSION = 'LOGIN';

    /**
     * session操作对象
     * 
     * @var object
     */
    private $session;

    /**
     * session操作对象
     *
     * @param object $sessionObj
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * 是否已经登录，一般会针对不同的应用写不同的实现。外部会调用这个函数来实现。
     * 当然，你可以通过配置来指定不同的文件来实现。
     *
     * @access public
     */
    public function handler()
    {
//        var_dump($this->session->get(self::LOGIN_SESSION));
//        type($this->session);
        return ! empty($this->session->get(self::LOGIN_SESSION)) ? true : false;
    }

    /**
     * 设置登录的session
     * 
     * @param array $userinfo 用户的信息
     */
    public function setSession($userinfo)
    {
        return $this->session->set(self::LOGIN_SESSION, $userinfo);
    }

}