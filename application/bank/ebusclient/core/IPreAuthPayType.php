<?php
interface IPreAuthPayType
{
		/// <summary>
        /// 预授权取消(Cancel)
        /// </summary>
        const PREAUTHPAY_TYPE_CANCEL = "Cancel";
        /// <summary>
        /// 预授权确认(Confirm)
        /// </summary>
        const PREAUTHPAY_TYPE_CONFIRM = "Confirm";
}

?>