<?php
class TrxException extends Exception
{
    const TRX_EXC_CODE_1000 = '1000';
    const TRX_EXC_CODE_1001 = '1001';
    const TRX_EXC_CODE_1002 = '1002';
    const TRX_EXC_CODE_1003 = '1003';
    const TRX_EXC_CODE_1004 = '1004';
    const TRX_EXC_CODE_1005 = '1005';
    const TRX_EXC_CODE_1006 = '1006';
    const TRX_EXC_CODE_1007 = '1007';
    const TRX_EXC_CODE_1008 = '1008';
    const TRX_EXC_CODE_1100 = '1100';
    const TRX_EXC_CODE_1101 = '1101';
    const TRX_EXC_CODE_1102 = '1102';
    const TRX_EXC_CODE_1103 = '1103';
    const TRX_EXC_CODE_1104 = '1104';
    const TRX_EXC_CODE_1201 = '1201';
    const TRX_EXC_CODE_1202 = '1202';
    const TRX_EXC_CODE_1203 = '1203';
    const TRX_EXC_CODE_1204 = '1204';
    const TRX_EXC_CODE_1205 = '1205';
    const TRX_EXC_CODE_1206 = '1206';
    const TRX_EXC_CODE_1301 = '1301';
    const TRX_EXC_CODE_1302 = '1302';
    const TRX_EXC_CODE_1303 = '1303';
    const TRX_EXC_CODE_1304 = '1304';
    const TRX_EXC_CODE_1999 = '1999';
    
    const TRX_EXC_MSG_1000 = '无法读取商户端配置文件';
    const TRX_EXC_MSG_1001 = '商户端配置文件中参数设置错误';
    const TRX_EXC_MSG_1002 = '无法读取证书文档';
    const TRX_EXC_MSG_1003 = '无法读取商户私钥';
    const TRX_EXC_MSG_1004 = '无法写入交易日志文档';
    const TRX_EXC_MSG_1005 = '证书过期';
    const TRX_EXC_MSG_1006 = '证书格式错误';
    const TRX_EXC_MSG_1007 = '配置文件中MerchantID、MerchantCertFile、MerchantCertPassword属性个数不一致';
    const TRX_EXC_MSG_1008 = '指定的商户配置编号不合法';
    const TRX_EXC_MSG_1100 = '商户提交的交易资料不完整';
    const TRX_EXC_MSG_1101 = '商户提交的交易资料不合法';
    const TRX_EXC_MSG_1102 = '签名交易报文时发生错误';
    const TRX_EXC_MSG_1103 = '无法连线签名服务器';
    const TRX_EXC_MSG_1104 = '签名服务器返回签名错误';
    const TRX_EXC_MSG_1201 = '无法连线网上支付平台';
    const TRX_EXC_MSG_1202 = '提交交易时发生网络错误';
    const TRX_EXC_MSG_1203 = '无法接收到网上支付平台的响应';
    const TRX_EXC_MSG_1204 = '接收网上支付平台响应报文时发生网络错误';
    const TRX_EXC_MSG_1205 = '无法辨识网上支付平台的响应报文';
    const TRX_EXC_MSG_1206 = '网上支付平台服务暂时停止';
    const TRX_EXC_MSG_1301 = '网上支付平台的响应报文不完整';
    const TRX_EXC_MSG_1302 = '网上支付平台的响应报文签名验证失败';
    const TRX_EXC_MSG_1303 = '无法辨识网上支付平台的交易结果';
    const TRX_EXC_MSG_1304 = '解压缩交易记录时发生错误';
    const TRX_EXC_MSG_1999 = '系统发生无法预期的错误';


    protected $code = '';

    protected $iDetailMessage = '';

    public function __construct($aCode, $aMessage, $aDetailMessage='')
    {
        parent::__construct($aMessage);
        $this->code = trim($aCode);
        $this->iDetailMessage = trim($aDetailMessage);
    }

    public function getDetailMessage()
    {
        return $this->iDetailMessage;
    }

}
/*
$e = new TrxException('code', 'msg', 'dmsg');
echo $e->getMessage();
*/
?>