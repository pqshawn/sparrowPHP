<?php
interface IBatchSatus
{    
      #region 授权支付状态
        /// <summary>
        /// [核准状态]属性 批量待复核：STATUS_UNCHECK
        /// </summary>
        const STATUS_UNCHECK = "0";

        /// <summary>
        /// [核准状态]属性 复核通过待发送：STATUS_CHECKSUCCESS
        /// </summary>
        const STATUS_CHECKSUCCESS = "1";

        /// <summary>
        /// [核准状态]属性 复核驳回：STATUS_REJECT
        /// </summary>
        const STATUS_REJECT = "2";

        /// <summary>
        /// [批量状态]属性 复核通过后已发送(等待处理)：STATUS_SEND
        /// </summary>
        const STATUS_SEND = "3";
        /// <summary>
        /// [批量状态]属性 处理成功：STATUS_SUCCESS
        /// </summary>
        const STATUS_SUCCESS = "4";
        /// <summary>
        /// [批量状态]属性 处理失败：STATUS_FAIL
        /// </summary>
        const STATUS_FAIL = "5";

        /// 以下三种状态仅针对处理完成的批量，通过查询批量内部各订单交易情况动态获得，仅用于页面显示，并不是批量状态的一种
        /// <summary>
        /// [批量状态]属性 批量内所有订单退款成功：STATUS_ALL_SUCCESS
        /// </summary>
        const STATUS_ALL_SUCCESS = "6";

        /// <summary>
        /// [批量状态]属性 批量内所有订单退款失败：STATUS_ALL_FAIL
        /// </summary>
        const STATUS_ALL_FAIL = "7";

        /// <summary>
        /// [批量状态]属性 批量内部分订单退款成功：STATUS_PART_SUCCESS
        /// </summary>
        const STATUS_PART_SUCCESS = "8";

        /// <summary>
        /// [状态]属性
        /// 未处理：STATUS_UNDONE
        /// </summary>
        const DETAIL_STATUS_UNDONE = "X";

        /// <summary>
        /// [状态]属性
        /// 成功：STATUS_SUCCESS
        /// </summary>
        const DETAIL_STATUS_SUCCESS = "0";

        /// <summary>
        /// [状态]属性
        /// 失败：STATUS_FAIL
        /// </summary>
        const DETAIL_STATUS_FAIL = "1";

        /// <summary>
        /// [状态]属性
        /// 无回应：STATUS_FAIL
        /// </summary>
        const DETAIL_STATUS_NORESPONSE = "2";

        #endregion
}

?>