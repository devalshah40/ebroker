<?php
ob_start(); 
include"header.php";
include("left.php");

switch($_GET['action'])
{
	case 'export_transaction':
		if($_GET['for'] == "vendor")
		{
		header("Location: csv.php?action=export_transaction&for=vendor&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		}
		else if($_GET['for'] == "pdfclient")
		{
		header("Location: pdf.php?action=export_transaction&for=pdfclient&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		}
		else 
		{
		header("Location: csv.php?action=export_transaction&for=client&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		}
		break;
	
	case 'pdf_vendor_transaction':
		header("Location: pdf.php?action=export_transaction&for=pdf_vendor_transaction&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
	case 'pdf_month_transaction':
		header("Location: pdf.php?action=export_transaction&for=pdf_month_transaction&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
	
	case 'export_payment':
		header("Location: csv.php?action=export_payment&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
		case 'pdf_client_payment':
		header("Location: pdf.php?action=export_payment&for=pdf_client_payment&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
	
	case 'export_month_payment':
		header("Location: csv.php?action=export_month_payment&for=month&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
	case 'pdf_month_payment':
		header("Location: pdf.php?action=export_payment&for=pdf_month_payment&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
	
	case 'export_month_transaction':
		header("Location: csv.php?action=export_month_transaction&for=month&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
	
	case 'export_quarter_transaction':
		header("Location: csv.php?action=export_quarter_transaction&for=quarter&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
	case 'pdf_quarter_transaction':
		header("Location: pdf.php?action=export_transaction&for=pdf_quarter_transaction&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
	case 'export_quarter_payment':
		header("Location: csv.php?action=export_quarter_payment&for=quarter&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
	case 'pdf_quarter_payment':
		header("Location: pdf.php?action=export_payment&for=pdf_quarter_payment&id=".mysql_real_escape_string($_GET['id']+'1'."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
	
	case 'export_year_transaction':
		header("Location: csv.php?action=export_year_transaction&for=year&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;	
		
	case 'pdf_year_transaction':
		header("Location: pdf.php?action=export_transaction&for=pdf_year_transaction&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
	
	case 'export_year_payment':
		header("Location: csv.php?action=export_year_payment&for=year&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
		
	case 'pdf_year_payment':
		header("Location: pdf.php?action=export_payment&for=pdf_year_payment&id=".mysql_real_escape_string($_GET['id']."&broker_id=".$_SESSION['login_id'].""));
		ob_end_flush();
		exit;
		break;
	
	
}
?>
<hr class="noscreen" />
		<form name="reportform" action="manage_reports.php" id="reportform" method="post" onsubmit="return formValidator(;">
			<head>
				<script type="text/javascript" src="js/manage_clients.js"></script>
				<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js">
				</script>
			</head>
		<!-- Content (Right Column) -->
		<div id="content" class="box">
			
			<!-- Table (TABLE) -->
			<h3 class="tit">Transactions Report</h3>
			<table width="30%">
				<tr>
				    <th width="50%">NAME</th>
				    <th width="25%">TOTAL AMOUNT</th>
				    <th width="25%">CSV</th>
				</tr>
				<?php
				if($_GET['action'] == "client")
				{
				 $sql="";
				 $sql = "SELECT * FROM `clients` where broker_id=".$_SESSION['login_id'];
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					$i++;
					$row1=mysql_fetch_row(mysql_query("SELECT SUM(`billing_amount`) FROM `transactions` WHERE client_id=".$row['0']." and broker_id=".$_SESSION['login_id']));
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $row['name'] ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_transaction&id=<?php echo $row['client_id'];?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=export_transaction&for=pdfclient&id=<?php echo $row['client_id'];?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }}
				else if($_GET['action'] == "vendor")
				{
				 $sql="";
				 $sql = "SELECT * FROM `vendors` where broker_id=".$_SESSION['login_id'];
				 $rs = mysql_query($sql);
				 $i=0;
					while($row = mysql_fetch_array($rs))
					{
						$i++;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`billing_amount`) FROM `transactions` WHERE vendor_id=".$row['0']." and broker_id=".$_SESSION['login_id']));
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $row['name'] ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_transaction&for=<?php echo $_GET['action'];?>&id=<?php echo $row['vendor_id'];?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_vendor_transaction&id=<?php echo $row['vendor_id'];?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }} 
				else if($_GET['action'] == "month")
				{
				$i=0;
				$month=array('January','February','March','April','May','June','July','August','September','October','November','December');
				foreach($month As $key => $value)
					{
						$i++;
						$key1=$key+1;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`billing_amount`) FROM transactions WHERE `broker_id` = ".$_SESSION['login_id']." and transaction_date between  '2012-".$key1."-01' and '2012-".$key1."-31'"));
				?> 
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $value; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_month_transaction&for=<?php echo $_GET['action'];?>&id=<?php echo $key;?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_month_transaction&id=<?php echo $key;?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }} 
				else if($_GET['action'] == "quarter")
				{
				$i=0;
				$month=array(0 => 'January-March',3 => 'April-June',6 => 'July-September',9 =>'October-December');
				foreach($month As $key => $value)
					{
						$i++;
						$key1=$key+1;
						$key2=$key+3;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`billing_amount`) FROM transactions WHERE `broker_id` = ".$_SESSION['login_id']." and transaction_date between  '2012-".$key1."-01' and '2012-".$key2."-31'"));
				?> 
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $value; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_quarter_transaction&for=<?php echo $_GET['action'];?>&id=<?php echo $key;?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_quarter_transaction&id=<?php echo $key;?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }}
				else if($_GET['action'] == "year")
				{
				$i=0;
				$month=array('2012');
				foreach($month As $key => $value)
					{
						$i++;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`billing_amount`) FROM transactions WHERE `broker_id` =  ".$_SESSION['login_id']." and transaction_date between  '2012-01-01' and '2012-12-31'"));
				?> 
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $value; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_year_transaction&for=<?php echo $_GET['action'];?>&id=<?php echo $key;?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_year_transaction&id=<?php  echo $key;?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }} ?>
			</table>
			
			
			<?php
				if($_GET['action'] == "client")
				{
			?>
			<h3 class="tit">Payment Report</h3>
			<table width="30%">
				<tr>
				    <th width="50%">NAME</th>
				    <th width="25%">TOTAL AMOUNT</th>
				    <th width="25%">CSV</th>
				</tr>
				<?php
				 $sql="";
				 $sql = "SELECT * FROM `clients` where broker_id=".$_SESSION['login_id'];
				 $rs = mysql_query($sql);
				 $i=0;
				while($row = mysql_fetch_array($rs))
				{
					$i++;
					$row1=mysql_fetch_row(mysql_query("SELECT SUM(`amount`) FROM `payments` WHERE client_id=".$row['0'].""));
				?>
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $row['name']; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_payment&id=<?php echo $row['client_id'];?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_client_payment&id=<?php echo $row['client_id'];?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }}
				else if($_GET['action'] == "month")
				{
				?>
				<h3 class="tit">Payment Report</h3>
				<table width="30%">
					<tr>
						<th width="50%">NAME</th>
						<th width="25%">TOTAL AMOUNT</th>
						<th width="25%">CSV</th>
					</tr>
				<?php
				$i=0;
				$month=array('January','February','March','April','May','June','July','August','September','October','November','December');
				foreach($month As $key => $value)
					{
						$i++;
						$key1=$key+1;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`amount`) FROM payments WHERE `broker_id` = ".$_SESSION['login_id']." and payment_date between  '2012-".$key1."-01' and '2012-".$key1."-31'"));
				?> 
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $value; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_month_payment&for=<?php echo $_GET['action'];?>&id=<?php echo $key;?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_month_payment&id=<?php echo $key;?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }}
				else if($_GET['action'] == "quarter")
				{
				?>
				<h3 class="tit">Payment Report</h3>
				<table width="30%">
					<tr>
						<th width="50%">NAME</th>
						<th width="25%">TOTAL AMOUNT</th>
						<th width="25%">CSV</th>
					</tr>
				<?php
				$i=0;
				$month=array(0 => 'January-March',3 => 'April-June',6 => 'July-September',9 =>'October-December');
				foreach($month As $key => $value)
					{
						$i++;
						$key1=$key+1;
						$key2=$key+3;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`amount`) FROM payments WHERE `broker_id` = ".$_SESSION['login_id']." and payment_date between  '2012-".$key1."-01' and '2012-".$key2."-31'"));
				?> 
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $value; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_quarter_payment&for=<?php echo $_GET['action'];?>&id=<?php echo $key;?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_quarter_payment&id=<?php echo $key;?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }} 
				
				else if($_GET['action'] == "year")
				{
				?>
				<h3 class="tit">Payment Report</h3>
				<table width="30%">
					<tr>
						<th width="50%">NAME</th>
						<th width="25%">TOTAL AMOUNT</th>
						<th width="25%">CSV</th>
					</tr>
				<?php
				$i=0;
				$month=array('2012');
				foreach($month As $key => $value)
					{
						$i++;
						$row1=mysql_fetch_row(mysql_query("SELECT SUM(`amount`) FROM payments WHERE `broker_id` = ".$_SESSION['login_id']." and payment_date between  '2012-01-01' and '2012-12-31'"));
				?> 
				<tr <?php if($i%2 == 0) echo "class=bg" ?>>  
				    <td><?php echo $value; ?></td>
				    <td><?php echo number_format($row1['0']) ?></td>
					<td><a href="manage_reports.php?action=export_year_payment&for=<?php echo $_GET['action'];?>&id=<?php echo $key;?>"><img src="img/xls.png" alt="report"></a>&nbsp;&nbsp;&nbsp;<a href="manage_reports.php?action=pdf_year_payment&id=<?php echo $key;?>"><img src="img/pdf.png" alt="pdf"></a>
					</td>	
				</tr>
				<?php }} ?> 
			</table>
		</div> <!-- /content -->
		
	</div> <!-- /cols -->
<?php
include "footer.php"; 
?>
	