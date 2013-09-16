<?php
 
				include("include/config.php");
				if($_GET['action'] == "export_transaction" && $_GET['for'] == "client")
				{
				$sql="";
				$sql = "SELECT * FROM transactions WHERE client_id = ".mysql_real_escape_string($_GET['id'])." and broker_id=".mysql_real_escape_string($_GET['broker_id'])."";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
                     $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
					 $sql="";
					 $sql = "SELECT * FROM `vendors` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `vendor_id` = '".$row['vendor_id']."'";
					 $rs3= mysql_query($sql);
					 $row3=mysql_fetch_row($rs3);
					 $output .= $row['transaction_date'].','.$row2[2].','.$row3[2].','.$row['description'].','.$row['billing_amount'].','.$row['payble_amount'].','.$row['payment_date'].','.$row['payment_status'].','.$row['brokerage']."\n";
				}
					header("Content-type:text/octect-stream");
					header("Content-Disposition:attachment;filename=data.csv");
					header("Pragma: no-cache");
					header("Expires: 0");
					$header='Transaction Date,Client Name,Vendor Name,Description,Billing Amount,Payable Amount,Payment Date,Payment status,Brokerage';
					print "$header\n$output";
					exit;
				}
				else if($_GET['action'] == "export_transaction" && $_GET['for'] == "vendor")
				{
				$sql="";
				$sql = "SELECT * FROM transactions WHERE vendor_id = ".mysql_real_escape_string($_GET['id'])." and broker_id=".mysql_real_escape_string($_GET['broker_id'])."";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
                     $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
					 $sql="";
					 $sql = "SELECT * FROM `vendors` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `vendor_id` = '".$row['vendor_id']."'";
					 $rs3= mysql_query($sql);
					 $row3=mysql_fetch_row($rs3);
					 $output .= $row['transaction_date'].','.$row2[2].','.$row3[2].','.$row['description'].','.$row['billing_amount'].','.$row['payble_amount'].','.$row['payment_date'].','.$row['payment_status'].','.$row['brokerage']."\"\n";
				}
					header("Content-type:text/octect-stream");
					header("Content-Disposition:attachment;filename=data.csv");
					header("Pragma: no-cache");
					header("Expires: 0");
					$header='Transaction Date,Client Name,Vendor Name,Description,Billing Amount,Payable Amount,Payment Date,Payment status,Brokerage';
					print "$header\n$output";
					exit;
				}
				else if($_GET['action'] == "export_month_transaction" && $_GET['for'] == "month")
				{
				$sql="";
				$sql = "SELECT * FROM transactions WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and transaction_date between  '2012-".mysql_real_escape_string($_GET['id'])."-01' and '2012-".mysql_real_escape_string($_GET['id'])."-31'";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
                     $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
					 $sql="";
					 $sql = "SELECT * FROM `vendors` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `vendor_id` = '".$row['vendor_id']."'";
					 $rs3= mysql_query($sql);
					 $row3=mysql_fetch_row($rs3);
					 $output .= $row['transaction_date'].','.$row2[2].','.$row3[2].','.$row['description'].','.$row['billing_amount'].','.$row['payble_amount'].','.$row['payment_date'].','.$row['payment_status'].','.$row['brokerage']."\"\n";
				}
					header("Content-type:text/octect-stream");
					header("Content-Disposition:attachment;filename=data.csv");
					header("Pragma: no-cache");
					header("Expires: 0");
					$header='Transaction Date,Client Name,Vendor Name,Description,Billing Amount,Payable Amount,Payment Date,Payment status,Brokerage';
					print "$header\n$output";
					exit;
				}
				else if($_GET['action'] == "export_quarter_transaction" && $_GET['for'] == "quarter")
				{
				$sql="";
				$sql = "SELECT * FROM transactions WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and transaction_date between  '2012-".mysql_real_escape_string($_GET['id'])."-01' and '2012-".mysql_real_escape_string($_GET['id']+'2')."-31'";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
                     $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
					 $sql="";
					 $sql = "SELECT * FROM `vendors` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `vendor_id` = '".$row['vendor_id']."'";
					 $rs3= mysql_query($sql);
					 $row3=mysql_fetch_row($rs3);
					 $output .= $row['transaction_date'].','.$row2[2].','.$row3[2].','.$row['description'].','.$row['billing_amount'].','.$row['payble_amount'].','.$row['payment_date'].','.$row['payment_status'].','.$row['brokerage']."\"\n";
				}
					header("Content-type:text/octect-stream");
					header("Content-Disposition:attachment;filename=data.csv");
					header("Pragma: no-cache");
					header("Expires: 0");
					$header='Transaction Date,Client Name,Vendor Name,Description,Billing Amount,Payable Amount,Payment Date,Payment status,Brokerage';
					print "$header\n$output";
					exit;
				}
				else if($_GET['action'] == "export_year_transaction" && $_GET['for'] == "year")
				{
				$sql="";
				$sql = "SELECT * FROM transactions WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and transaction_date between  '2012-01-01' and '2012-12-31'";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
                     $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
					 $sql="";
					 $sql = "SELECT * FROM `vendors` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `vendor_id` = '".$row['vendor_id']."'";
					 $rs3= mysql_query($sql);
					 $row3=mysql_fetch_row($rs3);
					 $output .= $row['transaction_date'].','.$row2[2].','.$row3[2].','.$row['description'].','.$row['billing_amount'].','.$row['payble_amount'].','.$row['payment_date'].','.$row['payment_status'].','.$row['brokerage']."\"\n";
				}
					header("Content-type:text/octect-stream");
					header("Content-Disposition:attachment;filename=data.csv");
					header("Pragma: no-cache");
					header("Expires: 0");
					$header='Transaction Date,Client Name,Vendor Name,Description,Billing Amount,Payable Amount,Payment Date,Payment status,Brokerage';
					print "$header\n$output";
					exit;
				}
				else if($_GET['action'] == "export_year_payment" && $_GET['for'] == "year")
				{
				$sql="";
				$sql = "SELECT * FROM payments WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and payment_date between  '2012-01-01' and '2012-12-31'";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
					{
						 $i++;
						 $sql="";
						$sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
						 $rs2= mysql_query($sql);
						 $row2=mysql_fetch_row($rs2);
						 $output .= $row2[2].','.$row['desc'].','.$row['amount'].','.$row['mode'].','.$row['payment_date']."\"\n";
					}
						header("Content-type:text/octect-stream");
						header("Content-Disposition:attachment;filename=data.csv");
						header("Pragma: no-cache");
						header("Expires: 0");
						$header='CLIENT NAME,DESCRIPTION,AMOUNT,MODE,PAYMENT DATE';
						print "$header\n$output";
						exit;
				}
				else if($_GET['action'] == "export_quarter_payment" && $_GET['for'] == "quarter")
				{
				$sql="";
				$sql = "SELECT * FROM payments WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and payment_date between  '2012-".mysql_real_escape_string($_GET['id'])."-01' and '2012-".mysql_real_escape_string($_GET['id']+'2')."-31'";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
					{
						 $i++;
						 $sql="";
						$sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
						 $rs2= mysql_query($sql);
						 $row2=mysql_fetch_row($rs2);
						 $output .= $row2[2].','.$row['desc'].','.$row['amount'].','.$row['mode'].','.$row['payment_date']."\"\n";
					}
						header("Content-type:text/octect-stream");
						header("Content-Disposition:attachment;filename=data.csv");
						header("Pragma: no-cache");
						header("Expires: 0");
						$header='CLIENT NAME,DESCRIPTION,AMOUNT,MODE,PAYMENT DATE';
						print "$header\n$output";
						exit;
				}
				else if($_GET['action'] == "export_month_payment" && $_GET['for'] == "month")
				{
				$sql="";
				$sql = "SELECT * FROM payments WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and payment_date between  '2012-".mysql_real_escape_string($_GET['id'])."-01' and '2012-".mysql_real_escape_string($_GET['id'])."-31'";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
					{
						 $i++;
						 $sql="";
						$sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
						 $rs2= mysql_query($sql);
						 $row2=mysql_fetch_row($rs2);
						 $output .= $row2[2].','.$row['desc'].','.$row['amount'].','.$row['mode'].','.$row['payment_date']."\"\n";
					}
						header("Content-type:text/octect-stream");
						header("Content-Disposition:attachment;filename=data.csv");
						header("Pragma: no-cache");
						header("Expires: 0");
						$header='CLIENT NAME,DESCRIPTION,AMOUNT,MODE,PAYMENT DATE';
						print "$header\n$output";
						exit;
				}
				else if($_GET['action'] == "export_payment")
				{
					$sql="";
					 $sql = "SELECT * FROM payments WHERE client_id = ".mysql_real_escape_string($_GET['id'])." and broker_id=".mysql_real_escape_string($_GET['broker_id'])."";
					 $rs = mysql_query($sql);
					 $i=0;
					while($row = mysql_fetch_array($rs))
					{
						 $i++;
						 $sql="";
						$sql = "SELECT * FROM `clients` WHERE `broker_id` = ".mysql_real_escape_string($_GET['broker_id'])." and `client_id` = '".$row['client_id']."'";
						 $rs2= mysql_query($sql);
						 $row2=mysql_fetch_row($rs2);
						 $output .= $row2[2].','.$row['desc'].','.$row['amount'].','.$row['mode'].','.$row['payment_date']."\"\n";
					}
						header("Content-type:text/octect-stream");
						header("Content-Disposition:attachment;filename=data.csv");
						header("Pragma: no-cache");
						header("Expires: 0");
						$header='CLIENT NAME,DESCRIPTION,AMOUNT,MODE,PAYMENT DATE';
						print "$header\n$output";
						exit;
				}
?>