<?php
interface IPaymentType
{
		/// <summary>支付类型：农行卡支付 
        /// </summary>
        const PAY_TYPE_ABC = "1";

        /// <summary>支付类型：国际卡支付 
        /// </summary>
        const PAY_TYPE_INT = "2";

        /// <summary>
        /// 支付类型：农行贷记卡支付
        /// </summary>
        const PAY_TYPE_CREDIT = "3";

        /// <summary>
        /// 支付类型：跨行支付
        /// </summary>
        const PAY_TYPE_EPCBS = "4";

        /// <summary>
        /// 支付类型：第三方跨行支付
        /// </summary>
        const PAY_TYPE_CBP = "5";

        /// <summary>
        /// 支付类型：银联跨行支付
        /// </summary>
        const PAY_TYPE_UCBP = "6";

        /// <summary>
        /// 支付账户类型：对公户
        /// </summary>
        const PAY_TYPE_CORP = "7";

        /// <summary>
        /// 支付类型：农行支付合并类型
        /// </summary>
        const PAY_TYPE_ALL = "A";
}

?>