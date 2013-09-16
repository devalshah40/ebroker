<?php
include "header.php";
include "left.php";
mkdir("data",0700);
chdir("data");
mkdir("logs",0700);
chdir("logs");
$i=$_SESSION['login_id'];
$file = fopen("url_".$i.".log", "a+");
$contents = date('l dS \of F Y h:i:s A');
$contents .="\t broker_id =".$_SESSION['login_id']."\n";

  if (fwrite($file, $contents) === FALSE) {
       echo "Cannot write to file ($filename)";
       exit;
   }
   
   if(isset($_POST['SUBMIT']) && ($check_double_insert == ""))
{
	$sql="";
	 $sql = "SELECT * FROM `broker` WHERE broker_id = ".$_SESSION['login_id'];
	 
	 $rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	
		if($row['password'] == $_POST['PASSWORD1'] && $_POST['PASSWORD2'] == $_POST['PASSWORD3'])
		{
			  $sql="UPDATE `broker` SET
			`password`= '".mysql_real_escape_string($_POST['PASSWORD2'])."'			
			WHERE `broker_id` = ".mysql_real_escape_string($_SESSION['login_id']).";";
			mysql_query($sql);
			
				
				$err_msg = "Password Changed Successfully.";
			
		}
		else if($_POST['PASSWORD2'] != $_POST['PASSWORD3'])
		{
		    $err_msg7 = "New Password And Confirm Password must be same";
		}
		else
		{
		$err_msg8 = "Old Password Not Correct";
		}
	}
   
   if(isset($_POST['SUBMIT']) && ($check_double_insert == ""))
			{
							if($_POST['PASSWORD1'] == "")
				{
					$msg2="Please Enter Old Password";
				}
				else
				{
						$_SESSION['PASSWORD3'] = $_POST['PASSWORD3'];
				}
				if($_POST['PASSWORD2'] == "")
				{
					$msg3="Please Enter New Password";
				}
				else
				{
						$_SESSION['PASSWORD2'] = $_POST['PASSWORD2'];
				}
				if($_POST['PASSWORD3'] == "")
				{
					$msg4="Please Enter Confirm Password";
				}
				else
				{
						$_SESSION['PASSWORD3'] = $_POST['PASSWORD3'];
				}
				
				}
			else
			{
					$_SESSION['PASSWORD1']="";
					$_SESSION['PASSWORD2']="";
					$_SESSION['PASSWORD3']="";
					
			}
			
			
			
?>
    
							

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">


	
			<!-- Form -->
			<h3 class="tit">Recent Tasks</h3>
			<table  width="80%">
				<tr>
				    <th width="30%">TITLE</th>
					<th width="60%">DETAILS</th>
					 <th width="10%">ACTION</th>
				    </tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `task` where `broker_id`=".$_SESSION['login_id']." and `start date` >= CURDATE() ORDER BY `start date` ASC LIMIT 5";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					 $i++;
					 $sql="";
					 $sql = "SELECT * FROM `task` WHERE broker_id = ".$_SESSION['login_id'] ;
					 
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
				?>
				     <tr <?php if($i%2 == 0) echo "class=bg" ?>>      
				    <td><?php echo $row['title'] ?></td>
				    <td><?php echo html_entity_decode(stripslashes($row['details'])) ?></td>
				   <td><a href="manage_task.php?action=edit&id=<?php echo $row['task_id']; ?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;<a href="manage_task.php?action=delete&id=<?php echo $row['task_id']; ?>"><img src="img/delete.png" alt="delete" onclick="return confirmation()" ></a></td>	
				</tr>
				<?php } ?>
			</table>
	
			
		</div> <!-- /content -->


		<div id="content" class="box">

			<fieldset>
				<legend>Change Password</legend>
				<form name="CHANGEPASSWORDFORM" action="index.php" id="changepasswordform" method="post" onsubmit="return formValidator();">
				<table class="nostyle">
				
					<tr>
						<td >Old Password:</td>
						<td>   <input type="password" size="40" id="password1" name="PASSWORD1" />
         
						<font color="red"><?php echo $msg2;?></font>
						<font color="red"><?php echo $err_msg8;?></font>
						</td>
					</tr>
					<tr>
						<td >New Password:</td>
						<td>   <input type="password" size="40" id="password2" name="PASSWORD2" />
						<font color="red"><?php echo $msg3;?></font>
         						</td>
					</tr>
					<tr>
						<td>Confirm Password:</td>
						<td>   <input type="password" size="40" id="password3" name="PASSWORD3" />
						
         	<font color="red"><?php echo $err_msg;?></font>
			<font color="red"><?php echo $err_msg1;?></font>
			<font color="red"><?php echo $err_msg7;?></font>
            
			<font color="red"><?php echo $error;?></font>					
						</td>
					</tr>
					
					 
					
					<tr>
						<td colspan="2" class="t-right"><input type="submit" name="SUBMIT" id="SUBMIT" class="input-submit" value="Submit"></td>
					</tr>
				</table>
				</form>				
		    </fieldset>
			</form>
		</div> <!-- /content -->

	

		
<?php
include "footer.php"; 
?>