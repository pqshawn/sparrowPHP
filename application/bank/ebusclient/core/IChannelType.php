<?php
interface IChannelType
{
    /// <summary>接入方式:INTENET网络 
    /// </summary>
    const PAY_LINK_TYPE_NET = "1";

    /// <summary>接入方式:MOBILE网络 
    /// </summary>
    const PAY_LINK_TYPE_MOBILE = "2";

    /// <summary>接入方式:数字电视网络 
    /// </summary>
    const PAY_LINK_TYPE_TV = "3";

    /// <summary>
    /// 接入方式:智能客户端
    /// </summary>
    const PAY_LINK_TYPE_IC = "4";

    /// <summary>
    /// 接入方式:电话网络
    /// </summary>
    const PAY_LINK_TYPE_TEL = "5";
    
    //银联移动跨行支付接入方式
    /// <summary>
    /// 接入方式：wap页面接入
    /// </summary>
    const UPMPLINK_TYPE_WAP = "0";
    /// <summary>
    /// 接入方式：客户端接入
    /// </summary>
    const UPMPLINK_TYPE_CLIENT = "1";
}

?>