<?php
		require_once('../ebusclient/AgentSignContractRequest.php');
		//1、生成授权支付签约请求对象
        $tRequest = new AgentSignContractRequest();
        $tRequest->request["CertificateNo"] = ($_POST['CertificateNo']);             //证件号码       （必要信息）
        $tRequest->request["CertificateType"] = ($_POST['CertificateType']);//证件类型       （必要信息）农行卡类型
        $tRequest->request["NotifyType"] = ($_POST['NotifyType']);                 //通知类型 （必要信息）
        $tRequest->request["ResultNotifyURL"] = ($_POST['ResultNotifyURL']);         //通知地址（必要信息）
        $tRequest->request["OrderNo"] = ($_POST['OrderNo']);                         //订单编号（必要信息）
        $tRequest->request["PaymentLinkType"] = ($_POST['PaymentLinkType']);                 //接入渠道 （必要信息）
        $tRequest->request["MerCustomNo"] = ($_POST['MerCustomNo']);                 //客户编号     
        $tRequest->request["CardType"] = ($_POST['CardType']);                         //农行卡类型 （必要信息）
        $tRequest->request["OrderDate"] = ($_POST['RequestDate']);                 //验证请求日期 （必要信息 - YYYY/MM/DD）
        $tRequest->request["OrderTime"] = ($_POST['RequestTime']);                 //验证请求时间 （必要信息 - HH:MM:SS）
        $tRequest->request["InvaidDate"] = ($_POST['InvaidDate']);                 //签约有效期 （必要信息）
        $tRequest->request["IsSign"] = ($_POST['IsSign']);                 //签约标识 （必要信息）

        //2、传送授权支付签约请求并取得签约网址     
        $tResponse = $tRequest->postRequest();   
	    
		if ($tResponse->isSuccess()) {
			print ("<br>Success!!!" . "</br>");
			print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
			print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
            print("OrderNo      = [" . $tResponse->GetValue("OrderNo") . "]<br/>");
            //3、授权支付签约请求提交成功，将客户端导向签约页面
            $B2CAgentSignContractURL = $tResponse->GetValue("B2CAgentSignContractURL");
            print("<br>PaymentURL=$B2CAgentSignContractURL"."</br>");
			echo "<script language='javascript'>";
			echo "window.location.href='$B2CAgentSignContractURL'";
			echo "</script>";
		}
		else
		{
			print("<br>Failed!!!"."</br>");
			print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
			print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
		}
?>