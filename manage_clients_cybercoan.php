<?php
include"header.php";
include("left.php");/*
echo "<pre>";
print_r($_POST);*/
switch($_GET['action'])
{
	case 'edit':
		if(isset($_POST['SUBMIT']))
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
				if(($msg1 == "") && ($msg2 == "") && ($msg3 == "") && ($msg4 == "") && ($msg5 == ""))
				{
						$sql = "";
						$sql = "INSERT INTO `clients` (`client_id`, `broker_id`, `name`, `address`, `year`, `brokerage`, `email_id`) VALUES (NULL, '".$_SESSION['login_id']."', '".						                            mysql_real_escape_string($_POST['NAME'])."', '".mysql_real_escape_string($_POST['ADDRESS'])."', '".mysql_real_escape_string($_POST['YEAR'])."', '".                            mysql_real_escape_string($_POST['BROKERAGE'])."', '".mysql_real_escape_string($_POST['EMAILID'])."');";
						if(!mysql_query($sql))
						{
							$err  =  'No Rows Inserted';	
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
		}
	case 'delete':
		
	default:
			$_SESSION['NAME']="";
			$_SESSION['ADDRESS']="";
			$_SESSION['YEAR']="";
			$_SESSION['BROKERAGE']="";
			$_SESSION['EMAILID1'] = "";
			$frm_action="add"; 
			break; 
?>
<hr class="noscreen" />
		<form name="" action="manage_clients_cybercoan.php" id="form" method="post" ><?php /*?> ?action=<?php echo $frm_action; ?><?php */?>

			
	
		<!-- Content (Right Column) -->
		<div id="content" class="box">
			
				
			<!-- Table (TABLE) -->
			<!-- Table (TABLE) -->
			<h3 class="tit">Manage Clients</h3>
			<table width="70%">
				<tr>
				    <th width="18%">NAME</th>
				    <th width="18%">ADDRESS</th>
				    <th width="10%">YEAR</th>
				    <th width="10%">BROKERAGE</th>
				    <th width="14%">ACTION</th>
				</tr>
                <?php
				$i=0;
				$sql="";
				$sql = "SELECT * FROM `clients`";
				$rs=mysql_query($sql);
				while( $row   =   mysql_fetch_array( $rs ) )
				{
					$i++;
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>
				    <td><?php echo $row['name'] ?></td>
				    <td><?php echo $row['address'] ?></td>
				    <td><?php echo $row['year'] ?></td>
				    <td><?php echo $row['brokerage'] ?></td>
                    <td>
						<a href="manage_clients_cybercoan.php?action=edit&id=<?php echo $row['client_id'];?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;
						<a href="manage_clients_cybercoan.php?action=delete&id=<?php echo $row['client_id'];?>" onclick="return confirmation()"><img src="img/delete.png" alt="delete"></a>
					</td>	
                <?php } ?>
				</tr>
			
			</table>

			<!-- Form -->
			<h3 class="tit">Form</h3>
		<fieldset>
				<legend>Client Information</legend>
				<table class="nostyle">
					<tr>
						<td style="width:70px;">Name:</td>
						<td><input type="text" size="40" name="NAME" id="name" class="input-text" value="<?php echo $_SESSION['NAME']; ?>" />
							   <font color="red"><?php echo $msg1; ?></font>
						</td>
					</tr>
					<tr>
						<td  class="va-top">Address:</td>
						<td><textarea cols="37" rows="7" name="ADDRESS" id="address" class="input-text"><?php echo $_SESSION['ADDRESS']; ?></textarea>
							   <font color="red"><?php echo $msg2 ?></font>
						</td>
					</tr>
					<tr>
						<td class="va-top">Year:</td>
						<td><input type="text" size="40" name="YEAR" class="input-text" id="year" value="<?php  echo $_SESSION['YEAR'];  ?>"  />
							   <font color="red"><?php echo $msg3; ?></font>
						</td>
					</tr>
					<tr>
						<td>Brokerage:</td>
						<td>
							<input type="text" size="40" name="BROKERAGE" class="input-text" id="brokerage" value="<?php  echo $_SESSION['BROKERAGE'];  ?>"/>
							   <font color="red"><?php echo $msg4; ?></font>
						</td>
					</tr>
					<tr>
						<td>Email Id:</td>
						<td>
							<input type="text" size="40" name="EMAILID" class="input-text" id="emailid"  value="<?php  echo $_SESSION['EMAILID1'];  ?>" />
							   <font color="red"><?php echo $msg5; ?></font>
						</td>
					</tr>
					<tr>
						<td class="t-right"><input type="submit" name="SUBMIT" id="SUBMIT" class="input-submit" value="Submit"></td>					
					</tr>
				</table>
			</fieldset>
            </div>
            </form>
           
<?php
include "footer.php"; 
?>