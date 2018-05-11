<?php
interface ILength
{
    /*
    * 长度限制常量
    */
    /** 支付结果回传网址最大长度 */
    const RESULT_NOTIFY_URL_LEN = 200;
    /** 商户备注信息最大长度 */
    const MERCHANT_REMARKS_LEN  = 200;
    /**商户订单编号最大长度*/
    const ORDERID_LEN = 30;
    /**商户批次编号最大长度*/
    const BATCHID_LEN = 12;
    /**商户批内序号最大长度*/
    const SEQUENCEID_LEN = 6;
    /**订单描述最大长度*/
    const ORDER_DESC_LEN = 40;
    /**基金产品编号最大长度*/
    const PRODUCTID_LEN = 20;
    /**卡号最大长度*/
    const CARDNO_LEN =20;
    /**产品名称长度*/
    const PRODUCTNAME_LEN = 200;
    /**证件号码最大长度*/
    const CERTIFICATENO_LEN =30;
    /**日期长度*/
    const DATEYYYYMMDD_LEN = 8;
    /**时间长度*/
    const TIMEHHMMSS_LEN =6;
    /**商户编号长度*/
    const MERCHANTID_LEN = 15;
    /**账户名称最大长度*/
    const ACCNAME_LEN = 60;
    /**摘要最大长度*/
    const ABSTRACT_LEN = 60;
    /**最大笔数**/
    const MAXSUMCOUNT = 10000;
}

?>