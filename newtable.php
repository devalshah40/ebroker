<?php
			require ("include/config.php");
		if($_GET['action'] == "export_transaction" && $_GET['for'] == "pdf_vendor_transaction")
		{
			
					 
			$str ='<table width="100%" border="1">
				<tr>
				    <th >TRANSACTION DATE</th>
				    <th >CLIENT NAME</th>
				    <th >VENDOR NAME</th>
					<th >DESCRIPTION</th>
				    <th >BILLING AMOUNT</th>
				    <th >PAYABLE AMOUNT</th>
				    <th >PAYMENT DATE</th>
				    <th>PAYMENT STATUS</th>
				    <th>BROKERAGE</th>
				</tr>';
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
		
			$str .='<tr>
				    <td>'.$row['transaction_date'].'</td>
				    <td>'.$row2[2].'</td>
				    <td>'.$row3[2].'</td>	
				    <td>'.$row['description'].'</td>
				    <td>'.number_format($row['billing_amount']).'</td>
				    <td>'.number_format($row['payble_amount']).'</td>
				    <td>'.$row['payment_date'].'</td>	
				    <td>'.$row['payment_status'].'</td>
				    <td>'.number_format($row['brokerage']).'</td>
				</tr>';
				} 
			$str .='</table>';
		} 
