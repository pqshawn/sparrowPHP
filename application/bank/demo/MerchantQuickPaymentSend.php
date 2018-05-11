<?php
    require_once('../ebusclient/QuickPaymentSend.php');
         //1、生成支付请求对象
        $tRequest = new QuickPaymentSend();

        $tRequest->order["OrderNo"] = ($_POST['OrderNo']);                       //设定订单编号 （必要信息）
        $tRequest->order["CurrencyCode"] = ($_POST['CurrencyCode']);    //设定交易币种，
        $tRequest->order["OrderAmount"] = ($_POST['OrderAmount']); //设定订单金额 （必要信息）
        $tRequest->order["Fee"] = ($_POST['Fee']); //设定手续费金额
        $tRequest->order["OrderDate"] = ($_POST['OrderDate']);                   //设定订单日期 （必要信息 - YYYY/MM/DD）
        $tRequest->order["OrderTime"] = ($_POST['OrderTime']);                   //设定订单时间 （必要信息 - HH:MM:SS）

        $tRequest->request["AccName"] = ($_POST['AccName']);
        $tRequest->request["CertificateType"] = ($_POST['CertificateType']);
        $tRequest->request["CertificateID"] = ($_POST['CertificateID']);
        $tRequest->request["ExpDate"] = ($_POST['ExpDate']);
        $tRequest->request["CVV2"] = ($_POST['CVV2']);
        $tRequest->request["VerifyCode"] = ($_POST['VerifyCode']);
        $tRequest->request["PaymentType"] = ($_POST['PaymentType']);          //设定支付类型
        $tRequest->request["PaymentLinkType"] = ($_POST['PaymentLinkType']);      //设定支付接入方式
        $tRequest->request["MerchantRemarks"] = ($_POST['MerchantRemarks']);  //设定商户备注信息

        //2、传送支付请求并返回结果
        $tResponse = $tRequest->postRequest();
    
	   	
			//3、支付请求提交成功，返回结果信息
		if ($tResponse->isSuccess()) {
			print ("<br>Success!!!" . "</br>");
			print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
			print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
            print("ECMerchantType   = [" . $tResponse->GetValue("ECMerchantType") . "]<br/>");
            print("MerchantID = [" . $tResponse->GetValue("MerchantID") . "]<br/>");
            print("TrxType = [" . $tResponse->GetValue("TrxType") . "]<br/>");
            print("OrderNo = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
            print("Amount = [" . $tResponse->GetValue("OrderAmount") . "]<br/>");
            print("HostDate = [" . $tResponse->GetValue("HostDate") . "]<br/>");
            print("HostTime = [" . $tResponse->GetValue("HostTime") . "]<br/>");
		}
		else
		{
			print("<br>Failed!!!"."</br>");
			print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
			print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
		}
?>