<?php

namespace SsoSdk;

use SsoSdk\Libraries\Config;
use SsoSdk\Libraries\Help;
use SsoSdk\Libraries\Soap;
use SsoSdk\SoapHeaderInfo;
use SsoSdk\AbstractAuthentication;
use SsoSdk\AbstractSoapHeaderInfo;


/**
 * 单点登录客户端入口文件
 *
 * @author jiang <mylampblog@163.com>
 */
class SsoClient {

    /**
     * 配置读取类对象
     * 
     * @var object
     */
    private $config;

    /**
     * 初始化，实例化配置读取类
     *
     * @access public
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * 入口函数，判断是否已经登录，没有则跳转到验证中心登录
     *
     * @access public
     */
    public function run()
    {
//        if($authCheck = \think\facade\Session::get('ss')) return true;//testing
        //gettion session
//        if($authCheck = $this->authenticationFilter()) return true;
//        if( ! $authCheck and ! isset($_GET['ticket'])) return $this->redrectToSsoService();

        if(isset($_GET['ticket'])) {
            $userInfo = $this->ticketValidationFilter($_GET['ticket']);
            if( ! empty($userInfo) and isset($userInfo['username'])) {
//                \think\facade\Session::set('ss',$userInfo);//testing
                //settion session
//                $this->setClientSession($userInfo);
            } else/*if( ! $authCheck)*/ {
                $this->redrectToSsoService();
            }
        }else{
            $this->redrectToSsoService();
        }
    }

    /**
     * 跳转到验证中心
     *
     * @access private
     */
    private function redrectToSsoService()
    {
        $ssoservice = $this->config->get('ssoservice');
        $ssoclient = $this->config->get('ssoclient');
        Help::redrect($ssoservice.'?service='.$ssoclient);
    }

    /**
     * 判断是否已经登录，即登录过滤器
     *
     * @access private
     * @return boolean true|false
     */
    private function authenticationFilter()
    {
        return $this->getAuthenticationFilterManager()->handler();
    }

    /**
     * 取得登录验证的处理对象
     *
     * @access private
     * @return object 登录验证处理对象
     */
    private function getAuthenticationFilterManager()
    {
        $authconfig = $this->config->get('authenticate', 'default');
        if($authconfig == 'default') $authManager = '\\SsoSdk\\Authentication\\Authentication';
        else $authManager = $authconfig;
        $authManagerObject = new $authManager();
        if( ! $authManagerObject instanceof AbstractAuthentication) {
            throw new \Exception("auth manager must be instance of AbstractAuthentication.");
        }
        return $authManagerObject;
    }

    /**
     * 验证票据的正确性
     *
     * @param string $ticket 票据
     * @access private
     */
    private function ticketValidationFilter($ticket)
    {
        $ssoApiUrl = $this->config->get('ssoserviceapi');
        return $this->initSoap()->setSsoApi($ssoApiUrl)->buildSsoClient()->checkServiceTicket($ticket);
    }

    /**
     * 初始化一些soap的参数
     *
     * @access private
     * @return object
     */
    private function initSoap()
    {
        $soapHeaderInfo = new SoapHeaderInfo();
        if( ! $soapHeaderInfo instanceof AbstractSoapHeaderInfo) {
            throw new \Exception("soap header info object must be instance of AbstractSoapHeaderInfo.");
        }
        $ssoUserInfo = $this->config->get('ssouserinfo');
        $soapHeaderInfo->setHeaderUser($ssoUserInfo['ssouser'])->setHeaderPassword($ssoUserInfo['ssopassword'])->setHeaderToken($ssoUserInfo['ssotoken']);
        $soapClient = new Soap();
        $soapClient->setSoapHeaderParam($soapHeaderInfo);
        return $soapClient;
    }

    /**
     * 设置客户端的session
     *
     * @param array $userInfo 登录用户的信息
     * @access private
     */
    private function setClientSession($userInfo)
    {
        return $this->getAuthenticationFilterManager()->setSession($userInfo);
    }

}