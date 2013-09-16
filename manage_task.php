<?php
include"header.php";
include("left.php");

switch($_GET['action'])
{
	case 'edit':
			$edit_rec=mysql_fetch_array(mysql_query("SELECT * FROM task WHERE task_id = ".mysql_real_escape_string($_GET['id']).";"));
			$frm_action="update";
			break;
			
	case 'update': 
	
			 $sql="UPDATE `task` SET
			`title`= '".mysql_real_escape_string($_POST['TITLE'])."',
			`details`= '".mysql_real_escape_string($_POST['DETAILS'])."',
			`type`= '".mysql_real_escape_string($_POST['TYPE'])."',
			`start date`= '".mysql_real_escape_string($_POST['START_DATE'])."',
            `end date`= '".mysql_real_escape_string($_POST['END_DATE'])."'			
			WHERE `task_id` = ".mysql_real_escape_string($_POST['task_id']).";";
			mysql_query($sql);
			if(mysql_affected_rows() > 0)
			{
				$err_msg = "Task Updated Successfully.";
			}
			$frm_action = "add";
			break;

	case 'delete':
			mysql_query("DELETE FROM task WHERE task_id = ".mysql_real_escape_string($_GET['id'])."");
			if(mysql_affected_rows() > 0)
			{
				$err_msg = "Payment Deleted Successfully.";
			}
			$frm_action = "add";
	    	break;
	
	case 'add':
			if(isset($_POST['SUBMIT']) && ($check_double_insert == ""))
			{
				if($_POST['TITLE'] == "")
				{
					$msg2="Please Enter Title";
				}
				else
				{
						$_SESSION['TITLE'] = $_POST['TITLE'];
				}
				if($_POST['editor1'] == "")
				{
					$msg3="Please Enter Your Details";
				}
				else
				{
				         
						$_SESSION['DETAILS'] = $_POST['editor1'];
				}
				if($_POST['TYPE'] == "")
				{
					$msg4="Please Enter Type";
				}
				else
				{
						$_SESSION['TYPE'] = $_POST['TYPE'];
				}
				if($_POST['START_DATE'] == "")
				{
					$msg5="Please Start Date";
				}
				else
				{
						$_SESSION['START_DATE'] = $_POST['START_DATE'];
				}
				if(($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == ""))
				{
				//$sql = "INSERT INTO `kalptraders`.`task` (`task_id`, `broker_id`, `title`, `details`, `type`, `start date`, `end date`) VALUES (\'2\', \'1\', \'sdha\', \'hgvhg\', \'hgv\', \'2012-03-21\', \'2012-03-28\');";)

				if( get_magic_quotes_gpc())
				
				 {
				    $posted = htmlentities(stripslashes($_POST['editor1'])) ; 
					}
					else
					{
					$posted = htmlentities($_POST['editor1']) ; 
					
					}
					$sql="";
					$sql = "INSERT INTO `task` (`broker_id`,`title`, `details`, `type`, `start date`, `end date`) VALUES ('".$_SESSION['login_id']."','".mysql_real_escape_string($_SESSION['TITLE'])."','".$posted."','".mysql_real_escape_string($_POST['TYPE'])."','".mysql_real_escape_string($_POST['START_DATE'])."','".mysql_real_escape_string($_POST['END_DATE'])."');";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['TITLE']="";
						$_SESSION['DETAILS']="";
						$_SESSION['TYPE']="";
						$_SESSION['START_DATE']="";
						$_SESSION['END_DATE']="";
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
					    $_SESSION['TITLE']="";
						$_SESSION['DETAILS']="";
						$_SESSION['TYPE']="";
						$_SESSION['START_DATE']="";
						$_SESSION['END_DATE']="";
			}
			$frm_action="add";
			break;
			
	case 'view':
			if(isset($_POST['SUBMIT']) && ($check_double_insert == ""))
			{
			
				
				if($_POST['TITLE'] == "")
				{
					$msg2="Please Enter Title";
				}
				else
				{
						$_SESSION['TITLE'] = $_POST['TITLE'];
				}
				if($_POST['DETAILS'] == "")
				{
					$msg3="Please Enter Your Details";
				}
				else
				{
						$_SESSION['DETAILS'] = $_POST['DETAILS'];
				}
				if($_POST['TYPE'] == "")
				{
					$msg4="Please Select Your Type";
				}
				else
				{
						$_SESSION['TYPE'] = $_POST['TYPE'];
				}
				if($_POST['START_DATE'] == "")
				{
					$msg5="Please Enter Start Date";
				}
				else
				{
						$_SESSION['START_DATE'] = $_POST['START_DATE'];
				}
				if(($msg2 == "") && ($msg3 == "") && ($msg4 == "")&& ($msg5 == ""))
				{
					$sql="";
					 $sql = "INSERT INTO `task` (`title`, `details`, `type`, `start date`, `end date`) VALUES ('".mysql_real_escape_string($_SESSION['TITLE'])."','".mysql_real_escape_string($_POST['DETAILS'])."','".mysql_real_escape_string($_POST['TYPE'])."','".mysql_real_escape_string($_POST['START_DATE'])."','".mysql_real_escape_string($_POST['END_DATE'])."','".mysql_real_escape_string($_POST['PAYMENT_DATE'])."');";
					if(!mysql_query($sql))
					{
						$err = "Rows Not Inserted.";
					}
					else
					{
						$_SESSION['TITLE']="";
						$_SESSION['DETAILS']="";
						$_SESSION['TYPE']="";
						$_SESSION['START_DATE']="";
						$_SESSION['END_DATE']="";
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
					    $_SESSION['TITLE']="";
						$_SESSION['DETAILS']="";
						$_SESSION['TYPE']="";
						$_SESSION['START_DATE']="";
						$_SESSION['END_DATE']="";
			}
			$frm_action="view";
			break;
	default:
			            $_SESSION['TITLE']="";
						$_SESSION['DETAILS']="";
						$_SESSION['TYPE']="";
						$_SESSION['START_DATE']="";
						$_SESSION['END_DATE']="";
			$frm_action="add";
			break;
}
	
?>
	<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">

<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
	
			<!-- Form -->
			<h3 class="tit">Manage Tasks</h3>
			<?php
				include("include/paginator.class.php");
				$query = "SELECT COUNT('broker_id') FROM task";
				$result = mysql_query($query) or die(mysql_error());
				$num_rows = mysql_fetch_row($result);

				$pages = new Paginator;
				$pages->items_total = $num_rows[0];
				$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
				$pages->paginate();
				?>
			<table  width="80%">
				<tr>
				    <th width="16%">TITLE</th>
					<th width="17%">DETAILS</th>
				    <th width="12%">TYPE</th>
				    <th width="15%">START DATE</th>
				    <th width="14%">END DATE</th>
				    <th width="10%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `task` where broker_id=".$_SESSION['login_id'];
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					 $i++;
					 $sql="";
					 $sql = "SELECT * FROM `task` WHERE `broker_id = ".$_SESSION['login_id'];
					 $rs2= mysql_query($sql);
					 $row2=mysql_fetch_row($rs2);
				?>
				     <tr <?php if($i%2 == 0) echo "class=bg" ?>>      
				    <td><?php echo $row['title'] ?></td>
				    <td charoff="2"><?php echo html_entity_decode(stripslashes($row['details'])); ?></td>
				    <td><?php echo $row['type'] ?></td>
				    <td><?php echo $row['start date'] ?></td>	
					 <td><?php echo $row['end date'] ?></td>
				    <td><a href="manage_task.php?action=edit&id=<?php echo $row['task_id']; ?>"  ><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;<a href="manage_task.php?action=delete&id=<?php echo $row['task_id']; ?>" onclick="return confirmation()" ><img src="img/delete.png" alt="delete"></a></td>	
				</tr>
				<?php } ?>
			<tr>
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
		

			<!-- Form -->
			
			<?php if($error != "" || $err != "" ) { ?>
			<p class="msg error"><?php echo $error; ?></p>
			<?php } ?>
			
			<?php if($err_msg != "" ) { ?>
			<p class="msg done"><?php echo $err_msg; ?></p>
			<?php } ?>
			
			<p class="msg info">Enter Your Task Details.</p>
			
			<form name="TASKFORM" action="manage_task.php?action=<?php echo $frm_action; ?>" id="taskform" method="post" onsubmit="return formValidator();">
				<input type="hidden" name="task_id" value="<?php echo $edit_rec['task_id'];?>" />
				<head>
					<script type="text/javascript" src="js/manage_task.js"></script>
					<script src="js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
					<link href="css/datepicker.css" rel="stylesheet" type="text/css" />
					<script type="text/javascript"> 
<!-- js
              function showMe (it, box) { 
			  var vis = (box.checked) ? "block" : "none"; 
			  var vis = (box.unchecked) ? "none" : "block";
			  document.getElementById(it).style.display = vis;
} 


//--> 
</script>
				</head>
			<div id="content" class="box">

			
				<legend>Task Information</legend>
				<table class="nostyle">
				
					<tr>
						<td style="width:70px;">Title:</td>
						<td><input type="text" size="40" name="TITLE"  id="title" class="input-text" value="<?php  if($edit_rec['title']!=""){ echo $edit_rec['title']; } else {  echo $_SESSION['TITLE']; } ?>" />
							   	   <font color="red"><?php echo $msg2;?></font>
						</td>
					</tr>
					<tr>
						<td style="width:70px;"  class="va-top">Details:</td>
						<td><textarea class="ckeditor" name="editor1"  id="details" > <?php  if($edit_rec['details']!=""){ echo $edit_rec['details']; } else {  echo $_SESSION['DETAILS']; }?> </textarea>
							<font color="red"><?php echo $msg3;?></font>
						</td>
					</tr>	

                    

					
					
					<tr>
						<td  class="va-top">Type:</td>
						<td>
						
							
					<input type="radio" name="TYPE" id="oneday" value="oneday" 
					onClick="document.getElementById('div2').style.visibility='visible',document.TASKFORM.END_DATE.disabled=true;" > oneday
								 
						
					<input type="radio" name="TYPE" id="Multipledays" value="Multipledays" 
					onClick="document.getElementById('div2').style.visibility='visible',document.TASKFORM.END_DATE.disabled=false;"> Multipledays 
						<font color="red"><?php echo $msg4;?></font>
						</td>
					</tr>
					<tr>
				<td>
				<?php echo $edit_rec; ?>
				</td>
				</tr>
					<tr>
						<td  class="va-top">Start Date:</td>
						<td>
							<input type="text" size="40"  id="startdate"  name="START_DATE" maxlength="12" class="input-text" value="<?php if($edit_rec['start date']!=""){ echo $edit_rec['start date']; } else { echo $_SESSION['START_DATE']; } ?>" />
							<script>
									datePickerController.createDatePicker({ 
									// Associate the text input to a DD/MM/YYYY date format                            
									formElements:{"startdate":"%Y/%m/%d"}
									}); 
							</script> 
							 <font color="red"><?php echo $msg5;?></font>
						</td>
					</tr>
					<div id="div2">
					
					<tr>
						<td  class="va-top">End Date:</td>
						<td>
							<input type="text" size="40" id="enddate"  name="END_DATE"  maxlength="12" class="input-text" value="<?php if($edit_rec['end date']!=""){ echo $edit_rec['end date']; } else { echo $_SESSION['END_DATE']; } ?>" />
							<script>
									datePickerController.createDatePicker({ 
									// Associate the text input to a DD/MM/YYYY date format                            
									formElements:{"enddate":"%Y/%m/%d"}
									}); 
							</script> 
							 <font color="red"><?php echo $msg6;?></font>
						</td>
					</tr>
					</div>
					<tr>
						<td></td>
						<td class="t-left">
							<input type="submit" name="SUBMIT" id="SUBMIT" class="input-submit" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" name="CANCEL" id="CANCEL" class="input-submit" value="Cancel">
						</td>
					</tr>
			</table>
		</div> <!-- /content -->
		</form>

	</div> <!-- /cols -->
<?php
include "footer.php"; 
?>