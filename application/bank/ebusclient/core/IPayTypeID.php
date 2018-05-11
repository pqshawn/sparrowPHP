<?php
interface IPayTypeID
{
		/// <summary>交易种类:直接支付
        /// </summary>
        const PAY_TYPE_DIRECTPAY = "ImmediatePay";

        /// <summary>交易种类:预授权支付
        /// </summary>
        const PAY_TYPE_PREAUTH = "PreAuthPay";

        /// <summary>交易种类:分期支付
        /// </summary>
        const PAY_TYPE_INSTALLMENTPAY = "DividedPay";
        /// <summary>交易种类:授权支付
        /// </summary>
        const PAY_TYPE_AGENTPAY = "AgentPay";
        /// <summary>交易种类:退款
        /// </summary>
        const PAY_TYPE_REFUND = "Refund";
        /// <summary>交易种类:付款
        /// </summary>
        const PAY_TYPE_DEFRAYPAY = "DefrayPay";
        /// <summary>交易种类：预授权确认
        /// </summary>
        const PAY_TYPE_PREAUTHED = "PreAuthed";
        /// <summary>交易种类：预授权取消
        /// </summary>
        const PAY_TYPE_PREAUTHCANCEL = "PreAuthCancel";
}

?>