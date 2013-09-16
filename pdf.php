<?php
require('include/fpdf.php');
include("include/config.php");
			
class PDF extends FPDF
{
		function LoadData()
		{
						
							return $output;
						}
		function BasicTable($header)
		{
			// Header
		}
}
if($_GET['action'] == "export_transaction" && $_GET['for'] == "pdfclient")
{
			$pdf = new PDF();
			$header = array('Date','Client','Vendor','Description','Billing Amount','Payable Amount','Payment Date','Payment status','Brokerage');
			$data = $pdf->LoadData();
			$pdf->SetFont('Arial','B',10);
			$pdf->AddPage();			
			foreach($header as $col)
						$pdf->Cell(22,7,$col,1);
						$pdf->Ln();
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
								$pdf->Cell(22,6,$row['transaction_date'],1);
								$pdf->Cell(22,6,$row2[2],1);
								$pdf->Cell(22,6,$row3[2],1);
								$pdf->Cell(22,6,$row['description'],1);
								$pdf->Cell(22,6,$row['billing_amount'],1);
								$pdf->Cell(22,6,$row['payble_amount'],1);
								$pdf->Cell(22,6,$row['payment_date'],1);
								$pdf->Cell(22,6,$row['payment_status'],1);
								$pdf->Cell(22,6,$row['brokerage'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
else if($_GET['action'] == "export_transaction" && $_GET['for'] == "pdf_month_transaction")
				{
				$pdf = new PDF();
			$header = array('Date','Client','Vendor','Description','Billing Amount','Payable Amount','Payment Date','Payment status','Brokerage');
			$data = $pdf->LoadData();
			$pdf->SetFont('Arial','B',10);
			$pdf->AddPage();			
			foreach($header as $col)
						$pdf->Cell(22,7,$col,1);
						$pdf->Ln();
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
								$pdf->Cell(22,6,$row['transaction_date'],1);
								$pdf->Cell(22,6,$row2[2],1);
								$pdf->Cell(22,6,$row3[2],1);
								$pdf->Cell(22,6,$row['description'],1);
								$pdf->Cell(22,6,$row['billing_amount'],1);
								$pdf->Cell(22,6,$row['payble_amount'],1);
								$pdf->Cell(22,6,$row['payment_date'],1);
								$pdf->Cell(22,6,$row['payment_status'],1);
								$pdf->Cell(22,6,$row['brokerage'],1);
						$pdf->Ln();
				}
	$pdf->Output();
}
else if($_GET['action'] == "export_transaction" && $_GET['for'] == "pdf_vendor_transaction")
{
			$pdf = new PDF();
			$header = array('Date','Client','Vendor','Description','Billing Amount','Payable Amount','Payment Date','Payment status','Brokerage');
			$data = $pdf->LoadData();
			$pdf->SetFont('Arial','B',10);
			$pdf->AddPage();			
			foreach($header as $col)
						$pdf->Cell(22,7,$col,1);
						$pdf->Ln();
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
								$pdf->Cell(22,6,$row['transaction_date'],1);
								$pdf->Cell(22,6,$row2[2],1);
								$pdf->Cell(22,6,$row3[2],1);
								$pdf->Cell(22,6,$row['description'],1);
								$pdf->Cell(22,6,$row['billing_amount'],1);
								$pdf->Cell(22,6,$row['payble_amount'],1);
								$pdf->Cell(22,6,$row['payment_date'],1);
								$pdf->Cell(22,6,$row['payment_status'],1);
								$pdf->Cell(22,6,$row['brokerage'],1);
						$pdf->Ln();
						}
$pdf->Output();
}else if($_GET['action'] == "export_transaction" && $_GET['for'] == "pdf_quarter_transaction")
{
			$pdf = new PDF();
			$header = array('Date','Client','Vendor','Description','Billing Amount','Payable Amount','Payment Date','Payment status','Brokerage');
			$data = $pdf->LoadData();
			$pdf->SetFont('Arial','B',10);
			$pdf->AddPage();			
			foreach($header as $col)
						$pdf->Cell(22,7,$col,1);
						$pdf->Ln();
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
								$pdf->Cell(22,6,$row['transaction_date'],1);
								$pdf->Cell(22,6,$row2[2],1);
								$pdf->Cell(22,6,$row3[2],1);
								$pdf->Cell(22,6,$row['description'],1);
								$pdf->Cell(22,6,$row['billing_amount'],1);
								$pdf->Cell(22,6,$row['payble_amount'],1);
								$pdf->Cell(22,6,$row['payment_date'],1);
								$pdf->Cell(22,6,$row['payment_status'],1);
								$pdf->Cell(22,6,$row['brokerage'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
else if($_GET['action'] == "export_transaction" && $_GET['for'] == "pdf_year_transaction")
{
			$pdf = new PDF();
			$header = array('Date','Client','Vendor','Description','Billing Amount','Payable Amount','Payment Date','Payment status','Brokerage');
			$data = $pdf->LoadData();
			$pdf->SetFont('Arial','B',10);
			$pdf->AddPage();			
			foreach($header as $col)
						$pdf->Cell(22,7,$col,1);
						$pdf->Ln();
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
								$pdf->Cell(22,6,$row['transaction_date'],1);
								$pdf->Cell(22,6,$row2[2],1);
								$pdf->Cell(22,6,$row3[2],1);
								$pdf->Cell(22,6,$row['description'],1);
								$pdf->Cell(22,6,$row['billing_amount'],1);
								$pdf->Cell(22,6,$row['payble_amount'],1);
								$pdf->Cell(22,6,$row['payment_date'],1);
								$pdf->Cell(22,6,$row['payment_status'],1);
								$pdf->Cell(22,6,$row['brokerage'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
else if($_GET['action'] == "export_payment" && $_GET['for'] == "pdf_client_payment")
{
$pdf = new PDF();
$header = array('CLIENT NAME','DESCRIPTION','AMOUNT','MODE','PAYMENT DATE');
$data = $pdf->LoadData();
$pdf->SetFont('Arial','B',10);
$pdf->AddPage();			
foreach($header as $col)
				$pdf->Cell(40,7,$col,1);
			$pdf->Ln();
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
								$pdf->Cell(40,6,$row2[2],1);
								$pdf->Cell(40,6,$row['desc'],1);
								$pdf->Cell(40,6,$row['amount'],1);
								$pdf->Cell(40,6,$row['mode'],1);
								$pdf->Cell(40,6,$row['payment_date'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
else if($_GET['action'] == "export_payment" && $_GET['for'] == "pdf_month_payment")
{
$pdf = new PDF();
$header = array('CLIENT NAME','DESCRIPTION','AMOUNT','MODE','PAYMENT DATE');
$data = $pdf->LoadData();
$pdf->SetFont('Arial','B',10);
$pdf->AddPage();			
foreach($header as $col)
				$pdf->Cell(40,7,$col,1);
			$pdf->Ln();
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
								$pdf->Cell(40,6,$row2[2],1);
								$pdf->Cell(40,6,$row['desc'],1);
								$pdf->Cell(40,6,$row['amount'],1);
								$pdf->Cell(40,6,$row['mode'],1);
								$pdf->Cell(40,6,$row['payment_date'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
else if($_GET['action'] == "export_payment" && $_GET['for'] == "pdf_year_payment")
{
$pdf = new PDF();
$header = array('CLIENT NAME','DESCRIPTION','AMOUNT','MODE','PAYMENT DATE');
$data = $pdf->LoadData();
$pdf->SetFont('Arial','B',10);
$pdf->AddPage();			
foreach($header as $col)
				$pdf->Cell(40,7,$col,1);
			$pdf->Ln();
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
								$pdf->Cell(40,6,$row2[2],1);
								$pdf->Cell(40,6,$row['desc'],1);
								$pdf->Cell(40,6,$row['amount'],1);
								$pdf->Cell(40,6,$row['mode'],1);
								$pdf->Cell(40,6,$row['payment_date'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
else if($_GET['action'] == "export_payment" && $_GET['for'] == "pdf_quarter_payment")
{
$pdf = new PDF();
$header = array('CLIENT NAME','DESCRIPTION','AMOUNT','MODE','PAYMENT DATE');
$data = $pdf->LoadData();
$pdf->SetFont('Arial','B',10);
$pdf->AddPage();			
foreach($header as $col)
				$pdf->Cell(40,7,$col,1);
			$pdf->Ln();
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
								$pdf->Cell(40,6,$row2[2],1);
								$pdf->Cell(40,6,$row['desc'],1);
								$pdf->Cell(40,6,$row['amount'],1);
								$pdf->Cell(40,6,$row['mode'],1);
								$pdf->Cell(40,6,$row['payment_date'],1);
						$pdf->Ln();
						}
$pdf->Output();
}
?>