<?php

namespace SsoSdk\Libraries;

/**
 * session 处理类
 *
 * @author jiang <mylampblog@163.com>
 */

class Session {

    /**
     * session cookie的一些配置
     * 
     * @var array
     */
    private $_cookieParams = array('httponly' => true);

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        register_shutdown_function(array($this, 'close'));
        if ($this->getIsActive()) return ;
        $this->open();
    }

    /**
     * session 是否已经开启
     * 
     * @return boolean true|false
     */
    public function getIsActive()
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    /**
     * 打开session
     */
    public function open()
    {
        $this->registerSessionHandler();
        $this->setCookieParamsInternal();
        @session_start();
        if ( ! $this->getIsActive()) {
            throw new \Exception("Session faile to start.");
        }
    }

    /**
     * 注册session handler
     * 
     * @todo 待完善
     */
    protected function registerSessionHandler()
    {
        return true;
    }

    /**
     * 返回session_set_cookie_params所需的参数
     * 
     * @return array
     */
    public function getCookieParams()
    {
        return array_merge(session_get_cookie_params(), array_change_key_case($this->_cookieParams));
    }

    /**
     * 设定session_set_cookie_params
     */
    protected function setCookieParamsInternal()
    {
        $data = $this->getCookieParams();
        extract($data);
        if (isset($lifetime, $path, $domain, $secure, $httponly)) {
            session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
        } else {
            throw new \Exception(
                'Please make sure cookieParams contains these elements: lifetime, path, domain, secure and httponly.'
            );
        }
    }

    /**
     * 取得session
     * 
     * @param  string $key          session的key
     * @param  mixed $defaultValue  取不到值的默认值
     * @return mixed                session的值
     */
    public function get($key, $defaultValue = null)
    {
        $this->open();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
    }

    /**
     * 设置session
     * 
     * @param string $key   session的key
     * @param mixed $value  session的值
     */
    public function set($key, $value)
    {
        $this->open();
        $_SESSION[$key] = $value;
    }

    /**
     * 删除session
     * 
     * @param  string $key session的key
     * @return void
     */
    public function remove($key)
    {
        $this->open();
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);

            return $value;
        } else {
            return null;
        }
    }

    /**
     * 消除session
     * 
     * @return void
     */
    public function destroy()
    {
        if ($this->getIsActive()) {
            @session_unset();
            @session_destroy();
        }
    }

    /**
     * 关闭session,写入session数据
     * 
     * @return void
     */
    public function close()
    {
        if ($this->getIsActive()) {
            @session_write_close();
        }
    }


}