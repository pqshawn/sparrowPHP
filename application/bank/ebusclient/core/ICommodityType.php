<?php
class ICommodityType {
	/// <summary>
	/// 商品种类：充值类	支付账户充值(0101)
	/// </summary>
	const COMMODITY_TYPE_RECHARGE_0101 = "0101";
	/// <summary>
	/// 商品种类：消费类	虚拟类(0201),如：游戏点卡、游戏装备、手机充值卡、礼品卡
	/// </summary>
	const COMMODITY_TYPE_CONSUME_0201 = "0201";
	/// <summary>
	/// 商品种类：消费类  传统类(0202),如：百货商城、数码家电、服饰、食品等 
	/// </summary>
	const COMMODITY_TYPE_CONSUME_0202 = "0202";
	/// <summary>
	/// 商品种类：消费类	实名类(0203),如：航空售票、酒店预订、旅游产品等
	/// </summary>
	const COMMODITY_TYPE_CONSUME_0203 = "0203";
	/// <summary>
	/// 商品种类：转账类	本行转账(0301)
	/// </summary>
	const COMMODITY_TYPE_TRANSFER_0301 = "0301";
	/// <summary>
	/// 商品种类：转账类	他行转账(0302)
	/// </summary>
	const COMMODITY_TYPE_TRANSFER_0302 = "0302";
	/// <summary>
	/// 商品种类：缴费类	水费(0401)
	/// </summary>
	const COMMODITY_TYPE_FEE_0401 = "0401";
	/// <summary>
	/// 商品种类：缴费类	电费(0402)
	/// </summary>
	const COMMODITY_TYPE_FEE_0402 = "0402";
	/// <summary>
	/// 商品种类：缴费类	煤气费(0403)
	/// </summary>
	const COMMODITY_TYPE_FEE_0403 = "0403";
	/// <summary>
	/// 商品种类：缴费类	有线电视费(0404)
	/// </summary>
	const COMMODITY_TYPE_FEE_0404 = "0404";
	/// <summary>
	/// 商品种类：缴费类	通讯费(0405)
	/// </summary>
	const COMMODITY_TYPE_FEE_0405 = "0405";
	/// <summary>
	/// 商品种类：缴费类	物业费(0406)
	/// </summary>
	const COMMODITY_TYPE_FEE_0406 = "0406";
	/// <summary>
	/// 商品种类：缴费类	保险费(0407)
	/// </summary>
	const COMMODITY_TYPE_FEE_0407 = "0407";
	/// <summary>
	/// 商品种类：缴费类	行政费用(0408)
	/// </summary>
	const COMMODITY_TYPE_FEE_0408 = "0408";
	/// <summary>
	/// 商品种类：缴费类	税费(0409)
	/// </summary>
	const COMMODITY_TYPE_FEE_0409 = "0409";
	/// <summary>
	/// 商品种类：缴费类	学费(0410)
	/// </summary>
	const COMMODITY_TYPE_FEE_0410 = "0410";
	/// <summary>
	/// 商品种类：缴费类	其他(0499)
	/// </summary>
	const COMMODITY_TYPE_FEE_OTHER = "0499";
	/// <summary>
	/// 商品种类：理财类	基金(0501)
	/// </summary>
	const COMMODITY_TYPE_FINANCIAL_0501 = "0501";
	/// <summary>
	/// 商品种类：理财类	理财产品(0502)
	/// </summary>
	const COMMODITY_TYPE_FINANCIAL_0502 = "0502";
	/// <summary>
	/// 商品种类：理财类	其他(0599)
	/// </summary>
	const COMMODITY_TYPE_FINANCIAL_OTHER = "0599";

	 private static $COMMODITY_TYPE = array (
		"0101",
		"0201",
		"0202",
		"0203",
		"0301",
		"0302",
		"0401",
		"0402",
		"0403",
		"0404",
		"0405",
		"0406",
		"0407",
		"0408",
		"0409",
		"0410",
		"0499",
		"0501",
		"0502",
		"0599"
	);
	public static function InArray($commodity)
	{
		return in_array($commodity, self::$COMMODITY_TYPE);
	}
}
?>