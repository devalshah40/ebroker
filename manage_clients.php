<?php
ob_start(); 
include"header.php";
include("left.php");



switch($_GET['action'])
{
	case 'edit':
			$edit_rec=mysql_fetch_array(mysql_query("SELECT * FROM clients WHERE client_id = ".mysql_real_escape_string($_GET['id']).""));
			$frm_action="update";
			break;

	case 'update':
			mysql_query("UPDATE clients SET 
			name= '".mysql_real_escape_string($_POST['NAME'])."',
			address= '".mysql_real_escape_string($_POST['ADDRESS'])."',
			year= '".mysql_real_escape_string($_POST['YEAR'])."',
			brokerage= '".mysql_real_escape_string($_POST['BROKERAGE'])."'
			WHERE client_id = ".mysql_real_escape_string($_POST['client_id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg ="";
				$err_msg = "Client Updated Successfully.";
			}
			$frm_action = "add";
			break;

	case 'delete':
			$row=mysql_fetch_array(mysql_query("SELECT * FROM transactions WHERE client_id = ".mysql_real_escape_string($_GET['id']).""));
			if($row[0] != "")
			{
				header("Location: manage_transactions.php");
				exit;
			}
			mysql_query("DELETE FROM payments WHERE client_id = ".mysql_real_escape_string($_GET['id'])."");
			mysql_query("DELETE FROM transactions WHERE client_id = ".mysql_real_escape_string($_GET['id'])."");
			mysql_query("DELETE FROM clients WHERE client_id = ".mysql_real_escape_string($_GET['id'])."");
			if(mysql_affected_rows() > 0)
			{$err_msg ="";
				$err_msg = "Client Deleted Successfully.";
			}
			ob_end_flush();
			$frm_action = "add";
	    	break;
		
	case 'add':
		if (isset( $_POST['IMAGE_x']))
		{
			foreach ($_POST['details'] as $value)
			{
					$row=mysql_fetch_array(mysql_query("SELECT * FROM transactions WHERE client_id = ".$value.""));
					if($row[0] != "")
					{
						header("Location: manage_transactions.php");
						exit;
					}
					mysql_query("DELETE FROM payments WHERE client_id = ".$value."");
					mysql_query("DELETE FROM transactions WHERE client_id = ".$value."");
					mysql_query("DELETE FROM clients WHERE client_id = ".$value."");
					if(mysql_affected_rows() > 0)
					{$err_msg ="";
						$err_msg = "Client Deleted Successfully.";
					}
				}
				ob_end_flush();
				$frm_action = "add";
				break;
		}
			
		if(isset($_POST['SUBMIT']) && ($err_msg == ""))
		{	
			if($_POST['NAME'] == "")
			{
				$msg1="Please Enter Your Name";
			}
			else
			{
					$_SESSION['NAME'] = $_POST['NAME'];
			}
			if($_POST['ADDRESS'] == "")
			{
				$msg2="Please Enter Your Address";
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
			if($_POST['BROKERAGE'] == "")
			{
				$msg4="Please Enter Brokerage Value";
			}
			else
			{
					$_SESSION['BROKERAGE'] = $_POST['BROKERAGE'];
			}
			function isValidEmail($email){
				return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
			}
			if(!isValidEmail($_POST['EMAILID']))
			{
				$msg5="Please Enter Email Id";
			}
			else
			{
					$_SESSION['EMAILID1'] = $_POST['EMAILID'];
			}
			if(($msg1 == "") && ($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == ""))
			{
				$sql="";
				$sql = "INSERT INTO `clients` (`broker_id`, `name`, `address`, `year`, `brokerage`, `email_id`) VALUES ('".mysql_real_escape_string($_SESSION['login_id'])."','".ucwords(strtolower(mysql_real_escape_string($_POST['NAME'])))."','".mysql_real_escape_string($_POST['ADDRESS'])."','".mysql_real_escape_string($_POST['YEAR'])."','".mysql_real_escape_string($_POST['BROKERAGE'])."','".mysql_real_escape_string($_POST['EMAILID'])."');";
				if(!mysql_query($sql))
				{
					$err = "Rows Not Inserted.";
				}
				else
				{
					$_SESSION['NAME']="";
					$_SESSION['ADDRESS']="";
					$_SESSION['YEAR']="";
					$_SESSION['BROKERAGE']="";
					$_SESSION['EMAILID1'] = "";
					$err_msg="Succesfully Inserted.";
					
					$to      = $_SESSION['email_id'];
					$subject = "New Client Added";
					$message = "You have entered your new client in the ebroker system.<br>
					Name : ".mysql_real_escape_string($_POST['NAME'])."<br>
					Address : ".mysql_real_escape_string($_POST['ADDRESS'])."<br>
					Year : ".mysql_real_escape_string($_POST['YEAR'])."<br>
					Brokerage : ".mysql_real_escape_string($_POST['BROKERAGE'])."<br>					
					";
					$headers = 'From: info@hrimtech.com' . "\r\n" .
					'Reply-To: info@hrimtech.com' . "\r\n" ;
					$headers  .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
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
			$_SESSION['ADDRESS']="";
			$_SESSION['YEAR']="";
			$_SESSION['BROKERAGE']="";
			$_SESSION['EMAILID1'] = "";
		}
			$frm_action="add"; 
			break;
	
	case 'view':
		if(isset($_POST['SUBMIT']) && ($err_msg == ""))
		{	
			if($_POST['NAME'] == "")
			{
				$msg1="Please Enter Your Name";
			}
			else
			{
					$_SESSION['NAME'] = $_POST['NAME'];
			}
			if($_POST['ADDRESS'] == "")
			{
				$msg2="Please Enter Your Address";
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
			if($_POST['BROKERAGE'] == "")
			{
				$msg4="Please Enter Brokerage Value";
			}
			else
			{
					$_SESSION['BROKERAGE'] = $_POST['BROKERAGE'];
			}
			function isValidEmail($email){
				return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
			}
			if(!isValidEmail($_POST['EMAILID']))
			{
				$msg5="Please Enter Email Id";
			}
			else
			{
					$_SESSION['EMAILID1'] = $_POST['EMAILID'];
			}
			if(($msg1 == "") && ($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == ""))
			{
				$sql="";
				$sql = "INSERT INTO `clients` (`broker_id`, `name`, `address`, `year`, `brokerage`, `email_id`) VALUES ('".mysql_real_escape_string($_SESSION['login_id'])."','".ucwords(strtolower(mysql_real_escape_string($_POST['NAME'])))."','".mysql_real_escape_string($_POST['ADDRESS'])."','".mysql_real_escape_string($_POST['YEAR'])."','".mysql_real_escape_string($_POST['BROKERAGE'])."','".mysql_real_escape_string($_POST['EMAILID'])."');";
				if(!mysql_query($sql))
				{
					$err = "Rows Not Inserted.";
				}
				else
				{
					$_SESSION['NAME']="";
					$_SESSION['ADDRESS']="";
					$_SESSION['YEAR']="";
					$_SESSION['BROKERAGE']="";
					$_SESSION['EMAILID1'] = "";
					$err_msg="Succesfully Inserted.";
					
					$to      = $_SESSION['email_id'];
					$subject = "New Client Added";
					$message = "You have entered your new client in the ebroker system.<br>
					Name : ".mysql_real_escape_string($_POST['NAME'])."<br>
					Address : ".mysql_real_escape_string($_POST['ADDRESS'])."<br>
					Year : ".mysql_real_escape_string($_POST['YEAR'])."<br>
					Brokerage : ".mysql_real_escape_string($_POST['BROKERAGE'])."<br>					
					";
					$headers = 'From: info@hrimtech.com' . "\r\n" .
					'Reply-To: info@hrimtech.com' . "\r\n" ;
					$headers  .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
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
			$_SESSION['ADDRESS']="";
			$_SESSION['YEAR']="";
			$_SESSION['BROKERAGE']="";
			$_SESSION['EMAILID1'] = "";
		}
			$frm_action="view"; 
			break;
	default:
			$_SESSION['NAME']="";
			$_SESSION['ADDRESS']="";
			$_SESSION['YEAR']="";
			$_SESSION['BROKERAGE']="";
			$_SESSION['EMAILID1'] = "";
			$frm_action="add"; 
			break; 
}
?>
<hr class="noscreen" />
		<form name="CLIENTFORM" action="manage_clients.php?action=<?php echo $frm_action; ?>" id="clientform" method="post" >
			<input type="hidden" name="client_id" value="<?php echo $edit_rec['client_id'];?>">
			<head>
				<script type="text/javascript" src="js/manage_clients.js"></script>
				<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js">
				</script>
				<script type="text/javascript">
				$(document).ready(function()
				{
				$(".edit_tr").click(function()
				{
				var ID=$(this).attr('id');
				$("#first_"+ID).hide();
				$("#last_"+ID).hide();
				$("#first_input_"+ID).show();
				$("#last_input_"+ID).show();
				}).change(function()
				{
				var ID=$(this).attr('id');
				var first=$("#first_input_"+ID).val();
				var dataString = 'id='+ ID +'&firstname='+first;
				$("#first_"+ID).html('<img src="load.gif" />'); // Loading image

				if(first.length>0)
				{

				$.ajax({
				type: "POST",
				url: "table_edit_ajax.php",
				data: dataString,
				cache: false,
				success: function(html)
				{
				$("#first_"+ID).html(first);
				}
				});
				}
				else
				{
				alert('Enter something.');
				}

				});

				// Edit input box click action
				$(".editbox").mouseup(function()
				{
				return false
				});

				// Outside click action
				$(document).mouseup(function()
				{
				$(".editbox").hide();
				$(".text").show();
				});

				});
				</script>
				<style type="text/css">
					.editbox
					{
					display:none
					}
					td
					{
					padding:5px;
					}
					.editbox
					{
					font-size:14px;
					width:270px;
					background-color:#ffffcc;
					border:solid 1px #000;
					padding:4px;
					}
					.edit_tr:hover
					{
					background:url(edit.png) right no-repeat #80C8E5;
					cursor:pointer;
					}
				</style>
			</head>
		<!-- Content (Right Column) -->
		<div id="content" class="box">
			<?php if($_GET['action'] != "view") { ?>
			
			<!-- Table (TABLE) -->
			<h3 class="tit">Manage Clients</h3>
			<?php
				include("include/paginator.class.php");
				$query = "SELECT COUNT('broker_id') FROM clients";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_fetch_row($result);

				$pages = new Paginator;
				$pages->items_total = $num_rows[0];
				$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
				$pages->paginate();
				?>
				
			<table width="70%">
				<tr>
				    <th width="5%"><input type='checkbox' onclick="checkAll()"></th>
				    <th width="18%">NAME</th>
				    <th width="18%">ADDRESS</th>
				    <th width="10%">YEAR</th>
				    <th width="10%">BROKERAGE</th>
				    <th width="14%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `clients` where broker_id=".$_SESSION['login_id']."$pages->limit";
				 $rs = mysql_query($sql); 
				 $i=0; 
				while($row = mysql_fetch_array($rs))
				{
					/*echo "<pre>";
					print_r($row);exit;*/
					$i++;
				?>
				<tr id="<?php echo $row[0]; ?>" class="edit_tr" > 
				    <td><input type="checkbox" name="details[]" value="<?php echo $row[0]; ?>" /></td>
				    <td class="edit_td" >
						<span id="first_<?php echo $row[0]; ?>" class="text">
							<?php echo $row['name'] ?>
						</span>
						<input type="text" value="<?php echo $row['name']; ?>" class="editbox" id="first_input_<?php echo $row[0]; ?>"/>
					</td>
				    <td><?php echo $row['address'] ?></td>
				    <td><?php echo $row['year'] ?></td>
				    <td><?php echo $row['brokerage'] ?></td>	
				    <td>
						<a href="manage_clients.php?action=edit&id=<?php echo $row['client_id'];?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;
						<a href="manage_clients.php?action=delete&id=<?php echo $row['client_id'];?>" onclick="return confirmation()"><img src="img/delete.png" alt="delete"></a>
					</td>	
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
			
			<h3 class="tit">Add Client</h3>
	
			<?php if($error != "" || $err != "" ) { ?>
			<p class="msg error"><?php echo $error; ?></p>
			<?php } ?>
			
			<?php if($err_msg != "" ) { ?>
			<p class="msg done"><?php echo $err_msg; ?></p>
			<?php } ?>
		
			<p class="msg info">Enter Your Client Details.</p>
			
			
			<fieldset>
				<legend>Client Information</legend>
				<table class="nostyle">
					<tr>
						<td style="width:70px;">Name:</td>
						<td><input type="text" size="40" name="NAME" id="name" class="input-text" value="<?php if($edit_rec['name']!=""){ echo $edit_rec['name']; }else{ echo $_SESSION['NAME']; } ?>" />
							   <font color="red"><?php echo $msg1;?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Address:</td>
						<td><textarea cols="43" rows="7" name="ADDRESS" id="address" class="input-text"><?php if($edit_rec['address']!=""){ echo $edit_rec['address']; }else{ echo $_SESSION['ADDRESS']; } ?></textarea>
							<font color="red" class="va-top"><?php echo $msg2;?></font>
						</td>
					</tr>
					<tr>
						<td class="va-top">Year:</td>
						<td><input type="text" size="40" name="YEAR" class="input-text" id="year"  value="<?php if($edit_rec['year'] != "") { echo $edit_rec['year'];} else { echo $_SESSION['YEAR']; } ?>" />
							   <font color="red"><?php echo $msg3;?></font>
						</td>
					</tr>
					<tr>
						<td>Brokerage:</td>
						<td>
							<input type="text" size="40" name="BROKERAGE" class="input-text" id="brokerage"  value="<?php if($edit_rec['brokerage'] != "") { echo $edit_rec['brokerage'];} else { echo $_SESSION['BROKERAGE']; } ?>" />
							   <font color="red"><?php echo $msg4;?></font>
						</td>
					</tr>
					<tr>
						<td>Email Id:</td>
						<td>
							<input type="text" size="40" name="EMAILID" class="input-text" id="emailid"  value="<?php if($edit_rec['email_id'] != "") { echo $edit_rec['email_id'];} else { echo $_SESSION['EMAILID1']; } ?>" />
							   <font color="red"><?php echo $msg5;?></font>
						</td>
					</tr>	
					<tr>
						<td></td>
						<td  class="t-left">
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
	