<?php

namespace SsoSdk\Libraries;

use SsoSdk\AbstractSoapHeaderInfo;

/**
 * soap 客户端
 *
 * @author jiang <mylampblog@163.com>
 */
class Soap {

    /**
     * soap client客户端实例化的时候所用的参数
     * 
     * @var object
     */
    private $soapUri = 'abc';

    /**
     * soap client客户端对象
     * 
     * @var object
     */
    private $soapClient;

    /**
     * sso 中心对外api接口地址
     * 
     * @var string
     */
    private $ssoApi;

    /**
     * soap请求的头部信息
     * 
     * @var object \SsoSdk\AbstractSoapHeaderInfo
     */
    private $soapHeaderInfo;

    /**
     * 初始化soap客户端
     * 
     * @return object $this
     * @access public
     */
    public function buildSsoClient()
    {
        $this->soapClient = new \SoapClient(null, array('location' => $this->ssoApi, 'uri'=>$this->soapUri, 'encoding' => 'utf-8'));
        $this->setSoapHeader();
        return $this;
    }

    /**
     * 设置 sso 中心对外api接口地址
     * 
     * @param string $ssoApi
     * @return object $this
     * @access public
     */
    public function setSsoApi($ssoApi)
    {
        $this->ssoApi = $ssoApi;
        return $this;
    }

    /**
     * 检测票据的合法性
     * 
     * @param  string $serviceTicket ST票据
     * @return boolean false|当前登录的用户信息
     * @access public
     */
    public function checkServiceTicket($serviceTicket)
    {
        return $this->soapClient->checkServiceTicket($serviceTicket);
    }

    /**
     * 设置请求soap请求的头部信息
     * 
     * @param object $soapHeaderInfo \SsoSdk\AbstractSoapHeaderInfo
     */
    public function setSoapHeaderParam($soapHeaderInfo)
    {
        if( ! $soapHeaderInfo instanceof AbstractSoapHeaderInfo) {
            throw new \Exception("soap header info object must be instance of AbstractSoapHeaderInfo.");
        }
        $this->soapHeaderInfo = $soapHeaderInfo;
    }

    /**
     * soap请求的头部信息，进行请求验证。
     *
     * @access private
     */
    private function setSoapHeader()
    {
        //后两个参数好像也可以去掉
        $soapHeader = new \SoapHeader($this->soapUri, 'Authorise', $this->soapHeaderInfo, false, SOAP_ACTOR_NEXT);
        $this->soapClient->__setSoapHeaders(array($soapHeader));
    }

}