<?php
interface IFunctionID
{
     /// <summary>
        ///  商户交易请求类型 - 直接支付请求
        /// </summary>
         const  TRX_TYPE_PAY_REQ = "PayReq";

        /// <summary>
        ///  商户交易请求类型 - 预授权支付请求
        /// </summary>
         const  TRNX_TYPE_PAY_PREAUTH = "PreAuthReq";
        /// <summary>
        /// 商户交易请求类型 - 分期支付
        /// </summary>
         const  TRNX_TYPE_PAY_INSTALLMENT = "INSTALLMENTReq";

         /**
         * 商户交易请求类型 - 账单发送
         */
         const  TRX_TYPE_KPAYVERIFY_REQ = "KPayVerifyReq";
        /**
         * 商户交易请求类型 - 验证码重发
         */
         const  TRX_TYPE_KPAYRESEND_REQ = "KPayResendReq";
        /**
         * 商户交易请求类型 - K码支付
         */
         const  TRX_TYPE_KPAY_REQ = "KPayReq";
        /// <summary>
        ///  商户交易请求类型 - 手机支付请求
        /// </summary>
         const  TRX_TYPE_MOBILEPAY_REQ = "MobilePayReq";
        /// <summary>
        ///  商户交易请求类型 - 手机支付请求
        /// </summary>
         const  TRX_TYPE_MPAYREG_REQ = "MobilePayReg";
        /// <summary>
        ///  商户交易请求类型 - 卡余额查询请求
        /// </summary>
         const  TRX_TYPE_CRADBALANCE_REQ = "CardBalanceReq";
        /// <summary>
        ///  商户交易请求类型 - 取消支付
        /// </summary>
         const  TRX_TYPE_VOID_PAY = "VoidPay";

        /// <summary>
        ///  商户交易请求类型 - 退货
        /// </summary>
         const  TRX_TYPE_REFUND = "Refund";

        /// <summary>
        ///  商户交易请求类型 - 批量退款
        /// </summary>
         const  TRX_TYPE_OVERDUEREFUND = "BatchRefund";

        /// <summary>
        ///  商户交易请求类型 - 查询批量退款
        /// </summary>
         const  TRX_TYPE_QUERYOVERDUEREFUND = "QueryBatchRefund";

        /// <summary>
        ///  商户交易请求类型 - 取消退货
        /// </summary>
         const  TRX_TYPE_VOID_REFUND = "VoidRefund";

        /// <summary>
        ///  商户交易请求类型 - 对账
        /// </summary>
         const  TRX_TYPE_SETTLE = "Settle";

        /// <summary>
        ///  商户交易请求类型 - 对账
        /// </summary>
         const  TRX_TYPE_CBPSETTLE = "CBPSettle";

        /// <summary>
        ///  商户交易请求类型 - 订单状态查询
        /// </summary>
         const  TRX_TYPE_QUERY = "Query";

        /// <summary>
        ///  商户交易请求类型 - 订单状态查询
        /// </summary>
         const  TRX_TYPE_QUERYTRNXRECORDS = "QueryTrnxRecords";

        /// <summary>
        ///  商户交易请求类型 - 支付结果通知
        /// </summary>
         const  TRX_TYPE_PAY_RESULT = "PayResult";


        /// <summary>
        ///  基金支付交易请求
        /// 
        /// </summary>
         const  TRX_TYPE_FUND_PAY_REQ = "FundPayReq";

        /// <summary>
        ///  身份验证交易请求
        /// 
        /// </summary>
         const  TRX_TYPE_CARD_VERIFY_REQ = "CardVerifyReq";

        /// <summary>
        ///  身份验证交易请求
        /// 
        /// </summary>
         const  TRX_TYPE_IDENTITY_VERIFY_REQ = "IdentityVerifyReq";
        /// <summary>
        ///  身份验证交易请求
        /// 
        /// </summary>
         const  TRX_TYPE_STATIC_IDENTITY_VERIFY_REQ = "StaticIdentifyVerifyReq";

        /// <summary>
        ///  退款批量文件发送
        /// 
        /// </summary>
         const  TRX_TYPE_BATCH_SEND_REQ = "RefundBatchSendReq";

        /// <summary>
        ///  查询批量处理结果
        /// 
        /// </summary>
         const  TRX_TYPE_QUERY_BATCH_REQ = "QueryBatchReq";

        /// <summary>
        ///  授权支付签约
        /// </summary>
         const  TRX_TYPE_EBUS_AgentSignContract_REQ = "AgentSign";
        /// <summary>
        ///  授权支付解约
        /// </summary>
         const  TRX_TYPE_EBUS_AgentUnsignContract_REQ = "AgentUnSign";
        /// <summary>
        ///  授权支付签约(商户端)
        /// </summary>
         const  TRX_TYPE_EBUS_InterfaceAgentSignContract_REQ = "InterfaceAgentSignReq";

        ///  授权支付签约短信验证码重发(商户端)
        /// </summary>
         const  TRX_TYPE_EBUS_InterfaceAgentSignContract_ReSend_REQ = "InterfaceAgentSignResend";

        ///  授权支付签约确认(商户端)
        /// </summary>
         const  TRX_TYPE_EBUS_InterfaceAgentSignSubmit_REQ = "InterfaceAgentSignSubmit";
        
        /// <summary>
        ///  授权支付单笔扣款
        /// </summary>
         const  TRX_TYPE_EBUS_AgentPayment_REQ = "AgentPay";

        /// <summary>
        ///  授权支付签约结果
        /// </summary>
         const  TRX_TYPE_EBUS_AgentSignContract_RESULT = "AgentSignResult";
        /// <summary>
        ///  授权支付批量
        /// </summary>
         const  TRX_TYPE_EBUS_AGENTBATCH_REQ = "AgentBatch";
        /// <summary>
        ///  预授权取消/确认
        /// </summary>
         const  TRX_TYPE_EBUS_PREAUTHCANCELCONFIRM_REQ = "PreAuthCancelConfirm";

        /// <summary>
        ///  商户交易请求类型 - 查询授权支付签约信息
        /// </summary>
         const  TRX_TYPE_QUERYAGENTSIGN = "QueryAgentSign";

        /// <summary>
        ///  授权支付批量结果查询
        /// </summary>
         const  TRX_TYPE_EBUS_AGENTBATCHQUERY_RESULT = "AgentBatchQuery";
}

?>