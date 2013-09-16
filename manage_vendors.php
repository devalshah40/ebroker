<?php
include"header.php";
include("left.php");

switch($_GET['action'])
{
	case 'edit':
			$edit_rec=mysql_fetch_array(mysql_query("SELECT * FROM vendors WHERE vendor_id = ".mysql_real_escape_string($_GET['id']).""));
			$frm_action="update";
			break;

	case 'update':
			mysql_query("UPDATE vendors SET 
			name= '".mysql_real_escape_string($_POST['NAME'])."',
			address= '".mysql_real_escape_string($_POST['ADDRESS'])."',
			contact_no= '".mysql_real_escape_string($_POST['CONTACT_NO'])."',
			year= '".mysql_real_escape_string($_POST['YEAR'])."'
			WHERE vendor_id = ".mysql_real_escape_string($_POST['vendor_id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg ="";
				$err_msg = "Vendor Updated Successfully.";
			}
			$frm_action = "add";
			break;

	case 'delete':
			mysql_query("DELETE FROM transactions WHERE vendor_id = ".mysql_real_escape_string($_GET['id'])."");
			mysql_query("DELETE FROM vendors WHERE vendor_id = ".mysql_real_escape_string($_GET['id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg ="";
				$err_msg = "Vendor Deleted Successfully.";
			}
			$frm_action = "add";
	    	break;
	case 'add':
				if (isset( $_POST['IMAGE_x']))
				{
					foreach ($_POST['details'] as $value) {
						mysql_query("DELETE FROM transactions WHERE vendor_id = ".$value."");
						mysql_query("DELETE FROM vendors WHERE vendor_id = ".$value."");
						if(mysql_affected_rows() > 0)
						{
							$err_msg ="";
							$err_msg = "Vendor Deleted Successfully.";
						}
					}
					$frm_action = "add";
					break;
				}
		if(isset($_POST['SUBMIT']) && ($err_msg == ""))
		{	
				if($_POST['NAME'] == "")
				{
					$msg="Please Enter Your Name";
				}
				else
				{
						$_SESSION['NAME'] = $_POST['NAME'];
				}
				if($_POST['CONTACT_NO'] == "")
				{
					$msg1="Please Enter Your Contact Number";
				}
				else
				{
						$_SESSION['CONTACT_NO'] = $_POST['CONTACT_NO'];
				}
				if($_POST['ADDRESS'] == "")
				{
					$msg2="Please Enter Address";
				}
				else
				{
						$_SESSION['ADDRESS'] = $_POST['ADDRESS'];
				}
				if($_POST['YEAR'] == "")
				{
					$msg3="Please Enter Year";
				}
				else
				{
						$_SESSION['YEAR'] = $_POST['YEAR'];
				}
				if(($msg == "") && ($msg1 == "") && ($msg2 == "") && ($msg3 == ""))
				{
					$sql="";
					$sql = "INSERT INTO `vendors` (`broker_id`, `name`, `contact_no`, `address`, `year`) VALUES('".mysql_real_escape_string($_SESSION['login_id'])."','".ucwords(strtolower(mysql_real_escape_string($_POST['NAME'])))."','".mysql_real_escape_string($_POST['CONTACT_NO'])."','".mysql_real_escape_string($_POST['ADDRESS'])."','".mysql_real_escape_string($_POST['YEAR'])."');";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['NAME']="";
						$_SESSION['CONTACT_NO']="";
						$_SESSION['ADDRESS']="";
						$_SESSION['YEAR']="";
						$err_msg="Succesfully Inserted.";
						$to      = $_SESSION['email_id'];
						$subject = "New Vendor Added";
						$message = "You have entered your new vendor in the ebroker system.<br>
						Name : ".mysql_real_escape_string($_POST['NAME'])."<br>
						Contact No : ".mysql_real_escape_string($_POST['CONTACT_NO'])."<br>
						Address : ".mysql_real_escape_string($_POST['ADDRESS'])."<br>
						Year : ".mysql_real_escape_string($_POST['YEAR'])."<br>					
						";
						$headers = 'From: info@hrimtech.com' . "\r\n" .
						   'Reply-To: info@hrimtech.com' . "\r\n" ;
						mail($to, $subject, $message, $headers);
					}
				}
				else
				{
					$error="Please Enter Correct Details.";
				}
		}
		else
		{
			$_SESSION['NAME']="";
			$_SESSION['CONTACT_NO']="";
			$_SESSION['ADDRESS']="";
			$_SESSION['YEAR']="";
		}
			$frm_action="add"; 
			break;
	case 'view':
	
			if(isset($_POST['SUBMIT']) && ($err_msg == ""))
		{	
				if($_POST['NAME'] == "")
				{
					$msg="Please Enter Your Name";
				}
				else
				{
						$_SESSION['NAME'] = $_POST['NAME'];
				}
				if($_POST['CONTACT_NO'] == "")
				{
					$msg1="Please Enter Your Contact Number";
				}
				else
				{
						$_SESSION['CONTACT_NO'] = $_POST['CONTACT_NO'];
				}
				if($_POST['ADDRESS'] == "")
				{
					$msg2="Please Enter Address";
				}
				else
				{
						$_SESSION['ADDRESS'] = $_POST['ADDRESS'];
				}
				if($_POST['YEAR'] == "")
				{
					$msg3="Please Enter Year";
				}
				else
				{
						$_SESSION['YEAR'] = $_POST['YEAR'];
				}
				if(($msg == "") && ($msg1 == "") && ($msg2 == "") && ($msg3 == ""))
				{
					$sql="";
					$sql = "INSERT INTO `vendors` (`broker_id`, `name`, `contact_no`, `address`, `year`) VALUES('".mysql_real_escape_string($_SESSION['login_id'])."','".ucwords(strtolower(mysql_real_escape_string($_POST['NAME'])))."','".mysql_real_escape_string($_POST['CONTACT_NO'])."','".mysql_real_escape_string($_POST['ADDRESS'])."','".mysql_real_escape_string($_POST['YEAR'])."');";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['NAME']="";
						$_SESSION['CONTACT_NO']="";
						$_SESSION['ADDRESS']="";
						$_SESSION['YEAR']="";
						$err_msg="Succesfully Inserted.";
						$to      = $_SESSION['email_id'];
						$subject = "New Vendor Added";
						$message = "You have entered your new vendor in the ebroker system.<br>
						Name : ".mysql_real_escape_string($_POST['NAME'])."<br>
						Contact No : ".mysql_real_escape_string($_POST['CONTACT_NO'])."<br>
						Address : ".mysql_real_escape_string($_POST['ADDRESS'])."<br>
						Year : ".mysql_real_escape_string($_POST['YEAR'])."<br>					
						";
						$headers = 'From: info@hrimtech.com' . "\r\n" .
						   'Reply-To: info@hrimtech.com' . "\r\n" ;
						mail($to, $subject, $message, $headers);
					}
				}
				else
				{
					$error="Please Enter Correct Details.";
				}
		}
		else
		{
			$_SESSION['NAME']="";
			$_SESSION['CONTACT_NO']="";
			$_SESSION['ADDRESS']="";
			$_SESSION['YEAR']="";
		}
			$frm_action="view"; 
			break;
	default:
				$_SESSION['NAME']="";
				$_SESSION['CONTACT_NO']="";
				$_SESSION['ADDRESS']="";
				$_SESSION['YEAR']="";
			$frm_action="add"; 
			break; 
}
?>
	<hr class="noscreen" />
		<form name="VENDORFORM" action="manage_vendors.php?action=<?php echo $frm_action;?>" id="vendorform" method="post">
			<input type="hidden" name="vendor_id" value="<?php echo $edit_rec['vendor_id'];?>"/>
			<head>
				<script type="text/javascript" src="js/manage_vendors.js"></script>
			</head>
		<!-- Content (Right Column) -->
		<div id="content" class="box">
		
			<?php if($_GET['action'] != "view") { ?>
			<!-- Table (TABLE) -->
			<h3 class="tit">Manage vendors</h3>
			<?php
				include("include/paginator.class.php");
				$query = "SELECT COUNT('broker_id') FROM vendors";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_fetch_row($result);

				$pages = new Paginator;
				$pages->items_total = $num_rows[0];
				$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
				$pages->paginate();
				?>
				</span>
			<table width="75%">
				<tr>
				    <th width="5%"><input type='checkbox' onclick="checkAll()"></th>
				    <th width="25%">NAME</th>
				    <th width="15%">CONTACT NO</th>
				    <th width="35%">ADDRESS</th>
				    <th width="10%">YEAR</th>
				    <th width="50%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `vendors` where broker_id=".$_SESSION['login_id']."$pages->limit";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					$i++;
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><input type="checkbox" name="details[]" value="<?php echo $row[0]; ?>"/></td>
				    <td><?php echo $row['name'] ?></td>
				    <td><?php echo $row['contact_no'] ?></td>
				    <td><?php echo $row['address'] ?></td>
				    <td><?php echo $row['year'] ?></td>	 
					<td><a href="manage_vendors.php?action=edit&id=<?php echo $row['vendor_id'];?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;<a href="manage_vendors.php?action=delete&id=<?php echo $row['vendor_id'];?>"><img src="img/delete.png" alt="delete"></a></td>	
				</tr>
				<?php } ?>
				<tr>
					<td><input type="image" name="IMAGE" src="img/delete.png" alt="delete"></td>
					<td align="center" colspan="5">
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
			<h3 class="tit">Add Vendor</h3>
			
			<?php if($error != "" || $err != "" ) { ?>
			<p class="msg error"><?php echo $error; ?></p>
			<?php } ?>
			
			<?php if($err_msg != "" ) { ?>
			<p class="msg done"><?php echo $err_msg; ?></p>
			<?php } ?>
		
			<p class="msg info">Enter Your Vendor Details.</p>
			
			<fieldset>
				<legend>Vendor Information</legend>
				<table class="nostyle">
					<tr>
						<td style="width:70px;">Name:</td>
						<td><input type="text" size="40" name="NAME" id="name" class="input-text" value="<?php if($edit_rec['name'] != ""){ echo $edit_rec['name'];} else {echo $_SESSION['NAME']; } 	?>" />
							   <font color="red"><?php echo $msg;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Contact No:</td>
						<td><input type="text" size="40" name="CONTACT_NO" id="contactno" maxlength="15" class="input-text" value="<?php if($edit_rec['contact_no'] != ""){ echo $edit_rec['contact_no'];} else { echo $_SESSION['CONTACT_NO']; } ?>" />
							   <font color="red"><?php echo $msg1;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Address:</td>
						<td><textarea cols="43" rows="7" name="ADDRESS" id="address" class="input-text"><?php  if($edit_rec['address'] != ""){ echo $edit_rec['address'];} else { echo $_SESSION['ADDRESS']; } ?></textarea>
							<font color="red" class="va-top"><?php echo $msg2;?></font>
						</td>
					</tr>
					<tr>
						<td class="va-top">Year:</td>
						<td><input type="text" size="40" name="YEAR" id="year" class="input-text" value="<?php if($edit_rec['year'] != ""){ echo $edit_rec['year'];} else { echo $_SESSION['YEAR']; } ?>" />
							   <font color="red"><?php echo $msg3;?></font>
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