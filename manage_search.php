<?php
include"header.php";
include("left.php");
include("include/paginator.class.php");
?>
<hr class="noscreen" />
		<?php 
			if($_GET['clients'] == "" && $_GET['transactions'] == "" && $_GET['greetings'] == "" && $_GET['tasks'] == "" && $_GET['vendors'] == "" && $_GET['payments'] == "") 
			{
				$set_all="display all";
			}
		?>
		<!-- Content (Right Column) -->
		<div id="content" class="box">
	<!-- Table (TABLE) -->
			<?php 
				if($set_all != "" || $_GET['clients'] != "")
				{
			?>
			<h3 class="tit">Clients</h3>
			<?php
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
				    <th width="18%">NAME</th>
				    <th width="18%">ADDRESS</th>
				    <th width="10%">YEAR</th>
				    <th width="10%">BROKERAGE</th>
				    <th width="14%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `clients` where broker_id=".$_SESSION['login_id']." and (name like '%$_GET[query_value]%' or address like '%$_GET[query_value]%') $pages->limit";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					$i++;
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>> 
				    <td><?php echo $row['name'] ?></td>
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
			<?php 
				if($set_all != "" || $_GET['vendors'] != "")
				{
			?>
			<h3 class="tit">Vendors</h3>
			<?php
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
				    <th width="25%">NAME</th>
				    <th width="15%">CONTACT NO</th>
				    <th width="35%">ADDRESS</th>
				    <th width="10%">YEAR</th>
				    <th width="50%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `vendors` where broker_id=".$_SESSION['login_id']." and (name like '%$_GET[query_value]%' or address like '%$_GET[query_value]%') $pages->limit";
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					$i++;
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $row['name'] ?></td>
				    <td><?php echo $row['contact_no'] ?></td>
				    <td><?php echo $row['address'] ?></td>
				    <td><?php echo $row['year'] ?></td>	 
					<td><a href="manage_vendors.php?action=edit&id=<?php echo $row['vendor_id'];?>"><img src="img/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;<a href="manage_vendors.php?action=delete&id=<?php echo $row['vendor_id'];?>"><img src="img/delete.png" alt="delete"></a></td>	
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
			<?php } ?>
			<?php 
				if($set_all != "" || $_GET['payments'] != "")
				{
			?>
			<h3 class="tit">Payments</h3>
			<?php
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
				    <th width="18%">CLIENT NAME</th>
					<th width="20%">DESCRIPTION</th>
				    <th width="14%">AMOUNT</th>
				    <th width="8%">MODE</th>
				    <th width="14%">PAYMENT DATE</th>
				    <th width="10%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `payments` where broker_id=".$_SESSION['login_id']." and (`desc` like '%$_GET[query_value]%'or `client_id` IN(SELECT `client_id` from `clients` where `name` LIKE '%$_GET[query_value]%')) $pages->limit";
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
			<?php 
				if($set_all != "" || $_GET['transactions'] != "")
				{
			?>
				<h3 class="tit">Transactions</h3>
			<?php
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
				 $sql = "SELECT * FROM `transactions` where broker_id=".$_SESSION['login_id']." and (`description` like '%$_GET[query_value]%'or `client_id` IN(SELECT `client_id` from `clients` where `name` LIKE '%$_GET[query_value]%')or `vendor_id` IN(SELECT `vendor_id` from `vendors` where `name` LIKE '%$_GET[query_value]%')) $pages->limit";
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
			<?php } ?>
			<?php 
				if($set_all != "" || $_GET['greetings'] != "")
				{
			?>
			<h3 class="tit">Greetings</h3>
			<?php
				?>
			<table width="70%">
				<tr>
				    <th width="18%">TITLE</th>
				    <th width="14%">ACTION</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM greetings where broker_id=".$_SESSION['login_id']." and (`greetings_title` like '%$_GET[query_value]%' or `greetings_details` like '%$_GET[query_value]%')";
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
			<?php } ?>
			
			<!-- Form -->
		</div> <!-- /content -->
	
	
	</div> <!-- /cols -->
<?php
include "footer.php"; 
?>