<?php 
session_start();
include("include/config.php");

if(isset($_POST['SUBMIT']))
{
	if($_POST['email_id'] == "" && !isValidEmail($_POST['email_id']))
	{
		$msg="";
		$msg="Please enter a valid Email Id";
	}
	else
	{
			$_SESSION['email_id'] = $_POST['email_id'];
	}
}
 function isValidEmail($email)
{
 return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}
if(isset($_POST['SUBMIT']))
{
	$sql="";
	$sql = "SELECT * FROM broker WHERE email_id = '".mysql_real_escape_string($_POST['EMAIL_ID'])."';";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
		if($row['broker_id'] != '')
		{
					$to      = $row['email_id'];
					$subject = "Your New Password";
					$message = "Your Details.<br>
					Username : ".$row['username']."<br>
					Password : ".$row['password']."<br>
					";
					$headers = 'From: info@hrimtech.com' . "\r\n" .
					'Reply-To: info@hrimtech.com' . "\r\n" ;
					$headers  .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   					mail($to, $subject, $message, $headers);
					$_SESSION['check_mail']="Please Check Your Email";

			header("Location: login.php");
			exit;
		}
		else
		{
			$error="";
			$error="Please Enter Email Id";
		}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
	<title>Kalp Traders Login</title>
		<link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" /> <!-- RESET -->
		<link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" /> <!-- MAIN STYLE SHEET -->
		<link rel="stylesheet" media="screen,projection" type="text/css" href="css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
		<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
		<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
		<link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" /> <!-- GRAPHIC THEME -->
		<link rel="stylesheet" media="screen,projection" type="text/css" href="css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
		<link href="css/forgot_password.css" type="text/css" rel="stylesheet" />	
	 <script type="text/javascript" src="js/forgot_password.js">
	 </script>
   </head>
<body>
    <div id="login-container">
        <div id="logo">
            <span>
                <img src="tmp/logo.gif" />
            </span>
        </div>
		<form name="LOGIN" id="login" action="forgot_password.php" method="post" onsubmit="return formValidator();">
		
		<?php if($error != "" || $err != "" ) { ?>
		<div id="warning">
            <p class="msg1 error">
                <img  class="img1" alt="icon_delete"  src="design/ico-delete.gif" />
                <label class="lbl1"><?php echo $error; ?></label>
            </p>
        </div>
		<?php } ?>
		
		<?php if($err_msg != "" ) { ?>
		<div id="done">
			<p class="msg1 done">
                <img  class="img1" alt="icon_delete"  src="design/ico-done.gif" />
                <label class="lbl1"><?php echo $err_msg; ?></label>
			</p>
        </div>
		<?php } ?>	
       
        <div id="indication">
            <p class="msg1 info">
                  <img alt="info" class="img1" class="style1" src="design/ico-info.gif" />
                <label class="lbl1">Enter Your Email Id.</label>
            </p>
        </div>
		 <div id="form1">
            <label class="">Email Id:</label>
            <input type="text" size="40" id="email_id" name="EMAIL_ID" />
			<font color="red"><label><?php echo $msg; ?></label></font>
        </div>
        <div style="clear:both; height:8px;"></div>
		<div id="form3">
                 <input type="submit" name="SUBMIT" class="submit" value="Check" />
        </div>
        <div style="clear:both; height:8px;"></div>
		</form>
    </div>
</body>
</html>
