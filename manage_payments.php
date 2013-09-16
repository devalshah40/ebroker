<?php
include"header.php";
include("left.php");

switch($_GET['action'])
{
	case 'edit':
			$edit_rec=mysql_fetch_array(mysql_query("SELECT * FROM payments WHERE payment_id = ".mysql_real_escape_string($_GET['id']).";"));
			$frm_action="update";
			break;
			
	case 'update':
			$sql="UPDATE `payments` SET 
			`client_id`= '".mysql_real_escape_string($_POST['CLIENT_ID'])."',
			`desc`= '".mysql_real_escape_string($_POST['DESCRIPTION'])."',
			`amount`= '".mysql_real_escape_string($_POST['AMOUNT'])."',
			`mode`= '".mysql_real_escape_string($_POST['MODE'])."',
			`payment_date`= '".mysql_real_escape_string($_POST['PAYMENT_DATE'])."' 
			WHERE `payment_id` = ".mysql_real_escape_string($_POST['payment_id']).";";
			mysql_query($sql);
			if(mysql_affected_rows() > 0)
			{
				$err_msg = "Payment Updated Successfully.";
			}
			$frm_action = "add";
			break;

	case 'delete':
			mysql_query("DELETE FROM payments WHERE payment_id = ".mysql_real_escape_string($_GET['id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg = "Payment Deleted Successfully.";
			}
			$frm_action = "add";
	    	break;
	
	case 'add':
				if (isset( $_POST['IMAGE_x']))
				{
					foreach ($_POST['details'] as $value) {
						mysql_query("DELETE FROM payments WHERE payment_id = ".$value."");
						if(mysql_affected_rows() > 0)
						{
							$err_msg = "Payment Deleted Successfully.";
						}
					}
					$frm_action = "add";
					break;
				}
				if(isset($_POST['SUBMIT']) && ($check_double_insert == ""))
				{
				echo "<pre>";
				//print_r($_POST);
				echo "</pre>";
				if($_POST['CLIENT_ID'] == "")
				{
					$msg2="Please Select Your Client Name";
				}
				else
				{
						$_SESSION['CLIENT_ID'] = $_POST['CLIENT_ID'];
				}
				if($_POST['DESCRIPTION'] == "")
				{
					$msg3="Please Enter Your Description";
				}
				else
				{
						$_SESSION['DESCRIPTION'] = $_POST['DESCRIPTION'];
				}
				if($_POST['AMOUNT'] == "")
				{
					$msg4="Please Enter Your Amount";
				}
				else
				{
						$_SESSION['AMOUNT'] = $_POST['AMOUNT'];
				}
				if($_POST['MODE'] == "")
				{
					$msg5="Please Select Mode";
				}
				else
				{
						$_SESSION['MODE'] = $_POST['MODE'];
				}
				if($_POST['PAYMENT_DATE'] == "")
				{
					$msg6="Please Enter Payment date";
				}
				else
				{
						$_SESSION['PAYMENT_DATE'] = $_POST['PAYMENT_DATE'];
				}
				if(($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == "")&& ($msg6 == ""))
				{
					$sql="";
					$sql = "INSERT INTO `payments` (`broker_id`, `client_id`, `desc`, `amount`, `mode`, `payment_date`) VALUES ('".mysql_real_escape_string($_SESSION['login_id'])."','".mysql_real_escape_string($_POST['CLIENT_ID'])."','".mysql_real_escape_string($_POST['DESCRIPTION'])."','".mysql_real_escape_string($_POST['AMOUNT'])."','".mysql_real_escape_string($_POST['MODE'])."','".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['PAYMENT_DATE']))))."');";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['CLIENT_ID']="";
						$_SESSION['DESCRIPTION']="";
						$_SESSION['AMOUNT']="";
						$_SESSION['MODE']="";
						$_SESSION['PAYMENT_DATE']="";
						$err_msg="Succesfully Inserted.";
					}
				}
				else
				{
					$error="Please Enter Correct Details.";
				}
			}
			else
			{
					$_SESSION['CLIENT_ID']="";
					$_SESSION['DESCRIPTION']="";
					$_SESSION['AMOUNT']="";
					$_SESSION['MODE']="";
					$_SESSION['PAYMENT_DATE']="";
			}
			$frm_action="add";
			break;
			
	case 'view':
			if(isset($_POST['SUBMIT']) && ($check_double_insert == ""))
				{
				echo "<pre>";
				//print_r($_POST);
				echo "</pre>";
				if($_POST['CLIENT_ID'] == "")
				{
					$msg2="Please Select Your Client Name";
				}
				else
				{
						$_SESSION['CLIENT_ID'] = $_POST['CLIENT_ID'];
				}
				if($_POST['DESCRIPTION'] == "")
				{
					$msg3="Please Enter Your Description";
				}
				else
				{
						$_SESSION['DESCRIPTION'] = $_POST['DESCRIPTION'];
				}
				if($_POST['AMOUNT'] == "")
				{
					$msg4="Please Enter Your Amount";
				}
				else
				{
						$_SESSION['AMOUNT'] = $_POST['AMOUNT'];
				}
				if($_POST['MODE'] == "")
				{
					$msg5="Please Select Mode";
				}
				else
				{
						$_SESSION['MODE'] = $_POST['MODE'];
				}
				if($_POST['PAYMENT_DATE'] == "")
				{
					$msg6="Please Enter Payment date";
				}
				else
				{
						$_SESSION['PAYMENT_DATE'] = $_POST['PAYMENT_DATE'];
				}
				if(($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == "")&& ($msg6 == ""))
				{
					$sql="";
					$sql = "INSERT INTO `payments` (`broker_id`, `client_id`, `desc`, `amount`, `mode`, `payment_date`) VALUES ('".mysql_real_escape_string($_SESSION['login_id'])."','".mysql_real_escape_string($_POST['CLIENT_ID'])."','".mysql_real_escape_string($_POST['DESCRIPTION'])."','".mysql_real_escape_string($_POST['AMOUNT'])."','".mysql_real_escape_string($_POST['MODE'])."','".date("Y-m-d",strtotime(str_replace('-', '/',mysql_real_escape_string($_POST['PAYMENT_DATE']))))."');";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['CLIENT_ID']="";
						$_SESSION['DESCRIPTION']="";
						$_SESSION['AMOUNT']="";
						$_SESSION['MODE']="";
						$_SESSION['PAYMENT_DATE']="";
						$err_msg="Succesfully Inserted.";
					}
				}
				else
				{
					$error="Please Enter Correct Details.";
				}
			}
			else
			{
					$_SESSION['CLIENT_ID']="";
					$_SESSION['DESCRIPTION']="";
					$_SESSION['AMOUNT']="";
					$_SESSION['MODE']="";
					$_SESSION['PAYMENT_DATE']="";
			}
			$frm_action="view";
			break;
	default:
			$_SESSION['CLIENT_ID']="";
			$_SESSION['DESCRIPTION']="";
			$_SESSION['AMOUNT']="";
			$_SESSION['MODE']="";
			$_SESSION['PAYMENT_DATE']="";	
			$frm_action="add";
			break;
}
	
?>
	<hr class="noscreen" />
		<form name="PAYMENTFORM" action="manage_payments.php?action=<?php echo $frm_action; ?>" id="paymentform" method="post">
			<input type="hidden" name="payment_id" value="<?php echo $edit_rec['payment_id'];?>" />
			<head>
				<script type="text/javascript" src="js/manage_payments.js"></script>
				<script src="js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
				 <link href="css/datepicker.css" rel="stylesheet" type="text/css" />
			</head>
		<!-- Content (Right Column) -->
		<div id="content" class="box">

			<?php if($_GET['action'] != "view") { ?>
			<!-- Table (TABLE) -->
			<h3 class="tit">Manage Payments</h3>
			<?php
				include("include/paginator.class.php");
				$query = "SELECT COUNT('broker_id') FROM payments";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_fetch_row($result);

				$pages = new Paginator;
				$pages->items_total = $num_rows[0];
				$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
				$pages->paginate();
				?>
			<table  width="85%">
				<tr>
				    <th width="5%"><input type='checkbox' onclick="checkAll()"></th>
				    <th width="18%">CLIENT NAME</th>
					<th width="20%">DESCRIPTION</th>
				    <th width="14%">AMOUNT</th>
				    <th width="8%">MODE</th>
				    <th width="14%">PAYMENT DATE</th>
				    <th width="10%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				$sql = "SELECT * FROM `payments` where broker_id=".$_SESSION['login_id']."$pages->limit";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					 $i++;
					 $sql="";
					 $sql = "SELECT * FROM `clients` WHERE `broker_id` = '".$_SESSION['login_id']."' and `client_id` = '".$row['client_id']."'";
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>
				    <td><input type="checkbox" name="details[]" value="<?php echo $row[0]; ?>"/></td>
				    <td><?php echo $row2[2] ?></td>
				    <td><?php echo $row['desc'] ?></td>
				    <td><?php echo number_format($row['amount']); ?></td>
				    <td><?php echo $row['mode'] ?></td>
				    <td><?php echo date($_SESSION['date_format'],strtotime($row['payment_date'])); ?></td>	
				    <td><a href="manage_payments.php?action=edit&id=<?php echo $row['payment_id']; ?>"><img src="img/edit.png" alt="edit"
						></a>&nbsp;&nbsp;&nbsp;<a href="manage_payments.php?action=delete&id=<?php echo $row['payment_id']; ?>"><img src="img/delete.png" alt="delete"></a></td>	
				</tr>
				<?php } ?>
				<tr>
					<td><input type="image" name="IMAGE" src="img/delete.png" alt="delete"></td>
					<td align="center" colspan="6">
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
			<?php } ?>

			<!-- Form -->
			<h3 class="tit">Add Payment</h3>
			
			<?php if($error != "" || $err != "" ) { ?>
			<p class="msg error"><?php echo $error; ?></p>
			<?php } ?>
			
			<?php if($err_msg != "" ) { ?>
			<p class="msg done"><?php echo $err_msg; ?></p>
			<?php } ?>
			
			<p class="msg info">Enter Your Payment Details.</p>
			
			<fieldset>
				<legend>Payment Information</legend>
				<table class="nostyle">
					<tr>
						<td style="width:100px;">Select Client:</td>
						<td>
								<select name="CLIENT_ID" id="client" style="width: 280px ;height: 25px;">
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
									else if($edit_rec['client_id'] == $row['client_id'])
									{
										echo "selected";
									}
									?>
									><?php 	echo $row['name']; } ?>							
									</option>
									</select>
							   <font color="red"><?php echo $msg2;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:70px;"  class="va-top">Description:</td>
						<td><textarea cols="43" rows="7" name="DESCRIPTION"  id="description" class="input-text"><?php  if($edit_rec['desc']!=""){ echo $edit_rec['desc']; } else {  echo $_SESSION['DESCRIPTION']; }?></textarea>
							<font color="red"><?php echo $msg3;?></font>
						</td>
					</tr>					
					<tr>
						<td style="width:70px;">Amount:</td>
						<td><input type="text" size="40" name="AMOUNT"  id="amount" class="input-text" value="<?php  if($edit_rec['amount']!=""){ echo $edit_rec['amount']; } else {  echo $_SESSION['AMOUNT']; } ?>" />
							   <font color="red"><?php echo $msg4;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Mode:</td>
						<td>
							<?php 
							$row=mysql_fetch_array(mysql_query("SELECT * FROM `payments` WHERE `payment_id`=".$edit_rec['payment_id'].";"));
							?>
							<script text="type/javascript">
							for (var i=0; i<document.PAYMENTFORM.MODE.length; i++)
									document.PAYMENTFORM.MODE[i].checked = false;
							</script>
							<input type="radio" name="MODE" id="mode" value="Cheque"> Cheque
							<input type="radio" name="MODE" id="mode" value="Cash">Cash
							
							<font color="red"><?php echo $msg5;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Payment Date:</td>
						<td>
							<input type="text" size="40"  id="paymentdate" readonly="readonly" name="PAYMENT_DATE" maxlength="12" class="input-text" value="<?php if($edit_rec['payment_date']!=""){ echo $edit_rec['payment_date']; } else { echo $_SESSION['PAYMENT_DATE']; } ?>" />
							<script>
									datePickerController.createDatePicker({ 
									/* Associate the text input to a DD/MM/YYYY date format %l, %d %F %Y   ,   %Y/%m/%d    
											date RegExp        = /%([d|j])/,
											month RegExp        = /%([M|F|m|n])/,
											year RegExp        = /%[y|Y]/,    
											formatSplitRegExp   = /%([D|l|N|w|S|W|t])/, %j-%F-%Y
									*/ 
									formElements:{"paymentdate":"%l, %d %F %Y"},
									statusFormat:"%l, %d%S %F %Y"
									}); 
							</script> 
							   <font color="red"><?php echo $msg6;?></font>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="t-left">
							<input type="submit" name="SUBMIT" id="SUBMIT" class="input-submit" value="Submit" onClick="return formValidator();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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