<?php
    require_once('../ebusclient/QuickPaymentRequest.php');
     $tRequest = new QuickPaymentRequest();    
	 //1、生成定单订单对象，并将订单明细加入定单中
        $tRequest->order["PayTypeID"] = ($_POST['PayTypeID']);    //设定交易类型
        $tRequest->order["orderTimeoutDate"] = ($_POST['orderTimeoutDate']);                     //设定订单有效期
        $tRequest->order["OrderNo"] = ($_POST['PaymentRequestNo']);                       //设定订单编号 （必要信息）
        $tRequest->order["CurrencyCode"] = ($_POST['CurrencyCode']);    //设定交易币种
        $tRequest->order["OrderAmount"] = ($_POST['PaymentRequestAmount']);    //设定交易金额

        $tRequest->order["ExpiredDate"] = ($_POST['ExpiredDate']);//设定订单保存时间
        $tRequest->order["OrderDesc"] = ($_POST['OrderDesc']);                   //设定订单说明
        $tRequest->order["OrderDate"] = ($_POST['OrderDate']);                   //设定订单日期 （必要信息 - YYYY/MM/DD）
        $tRequest->order["OrderTime"] = ($_POST['OrderTime']);                   //设定订单时间 （必要信息 - HH:MM:SS）
        $tRequest->order["ReceiverAddress"] = ($_POST['ReceiverAddress']);     //收货地址
        $tRequest->order["BuyIP"] = ($_POST['BuyIP']);                           //IP
        
        $orderitem = array();
        $orderitem["SubMerName"] = "测试二级商户1";    //设定二级商户名称
        $orderitem["SubMerId"] = "12345";    //设定二级商户代码
        $orderitem["SubMerMCC"] = "0000";   //设定二级商户MCC码 
        $orderitem["SubMerchantRemarks"] = "测试";   //二级商户备注项
        $orderitem["ProductID"] = "IP000001";//商品代码，预留字段
        $orderitem["ProductName"] = "中国移动IP卡";//商品名称
        $orderitem["UnitPrice"] = "1.00";//商品总价
        $orderitem["Qty"] = "1";//商品数量
        $orderitem["ProductRemarks"] = "测试商品"; //商品备注项
        $orderitem["ProductType"] = "充值类";//商品类型
        $orderitem["ProductDiscount"] = "0.9";//商品折扣
        $orderitem["ProductExpiredDate"] = "10";//商品有效期
        $tRequest->orderitems[0] = $orderitem;

        $orderitem = array();
        $orderitem["SubMerName"] = "测试二级商户2";    //设定二级商户名称
        $orderitem["SubMerId"] = "12345";    //设定二级商户代码
        $orderitem["SubMerMCC"] = "0000";   //设定二级商户MCC码 
        $orderitem["SubMerchantRemarks"] = "测试";   //二级商户备注项
        $orderitem["ProductID"] = "IP000001";//商品代码，预留字段
        $orderitem["ProductName"] = "中国移动IP卡";//商品名称
        $orderitem["UnitPrice"] = "1.00";//商品总价
        $orderitem["Qty"] = "2";//商品数量
        $orderitem["ProductRemarks"] = "测试商品"; //商品备注项
        $orderitem["ProductType"] = "充值类";//商品类型
        $orderitem["ProductDiscount"] = "0.9";//商品折扣
        $orderitem["ProductExpiredDate"] = "10";//商品有效期
        $tRequest->orderitems[1] = $orderitem;
        //2、生成支付请求对象
        $tRequest->request["CardNo"] = ($_POST['PaymentAcctNo']); //支付账号
        $tRequest->request["MobileNo"] = ($_POST['MobilePhone']);//手机号
        $tRequest->request["CommodityType"] = ($_POST['CommodityType']);   //设置商品种类
        $tRequest->request["Installment"] = ($_POST['Installment']);  //分期标识
        if ($_POST['Installment'] === "1")
        {
            $tRequest->request["ProjectID"] = ($_POST['ProjectID']);    //设定分期代码
            $tRequest->request["Period"] = ($_POST['Period']);    //设定分期期数
        }
        $tRequest->request["PaymentType"] = ($_POST['PaymentType']);          //设定支付类型
        $tRequest->request["PaymentLinkType"] = ($_POST['PaymentLinkType']);      //设定支付接入方式
        $tRequest->request["ReceiveAccount"] = ($_POST['ReceiveAccount']);    //设定收款方账号
        $tRequest->request["ReceiveAccName"] = ($_POST['ReceiveAccName']);    //设定收款方户名
        $tRequest->request["MerchantRemarks"] = ($_POST['MerchantRemarks']);    //设定附言
        $tRequest->request["IsBreakAccount"] = ($_POST['IsBreakAccount']);    //设定交易是否分账
        $tRequest->request["SplitAccTemplate"] = ($_POST['SplitAccTemplate']);      //分账模版编号
    	$tResponse = $tRequest->postRequest();
    
    
	if ($tResponse->isSuccess()) {
		print ("<br>Success!!!" . "</br>");
		print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
		print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
		print("ECMerchantType   = [" . $tResponse->GetValue("ECMerchantType") . "]<br/>");
        print("MerchantID = [" . $tResponse->GetValue("MerchantID") . "]<br/>");
        print("TrxType = [" . $tResponse->GetValue("TrxType") . "]<br/>");
        print("OrderNo = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
        print("Amount = [" . $tResponse->GetValue("OrderAmount") . "]<br/>");
        print("VerifyDate = [" . $tResponse->GetValue("VerifyDate") . "]<br/>");
        print("VerifyTime = [" . $tResponse->GetValue("VerifyTime") . "]<br/>");
	}
	else
	{
		print("<br>Failed!!!"."</br>");
		print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
		print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
	}

?>


