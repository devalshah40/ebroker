<?php
include("header.php");
include("left.php");
switch($_GET['action'])
{
	case 'edit':
			$edit_rec=mysql_fetch_array(mysql_query("SELECT * FROM greetings WHERE greetings_id = ".mysql_real_escape_string($_GET['id']).""));
			$frm_action="update";
			break;
			
	case 'update':
					if ( get_magic_quotes_gpc() )
					{
						$postedValue = htmlentities(stripslashes($_POST['editor1'])) ;}
					else
					{
					$postedValue = htmlentities($_POST['editor1']) ;}
			mysql_query("UPDATE greetings SET 
			greetings_title= '".mysql_real_escape_string($_POST['title'])."',
			greetings_details= '".$postedValue."',
			greetings_created_date=NOW()
			WHERE greetings_id = ".mysql_real_escape_string($_POST['greetings_id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg ="";
				$err_msg = "Client Updated Successfully.";
				$_SESSION['title']="";
				$_SESSION['editor1']="";
			}
			$frm_action = "create_greeting";
			break;		
			
	case 'delete':
			mysql_query("DELETE FROM greetings WHERE greetings_id = ".mysql_real_escape_string($_GET['id'])."");
			if(mysql_affected_rows() > 0)
			{$err_msg ="";
				$err_msg = "Greeting Deleted Successfully.";
			}
			$frm_action = "create_greeting";
	    	break;
		
	case 'create_greeting':
			if(isset($_POST['SUBMIT1']))
			{
				if($_POST['title'] == "")
				{
					$msg1="Please Enter Your Title";
				}
				else
				{	
						$_SESSION['title'] = $_POST['title'];
				}
				if($_POST['editor1'] == "")
				{
					$msg2="Please Enter Your Greetings";
				}
				else
				{
						$_SESSION['editor1'] = $_POST['editor1'];
				}
				if(($msg1 == "") && ($msg2 == ""))
				{
					if ( get_magic_quotes_gpc() )
					{
						$postedValue = htmlentities(stripslashes($_POST['editor1'])) ;}
					else
					{
						$postedValue = htmlentities($_POST['editor1']) ;
					}
					$sql="";
					$sql = "INSERT INTO greetings (`broker_id`,`greetings_title`, `greetings_details`, `greetings_created_date`) VALUES('".$_SESSION['login_id']."','".ucwords(strtolower(mysql_real_escape_string(mysql_real_escape_string($_POST['title']))))."','".$postedValue."',NOW());";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['title']="";
						$_SESSION['editor1']="";
					}
				}
				else
				{
					$error="Please Enter Correct Details.";
				}
			}
			else
			{
				$_SESSION['title']="";
				$_SESSION['editor1']="";
			}
			$frm_action="create_greeting"; 
			break;

	case 'send_greeting':
			if(isset($_POST['SUBMIT2']))
			{
				  $clients = $_POST['clients'];
				  $vendors = $_POST['vendors'];
				  if(!isset($clients))
				  {
					$msg3= "You didn't select any clients!";
				  }
				  if(!isset($vendors))
				  {
					$msg4="You didn't select any vendors!";
				  }
				  if($_POST['title1'] == "")
					{
						$msg5="Please Enter Your Name";
					}
				if(($msg3 == "") && ($msg4 == "") && ($msg5 == ""))
				{
					$edit_rec1=mysql_fetch_array(mysql_query("SELECT * FROM greetings WHERE broker_id = ".$_SESSION['login_id']." and greetings_id=".$_POST['title1']));
					$rs=mysql_query("SELECT * FROM `clients` where broker_id = ".$_SESSION['login_id']." and client_id NOT IN(SELECT client_id FROM `greetings_sent` where greeting_id=".$_POST['title1'].")");
				   //SELECT * FROM `clients` where broker_id=1 and client_id NOT IN(SELECT client_id FROM `greetings_sent`)
				   $rs1=mysql_query("SELECT * FROM `vendors` where broker_id = ".$_SESSION['login_id']." and vendor_id NOT IN(SELECT vendor_id FROM `greetings_sent` where greeting_id=".$_POST['title1'].")");
				   $clientstotal = count($clients);
				   $vendorstotal = count($vendors);
					while($row = mysql_fetch_array($rs))
					{
						for($i=0; $i < $clientstotal; $i++)
						{
							if($row['name'] == $clients[$i])
							{
								$emailid[]=$row['email_id'];
								$name[]=$row['name'];
								$client_ids[$i] =$row['client_id'];
							}
						}
					}
					while($row1 = mysql_fetch_array($rs1))
					{
						for($i=0; $i < $vendorstotal; $i++)
						{
							if($row1['name'] == $vendors[$i])
							{
								$emailid[] =$row1['email_id'];
								$name[]=$row1['name'];
								$vendor_ids[$i] = $row1['vendor_id'];
							}
						}
					} 
					$i=0;
					foreach ($emailid as &$value) 
					{	
						$to = $value;
						$subject = $edit_rec1['2'];
						$message ="<html>
							<head>
							 <title>".$edit_rec1['2']."</title>
							</head>
							<body>
							 ".html_entity_decode(stripslashes(str_ireplace("%fname%",$name[$i], $edit_rec1['3'])))."
							 </body>
							</html>";
							$i++;
						$headers = "From: ".$_SESSION['email_id']."\r\n".
						"Reply-To: ".$_SESSION['email_id']."\r\n" ;
						$headers  .= 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						mail($to, $subject, $message, $headers);
					}
						for($i=0; $i < sizeof($client_ids); $i++)
							{
								mysql_query("INSERT INTO `greetings_sent` (`greeting_id`, `client_id`, `vendor_id`, `send_date`) VALUES ('".$edit_rec1[0]."','".mysql_real_escape_string($client_ids[$i])."','0',NOW());");
							}
						for($i=0; $i < sizeof($vendor_ids); $i++)
							{
								mysql_query("INSERT INTO `greetings_sent` (`greeting_id`, `client_id`, `vendor_id`, `send_date`) VALUES ('".$edit_rec1[0]."','0','".mysql_real_escape_string($vendor_ids[$i])."',NOW());");
							}
				}
				else
				{
					$error="Please Enter Correct Details.";
				}
			}
			$frm_action="create_greeting"; 
			break;
	default:
			$edit_rec="";
			$_SESSION['title']="";
			$_SESSION['editor1']="";
			$frm_action="create_greeting"; 
			break;
}

?>

<hr class="noscreen" />
		<!-- Content (Right Column) -->
		<div id="content" class="box">
		<h3 class="tit">Greetings</h3>

			<div class="tabs box">
				<ul>
					<li><a href="#tab01"><span>Add Greetings</span></a></li>
					<li><a href="#tab02"><span>View Greetings</span></a></li>
					<li><a href="#tab03"><span>Send Greetings</span></a></li>
					<li><a href="#tab04"><span>View Status</span></a></li>
				</ul>
			</div> <!-- /tabs -->

			<!-- Tab01 -->
			<div id="tab01">
			
			<form name="GREETINGFORM" action="manage_greetings.php?action=<?php echo $frm_action; ?>" id="greetingform" method="post">
			<input type="hidden" name="greetings_id" value="<?php echo $edit_rec['greetings_id'];?>">
			<head>
				<script type="text/javascript" src="js/manage_greetings.js"></script>
				<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
			</head>
			<table class="nostyle">
				<tr>
						<td style="width:70px;">Title:</td>
						<td><input type="text" size="40" name="title" id="title" class="input-text" value="<?php if($edit_rec[2]!=""){ echo $edit_rec[2]; } else { echo $_SESSION['title']; } ?>"/>
							   <font color="red"><?php echo $msg1;?></font>
						</td>
				</tr>
				<tr>
						<td  class="va-top">Details:</td>
						<td><textarea  name="editor1" id="editor1" class="ckeditor"><?php if($edit_rec[3]!=""){ echo $edit_rec[3]; }else{ echo $_SESSION['editor1']; }?></textarea>
							   <font color="red"><?php echo $msg2;?></font>
						</td>
				</tr>
				<tr>
						<td></td>
						<td class="t-left">
							<input type="submit" name="SUBMIT1" id="SUBMIT" class="input-submit" value="Submit" onclick="return formValidator();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" name="CANCEL" id="CANCEL" class="input-submit" value="Clear">
						</td>
				</tr>
			</table>
			</form>
			
			</div> <!-- /tab01 -->

			<!-- Tab02 -->
			<div id="tab02">
			
			<form name="GREETINGFORM2" action="manage_greetings.php?action=<?php echo $frm_action; ?>" id="greetingform1" method="post" onsubmit="return formValidator();">
			<head>
				<script type="text/javascript" src="js/manage_greetings.js"></script>
				<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
			</head>
			<h3 class="tit">View Greetings</h3>
			<?php
				?>
			<table width="30%">
				<tr>
				    <th width="18%">TITLE</th>
				    <th width="14%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM greetings where broker_id=".$_SESSION['login_id'];
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					$i++;
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>> 
				    <td><?php echo $row['greetings_title'] ?></td>
				    <td>
					<a href="manage_greetings.php?action=edit&id=<?php echo $row['greetings_id'];?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;
					<a href="manage_greetings.php?action=delete&id=<?php echo $row['greetings_id'];?>">
						<img src="img/delete.png" alt="delete">
					</a>
					</td>	
				</tr>
				<?php } ?>
			</table>
			</form>
			</div> <!-- /tab02 -->

			<!-- Tab03 -->
			<div id="tab03">
			<form name="GREETINGFORM3" action="manage_greetings.php?action=send_greeting" id="greetingform2" method="post">
			<head>
				<script type="text/javascript" src="js/manage_greetings.js"></script>
				<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
			</head>
			<table class="nostyle" width="90%">
				<tr>
						<td style="width:70px;">Title:</td>
						<td>
								<select name="title1" id="title1" style="width: 180px;height: 25px;">
									<option value="">Select Greeting</option>
									<?php
									$sql="";
									$sql = "SELECT * FROM `greetings` WHERE `broker_id` = '".$_SESSION['login_id']."'";
									$rs=mysql_query($sql);
									 while($row = mysql_fetch_array($rs))
									 {
									?>
									<option value="<?php echo $row['greetings_id']; ?>"
									<?php
									if($error != "" && $_SESSION['greetings_id'] == $row['greetings_id'])
									{
										echo "selected";
									}
									else if($edit_rec['greetings_id'] == $row['greetings_id'])
									{
										echo "selected";
									}
									?>
									><?php 	echo trim($row['greetings_title']); } ?>							
									</option>
									</select>
							   <font color="red"><?php echo $msg5;?></font>
						</td>
					<td style="width:70px;">Clients:</td>
					<td>
						<select multiple="multiple" name="clients[]" size="10"  style="width: 180px">
								<?php
										 $sql="";
										 echo $sql = "SELECT * FROM `clients` where broker_id=".$_SESSION['login_id'];
										 $rs = mysql_query($sql);
										 $i=0;
										while($row = mysql_fetch_array($rs))
										{
										?>
									<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
								<?php } ?>
						</select>
							<font color="red" class="va-top"><?php echo $msg3;?></font>
					</td>
					<td style="width:70px;">Vendors:</td>
					<td>
							<select multiple="multiple" name="vendors[]" size="10" style="width: 180px">
								<?php
										 $sql="";
										 echo $sql = "SELECT * FROM `vendors` where broker_id=".$_SESSION['login_id'];
										 $rs = mysql_query($sql);
										 $i=0;
										while($row = mysql_fetch_array($rs))
										{
										?>
									<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
								<?php } ?>
						</select>
							<font color="red" class="va-top"><?php echo $msg4;?></font>
					</td>
				</tr>
				<tr>
						<td colspan="2"></td>
						<td colspan="6">
							<div><p><h5>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</h5></p></div>
						</td>
				</tr>
				<tr>
						<td colspan="5"></td>
						<td class="t-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="SUBMIT2" id="SUBMIT" class="input-submit" value="Submit" onclick="return formValidator1();"></td>
				</tr>
			</table>
			<form>
			</div> <!-- /tab03 -->
			
			<!-- Tab04 -->
			<div id="tab04">
			<table width="70%">
				<tr>
				    <th width="18%">GREETING TITLE</th>
				    <th width="18%">CLIENTS</th>
				    <th width="10%">DATE</th>
				</tr>
				<?php
					$sql="";
					$sql = "SELECT * FROM `greetings` WHERE `broker_id` = '".$_SESSION['login_id']."';";
					$rs=mysql_query($sql);
					 while($row = mysql_fetch_array($rs))
					{
						$i=0;
						$sql="";
						$sql = "SELECT * FROM `greetings_sent` WHERE `greeting_id` = '".$row[0]."' and vendor_id='0';";
						$rs1=mysql_query($sql);
							while($row1=mysql_fetch_array($rs1))
							{
							$i++;
							$row3=mysql_fetch_array(mysql_query("SELECT * FROM `clients` where client_id=".$row1[1].";"));
							?>
							<tr <?php if($i%2 == 0) echo "class=bg" ?>> 
									<td ><?php echo $row[2]; ?></td>
									<td><?php echo $row3[2]; ?></td>
									<td><?php echo date($_SESSION['date_format'],strtotime($row1[3])); ?></td>
							</tr>
					<?php }	?>
				<?php } ?>
			</table>
			<table width="70%">
				<tr>
				    <th width="18%">GREETING TITLE</th>
				    <th width="10%">VENDORS</th>
				    <th width="10%">DATE</th>
				</tr>
				<?php 
					$sql="";
					$sql = "SELECT * FROM `greetings` WHERE `broker_id` = '".$_SESSION['login_id']."';";
					$rs=mysql_query($sql);
					 while($row = mysql_fetch_array($rs))
					{
						$i=0;
						$sql="";
						$sql = "SELECT * FROM `greetings_sent` WHERE `greeting_id` = '".$row[0]."' and client_id='0';";
						$rs2=mysql_query($sql);
							while($row2=mysql_fetch_array($rs2))
							{
							$i++;
							$row4=mysql_fetch_row(mysql_query("SELECT * FROM `vendors` where vendor_id=".$row2[2].";"));
							?>
								<tr <?php if($i%2 == 0) echo "class=bg" ?>> 
									<td ><?php echo $row[2]; ?></td>
									<td><?php echo $row4[2]; ?></td>
									<td><?php echo date($_SESSION['date_format'],strtotime($row2[3])); ?></td>
							</tr>
				<?php } } ?>
			</table>
			</div> <!-- /tab04 -->
	</div> <!-- /content -->
	</div> <!-- /cols -->
<?php
include "footer.php"; 
?>