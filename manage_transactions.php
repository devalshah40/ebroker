<?php
include"header.php";
include("left.php");

switch($_GET['action'])
{
	case 'edit':
			$edit_rec=mysql_fetch_array(mysql_query("SELECT * FROM transactions WHERE transaction_id = ".mysql_real_escape_string($_GET['id']).";"));
			$frm_action="update";
			break;
			
	case 'update':
			$sql="UPDATE `transactions` SET 
			`transaction_date`= '".mysql_real_escape_string($_POST['TRANSACTION_DATE'])."',
			`client_id`= '".mysql_real_escape_string($_POST['CLIENT_ID'])."',
			`vendor_id`= '".mysql_real_escape_string($_POST['VENDOR_ID'])."',
			`description`= '".mysql_real_escape_string($_POST['DESCRIPTION'])."',
			`billing_amount`= '".mysql_real_escape_string($_POST['BILLING_AMOUNT'])."',
			`payble_amount`= '".mysql_real_escape_string($_POST['PAYABLE_AMOUNT'])."',
			`payment_date`= '".mysql_real_escape_string($_POST['PAYABLE_DATE'])."',
			`payment_status`= '".mysql_real_escape_string($_POST['PAYABLE_STATUS'])."'
			WHERE `transaction_id` = ".mysql_real_escape_string($_POST['transaction_id']).";";
			mysql_query($sql);
			if(mysql_affected_rows() > 0)
			{
				$err_msg = "Transaction Updated Successfully.";
			}
			$frm_action = "add";
			break;

	case 'delete':
			mysql_query("DELETE FROM `transactions` WHERE transaction_id = ".mysql_real_escape_string($_GET['id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg = "Transaction Deleted Successfully.";
			}
			$frm_action = "add";
	    	break;
	case 'add':
			if (isset( $_POST['IMAGE_x']))
			{
					foreach ($_POST['details'] as $value) {
						mysql_query("DELETE FROM `transactions` WHERE transaction_id = ".$value."");
						if(mysql_affected_rows() > 0)
						{
							$err_msg = "Transaction Deleted Successfully.";
						}
					}
					$frm_action = "add";
					break;
			}
			if(isset($_POST['generate']))
			{
					if($_POST['day1'] == "")
					{
						$msg10="Please Select Your Transaction day1";
					}
					else
					{
							$_SESSION['day1'] = $_POST['day1'];
					}
					if($_POST['day2'] == "")
					{
						$msg11="Please Select Your Transaction day2";
					}
					else
					{
							$_SESSION['day2'] = $_POST['day2'];
					}
					if(($msg10 == "") && ($msg11 == ""))
					{
						$generate_summary="SET FIELD";
					}
			}
			else
			{
						$_SESSION['day1']="";
						$_SESSION['day2']="";
						$generate_summary="";
			}
			if(isset($_POST['SUBMIT']) && ($err_msg == ""))
			{
					if($_POST['TRANSACTION_DATE'] == "")
					{
						$msg2="Please Select Your Transaction date";
					}
					else
					{
							$_SESSION['TRANSACTION_DATE'] = $_POST['TRANSACTION_DATE'];
					}
					if($_POST['CLIENT_ID'] == "")
					{
						$msg3="Please Select Your Client Name";
					}
					else
					{
							$_SESSION['CLIENT_ID'] = $_POST['CLIENT_ID'];
					}
					if($_POST['VENDOR_ID'] == "")
					{
						$msg4="Please Select Your Vendor Name";
					}
					else
					{
							$_SESSION['VENDOR_ID'] = $_POST['VENDOR_ID'];
					}
					if($_POST['DESCRIPTION'] == "")
					{
						$msg5="Please Select Your Description";
					}
					else
					{
							$_SESSION['DESCRIPTION'] = $_POST['DESCRIPTION'];
					}
					if($_POST['BILLING_AMOUNT'] == "")
					{
						$msg6="Please Select Your Billing Amount";
					}
					else
					{
							$_SESSION['BILLING_AMOUNT'] = $_POST['BILLING_AMOUNT'];
					}
					if($_POST['PAYABLE_AMOUNT'] == "")
					{
						$msg7="Please Select Your Payable Amount";
					}
					else
					{
							$_SESSION['PAYABLE_AMOUNT'] = $_POST['PAYABLE_AMOUNT'];
					}
					if($_POST['PAYABLE_DATE'] == "")
					{
						$msg8="Please Select Your Payable Date";
					}
					else
					{
							$_SESSION['PAYABLE_DATE'] = $_POST['PAYABLE_DATE'];
					}
					if($_POST['PAYABLE_STATUS'] == "")
					{
						$msg9="Please Select Your Payment Status";
					}
					else
					{
							$_SESSION['PAYABLE_STATUS'] = $_POST['PAYABLE_STATUS'];
					}
					if(($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == "")&& ($msg6 == "")&& ($msg7 == "")&& ($msg8 == "")&& ($msg9 == ""))
					{
						$row4=mysql_fetch_row(mysql_query("SELECT brokerage FROM `clients` WHERE `client_id` = '".mysql_real_escape_string($_POST['CLIENT_ID'])."';"));
						$brokerage=floor(($row4[0]* mysql_real_escape_string($_POST['PAYABLE_AMOUNT'])/100));
						$sql="";
						$sql = "INSERT INTO `transactions` (`broker_id`, `transaction_date`, `client_id`, `vendor_id`, `description`, `billing_amount`, `payble_amount`, `payment_date`, `payment_status`,`brokerage`) VALUES ('".mysql_real_escape_string($_SESSION['login_id'])."','".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['TRANSACTION_DATE']))))."','".mysql_real_escape_string($_POST['CLIENT_ID'])."','".mysql_real_escape_string($_POST['VENDOR_ID'])."','".mysql_real_escape_string($_POST['DESCRIPTION'])."','".mysql_real_escape_string($_POST['BILLING_AMOUNT'])."','".mysql_real_escape_string($_POST['PAYABLE_AMOUNT'])."','".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['PAYABLE_DATE']))))."','".mysql_real_escape_string($_POST['PAYABLE_STATUS'])."','".$brokerage."');";
						if(!mysql_query($sql))
						{
							$err = "yes";
						}
						else
						{
							$_SESSION['TRANSACTION_DATE']="";
							$_SESSION['CLIENT_ID']="";
							$_SESSION['VENDOR_ID']="";
							$_SESSION['DESCRIPTION']="";
							$_SESSION['BILLING_AMOUNT']="";
							$_SESSION['PAYABLE_AMOUNT']="";
							$_SESSION['PAYABLE_DATE']="";
							$_SESSION['PAYABLE_STATUS']="";
							$err_msg="Succesfully Inserted";
						}
					}
					else
					{
						$error="Please Enter Correct Details";
					}
			}
			else
			{
						$_SESSION['TRANSACTION_DATE']="";
						$_SESSION['CLIENT_ID']="";
						$_SESSION['VENDOR_ID']="";
						$_SESSION['DESCRIPTION']="";
						$_SESSION['BILLING_AMOUNT']="";
						$_SESSION['PAYABLE_AMOUNT']="";
						$_SESSION['PAYABLE_DATE']="";
						$_SESSION['PAYABLE_STATUS']="";
			}
			$frm_action="add";
			break;
			
	case 'view':
			
			if(isset($_POST['SUBMIT']) && ($err_msg == ""))
			{
					if($_POST['TRANSACTION_DATE'] == "")
					{
						$msg2="Please Select Your Transaction date";
					}
					else
					{
							$_SESSION['TRANSACTION_DATE'] = $_POST['TRANSACTION_DATE'];
					}
					if($_POST['CLIENT_ID'] == "")
					{
						$msg3="Please Select Your Client Name";
					}
					else
					{
							$_SESSION['CLIENT_ID'] = $_POST['CLIENT_ID'];
					}
					if($_POST['VENDOR_ID'] == "")
					{
						$msg4="Please Select Your Vendor Name";
					}
					else
					{
							$_SESSION['VENDOR_ID'] = $_POST['VENDOR_ID'];
					}
					if($_POST['DESCRIPTION'] == "")
					{
						$msg5="Please Select Your Description";
					}
					else
					{
							$_SESSION['DESCRIPTION'] = $_POST['DESCRIPTION'];
					}
					if($_POST['BILLING_AMOUNT'] == "")
					{
						$msg6="Please Select Your Billing Amount";
					}
					else
					{
							$_SESSION['BILLING_AMOUNT'] = $_POST['BILLING_AMOUNT'];
					}
					if($_POST['PAYABLE_AMOUNT'] == "")
					{
						$msg7="Please Select Your Payable Amount";
					}
					else
					{
							$_SESSION['PAYABLE_AMOUNT'] = $_POST['PAYABLE_AMOUNT'];
					}
					if($_POST['PAYABLE_DATE'] == "")
					{
						$msg8="Please Select Your Payable Date";
					}
					else
					{
							$_SESSION['PAYABLE_DATE'] = $_POST['PAYABLE_DATE'];
					}
					if($_POST['PAYABLE_STATUS'] == "")
					{
						$msg9="Please Select Your Payment Status";
					}
					else
					{
							$_SESSION['PAYABLE_STATUS'] = $_POST['PAYABLE_STATUS'];
					}
					if(($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == "")&& ($msg6 == "")&& ($msg7 == "")&& ($msg8 == "")&& ($msg9 == ""))
					{
						$row4=mysql_fetch_row(mysql_query("SELECT brokerage FROM `clients` WHERE `client_id` = '".mysql_real_escape_string($_POST['CLIENT_ID'])."';"));
						$brokerage=floor(($row4[0]* mysql_real_escape_string($_POST['PAYABLE_AMOUNT'])/100));
						$sql="";
						$sql = "INSERT INTO `transactions` (`broker_id`, `transaction_date`, `client_id`, `vendor_id`, `description`, `billing_amount`, `payble_amount`, `payment_date`, `payment_status`,`brokerage`) VALUES ('".mysql_real_escape_string($_SESSION['login_id'])."','".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['TRANSACTION_DATE']))))."','".mysql_real_escape_string($_POST['CLIENT_ID'])."','".mysql_real_escape_string($_POST['VENDOR_ID'])."','".mysql_real_escape_string($_POST['DESCRIPTION'])."','".mysql_real_escape_string($_POST['BILLING_AMOUNT'])."','".mysql_real_escape_string($_POST['PAYABLE_AMOUNT'])."','".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['PAYABLE_DATE']))))."','".mysql_real_escape_string($_POST['PAYABLE_STATUS'])."','".$brokerage."');";
						if(!mysql_query($sql))
						{
							$err = "yes";
						}
						else
						{
							$_SESSION['TRANSACTION_DATE']="";
							$_SESSION['CLIENT_ID']="";
							$_SESSION['VENDOR_ID']="";
							$_SESSION['DESCRIPTION']="";
							$_SESSION['BILLING_AMOUNT']="";
							$_SESSION['PAYABLE_AMOUNT']="";
							$_SESSION['PAYABLE_DATE']="";
							$_SESSION['PAYABLE_STATUS']="";
							$err_msg="Succesfully Inserted";
						}
					}
					else
					{
						$error="Please Enter Correct Details";
					}
			}
			else
			{
						$_SESSION['TRANSACTION_DATE']="";
						$_SESSION['CLIENT_ID']="";
						$_SESSION['VENDOR_ID']="";
						$_SESSION['DESCRIPTION']="";
						$_SESSION['BILLING_AMOUNT']="";
						$_SESSION['PAYABLE_AMOUNT']="";
						$_SESSION['PAYABLE_DATE']="";
						$_SESSION['PAYABLE_STATUS']="";
			}
			$frm_action="view";
			break;
	default:
				$_SESSION['TRANSACTION_DATE']="";
				$_SESSION['CLIENT_ID']="";
				$_SESSION['VENDOR_ID']="";
				$_SESSION['DESCRIPTION']="";
				$_SESSION['BILLING_AMOUNT']="";
				$_SESSION['PAYABLE_AMOUNT']="";
				$_SESSION['PAYABLE_DATE']="";
				$_SESSION['PAYABLE_STATUS']="";
				$_SESSION['day1']="";
				$_SESSION['day2']="";
			$frm_action="add";
			break;
}
	
	
?>
	<hr class="noscreen" />
		<form name="TRANSCATIONFORM3" action="manage_transactions.php?action=<?php echo $frm_action;?>" id="transactionform3" method="post" >
				<head>
					<script type="text/javascript" src="js/manage_transactions.js"></script>
				</head>
		<!-- Content (Right Column) -->
		<div id="content" class="box">
			<?php if($_GET['action'] != "view") { ?>
			<!-- Table (TABLE) -->
			<h3 class="tit">Manage Transactions</h3>
			<?php
				include("include/paginator.class.php");
				$query = "SELECT COUNT('broker_id') FROM transactions";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_fetch_row($result);

				$pages = new Paginator;
				$pages->items_total = $num_rows[0];
				$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
				$pages->paginate();
				?>
			<table width="100%">
				<tr>
				    <th width="5%"><input type='checkbox' onclick="checkAll()"></th>
				    <th width="8%">TRANSACTION DATE</th>
				    <th width="10%">CLIENT NAME</th>
				    <th width="10%">VENDOR NAME</th>
					<th width="20%">DESCRIPTION</th>
				    <th width="9%">BILLING AMOUNT</th>
				    <th width="9%">PAYABLE AMOUNT</th>
				    <th width="9%">PAYMENT DATE</th>
				    <th width="5%">PAYMENT STATUS</th>
				    <th width="5%">BROKERAGE</th>
				    <th width="10%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `transactions` where broker_id=".$_SESSION['login_id']."$pages->limit";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
                     $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = '".$_SESSION['login_id']."' and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
					 $sql="";
					 $sql = "SELECT * FROM `vendors` WHERE `broker_id` = '".$_SESSION['login_id']."' and `vendor_id` = '".$row['vendor_id']."'";
					 $rs3= mysql_query($sql);
					 $row3=mysql_fetch_row($rs3);
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>
				    <td><input type="checkbox" name="details[]" value="<?php echo $row[0]; ?>"/></td>
				    <td><?php echo date($_SESSION['date_format'],strtotime($row['transaction_date'])); ?></td>
				    <td><?php echo $row2[2]; ?></td>
				    <td><?php echo $row3[2];?></td>	
				    <td><?php echo $row['description']; ?></td>
				    <td><?php echo number_format($row['billing_amount']); ?></td>
				    <td><?php echo number_format($row['payble_amount']); ?></td>
				    <td><?php echo date($_SESSION['date_format'],strtotime($row['payment_date'])); ?></td>	
				    <td><?php echo $row['payment_status']; ?></td>
				    <td><?php echo number_format($row['brokerage']); ?></td>
				    <td><a href="manage_transactions.php?action=edit&id=<?php echo $row['transaction_id']; ?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;<a href="manage_transactions.php?action=delete&id=<?php echo $row['transaction_id']; ?>"><img src="img/delete.png" alt="delete"></a></td>	
				</tr>
				<?php } ?>
				<tr>
					<td><input type="image" name="IMAGE" src="img/delete.png" alt="delete"></td>
					<td align="center" colspan="10">
					<span class="">			
						<?php echo $pages->display_jump_menu(); ?>&nbsp;&nbsp;&nbsp;
						<?php	
							echo $pages->display_items_per_page(); //Optional – displays the items per page menu
						?>
					</span>&nbsp;&nbsp;&nbsp;
					<span class="">			
						<label>Pages :</label></span>
							<?php
								echo $pages->display_pages();
							?>
					</td>		
				</tr>
			</table>
			</form>
			<form name="TRANSCATIONFORM1" action="manage_transactions.php?action=<?php echo $frm_action;?>" id="transactionform1" method="post" >
				<head>
					<script type="text/javascript" src="js/manage_transactions.js"></script>
					<script src="js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
				   <link href="css/datepicker.css" rel="stylesheet" type="text/css" />
				</head>
				<body>
				<h3 class="tit">Summary</h3>
				<table class="nostyle">
						<tr>
							<td style="width:110px;">Day1:</td>
							<td><input type="text" size="40" name="day1" id="day1" class="input-text" value="<?php echo $_SESSION['day1']; ?>" /> 
								<script>
									datePickerController.createDatePicker({ 
									/* Associate the text input to a DD/MM/YYYY date format %l, %d %F %Y   ,   %Y/%m/%d    
											date RegExp        = /%([d|j])/,
											month RegExp        = /%([M|F|m|n])/,
											year RegExp        = /%[y|Y]/,    
											formatSplitRegExp   = /%([D|l|N|w|S|W|t])/, %j-%F-%Y
									*/ 
									formElements:{"day1":"%l, %d %F %Y"},
									statusFormat:"%l, %d%S %F %Y"
									}); 
							</script> 
							   <font color="red"><?php echo $msg10;?></font></td>
						</tr>
						<tr>
							<td style="width:110px;">Day2:</td>
							<td><input type="text" size="40" name="day2" id="day2" class="input-text" value="<?php echo $_SESSION['day2']; ?>" />
							<script>
									datePickerController.createDatePicker({ 
									/* Associate the text input to a DD/MM/YYYY date format %l, %d %F %Y   ,   %Y/%m/%d    
											date RegExp        = /%([d|j])/,
											month RegExp        = /%([M|F|m|n])/,
											year RegExp        = /%[y|Y]/,    
											formatSplitRegExp   = /%([D|l|N|w|S|W|t])/, %j-%F-%Y
									*/ 
									formElements:{"day2":"%l, %d %F %Y"},
									statusFormat:"%l, %d%S %F %Y"
									}); 
							</script> 
							   <font color="red"><?php echo $msg11;?></font></td>
						</tr>
						<tr>
							<td style="width:110px;">Generate:</td>
							<td>
								<input type="submit" id="generate" class="input-submit" onclick="return formValidator1();"  name="generate" value="Generate"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" name="CANCEL" id="CANCEL" class="input-submit" value="Cancel">
							</td>
						</tr>
				</table>
				<?php
					if($generate_summary != "")
					{
					?>
					<h3 class="tit">Summary Between <?php echo $_POST['day1']; ?> and <?php echo $_POST['day2']; ?></h3>			
						<table class="nostyle">
								<tr>
									<td style="width:150px;">Transaction Amount :</td>
									<td>
										<label>
										<?php 
											$sql="";
											$rs1 = mysql_query("SELECT * FROM `transactions` where `transaction_date` between '".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['day1']))))."' AND '".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['day2']))))."';");
											while($row1 = mysql_fetch_array($rs1))
											{
												$sum += $row1[6];
												$payable_amount += $row1[7];
												$brokerage += $row1[10];
											}
											echo number_format($sum);
										?></label>
									</td>
								</tr>
								<tr>
									<td>Payable Amount :</td>
									<td>
										<label>
										<?php 
											echo number_format($payable_amount);
										?></label>
								</tr>
								<tr>
									<td>Total Brokerage :</td>
									<td>
									<label>
										<?php 
											echo number_format($brokerage);
										?>
									</label>
									</td>
								</tr>
						</table>
					<?php	}	?>
				</body>
			</form>
			<?php } ?>
			
			<form name="TRANSCATIONFORM" action="manage_transactions.php?action=<?php echo $frm_action;?>" id="transactionform" method="post" >
			<input type="hidden" name="transaction_id" value="<?php echo $edit_rec['transaction_id'];?>" />
			<head>
				<script type="text/javascript" src="js/manage_transactions.js"></script>
				<script src="js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
				   <link href="css/datepicker.css" rel="stylesheet" type="text/css" />
				    
			</head>
			<h3 class="tit">Add Transaction</h3>
			
			<?php if($error != "" || $err != "" ) { ?>
			<p class="msg error"><?php echo $error; ?></p>
			<?php } ?>
			
			<?php if($err_msg != "" ) { ?>
			<p class="msg done"><?php echo $err_msg; ?></p>
			<?php } ?>
			<p class="msg info">Enter Your Transaction Details.</p>
		
			
			<fieldset>
				<legend>Transaction Information</legend>
				<table class="nostyle">
					<tr>
						<td style="width:110px;">Transaction Date:</td>
						<td>
								<input type="text" size="40" id="transaction_date" name="TRANSACTION_DATE" readonly="readonly" class="input-text" value="<?php if($edit_rec['transaction_date']!=""){ echo $edit_rec['transaction_date']; } else { echo $_SESSION['TRANSACTION_DATE']; } ?>" /> 
								<script>
									datePickerController.createDatePicker({ 
									/* Associate the text input to a DD/MM/YYYY date format %l, %d %F %Y   ,   %Y/%m/%d    
											date RegExp        = /%([d|j])/,
											month RegExp        = /%([M|F|m|n])/,
											year RegExp        = /%[y|Y]/,    
											formatSplitRegExp   = /%([D|l|N|w|S|W|t])/, %j-%F-%Y
									*/ 
									formElements:{"transaction_date":"%l, %d %F %Y"},
									statusFormat:"%l, %d%S %F %Y"
									}); 
							</script> 
							   <font color="red"><?php echo $msg2;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:90px;">Select Client:</td>
						<td>
								<select name="CLIENT_ID" id="client" style="width: 280px;height: 25px;">
									<option value="">Select Client</option>
									<?php
									$sql="";
									$sql = "SELECT * FROM `clients` WHERE `broker_id` = '".$_SESSION['login_id']."'";
									$rs=mysql_query($sql);
									 while($row = mysql_fetch_array($rs))
									 {
									?>
									<option value="<?php echo $row['client_id']; ?>"
									<?php
									if($error != "" && $_SESSION['CLIENT_ID'] == $row['client_id'])
									{
										echo "selected";
									}
									else if($row['client_id'] == $edit_rec['client_id'])
									{
										echo "selected";
									}
									?>
									><?php 	echo $row['name']; } ?>							
									</option>
									</select>
							   <font color="red"><?php echo $msg3;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:90px;">Select Vendor:</td>
						<td>
								<select name="VENDOR_ID" id="vendor" style="width: 280px;height: 25px;">
									<option value="">Select Vendor</option>
									<?php
									$sql="";
									$sql = "SELECT * FROM `vendors` WHERE `broker_id` = '".$_SESSION['login_id']."'";
									$rs=mysql_query($sql);
									 while($row = mysql_fetch_array($rs))
									 {
									?>
									<option value="<?php echo $row['vendor_id']; ?>"
									<?php
									if($error != "" && $_SESSION['VENDOR_ID'] == $row['vendor_id'])
									{
										echo "selected";
									}
									else if($row['vendor_id'] == $edit_rec['vendor_id'])
									{
										echo "selected";
									}									?>
									><?php 	echo $row['name']; } ?>							
									</option>
									</select>
							   <font color="red"><?php echo $msg4;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:90px;" class="va-top">Description:</td>
						<td><textarea cols="43" rows="7" name="DESCRIPTION" id="description" class="input-text"><?php if($edit_rec['description']!=""){ echo $edit_rec['description']; } else { echo $_SESSION['DESCRIPTION']; } ?></textarea>
							<font color="red" class="va-top"><?php echo $msg5;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:90px;">Billing Amount:</td>
						<td><input type="text" size="40" name="BILLING_AMOUNT" id="billingamount" class="input-text" value="<?php if($edit_rec['billing_amount']!=""){ echo $edit_rec['billing_amount']; } else { echo $_SESSION['BILLING_AMOUNT']; } ?>" />
							   <font color="red"><?php echo $msg6;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:90px;">Payable Amount:</td>
						<td><input type="text" size="40" name="PAYABLE_AMOUNT" id="payableamount" class="input-text" value="<?php if($edit_rec['payble_amount']!=""){ echo $edit_rec['payble_amount']; } else { echo $_SESSION['PAYABLE_AMOUNT']; } ?>" />
							   <font color="red"><?php echo $msg7;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Payment Date:</td>
						<td><input type="text" size="40" name="PAYABLE_DATE" readonly="readonly" id="payabledate" maxlength="12" class="input-text" value="<?php if($edit_rec['payment_date']!=""){ echo $edit_rec['payment_date']; } else { echo $_SESSION['PAYABLE_DATE']; } ?>" />
							<script>
									datePickerController.createDatePicker({ 
									/* Associate the text input to a DD/MM/YYYY date format %l, %d %F %Y   ,   %Y/%m/%d    
											date RegExp        = /%([d|j])/,
											month RegExp        = /%([M|F|m|n])/,
											year RegExp        = /%[y|Y]/,    
											formatSplitRegExp   = /%([D|l|N|w|S|W|t])/, %j-%F-%Y
									*/ 
									formElements:{"payabledate":"%l, %d %F %Y"},
									statusFormat:"%l, %d%S %F %Y"
									}); 
							</script> 
							   <font color="red"><?php echo $msg8;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Payment Status:</td>
						<td>
							<input type="radio" name="PAYABLE_STATUS" id="payablestatus" value="Done"> Done
							<input type="radio" name="PAYABLE_STATUS" id="payablestatus" value="Pending">Pending
							<font color="red"><?php echo $msg9;?></font>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="t-left">
							<input type="submit" name="SUBMIT" id="SUBMIT" class="input-submit" value="Submit" onClick="return formValidator();" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" name="CANCEL" id="CANCEL" class="input-submit" value="Cancel">
						</td>
					</tr>
				</table>
			</fieldset>
		</div> <!-- /content -->
		</form>
	</div> <!-- /cols -->
<?php
include "footer.php"; 
?>