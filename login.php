<?php 
session_start();
include("include/config.php");

if(isset($_POST['SUBMIT']))
{
	if($_POST['USERNAME'] == "")
	{
		$msg="";
		$msg="Please enter a valid username";
	}
	else
	{
			$_SESSION['USERNAME'] = $_POST['USERNAME'];
	}
}
if(isset($_POST['SUBMIT']))
{
	$sql="";
	$sql = "SELECT * FROM broker WHERE username = '".mysql_real_escape_string($_POST['USERNAME'])."' AND password = '".mysql_real_escape_string($_POST['PASSWORD'])."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
		if($row['broker_id'] != '')
		{
			$_SESSION['logged_in'] = "yes";
			$_SESSION['login_id'] = $row['broker_id'];
			$_SESSION['email_id']=$row['email_id'];
			$_SESSION['date_format']=$row['date_format'];
			header("Location: index.php");
			exit;
		}
		else
		{
			$error="";
			$error="Please Enter Name and Password";
			$_SESSION['check_mail']="";
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
		<link href="css/newlogin.css" type="text/css" rel="stylesheet" />	
	 <script type="text/javascript" src="js/login.js">
	 </script>
   </head>
<body>
    <div id="login-container">
        <div id="logo">
            <span>
                <img src="tmp/logo.gif" />
            </span>
        </div>
		<form name="LOGIN" id="login"action="login.php" method="post" onsubmit="return formValidator();">
		<?php if($error != "") { ?>
        <div id="warning">
            <p class="msg1 error">
                <img  class="img1"alt="icon_delete"  src="design/ico-delete.gif" />
                <label class="lbl1">The Password You have entered is incorrect. </label>
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
		<?php }else if($_SESSION['check_mail'] != ""){ ?>	
		<div id="done">
			<p class="msg1 done">
                <img  class="img1" alt="icon_delete"  src="design/ico-done.gif" />
                <label class="lbl1"><?php echo $_SESSION['check_mail']; ?></label>
			</p>
        </div>
		<?php } ?>
		
        <div id="indication">
            <p class="msg1 info">
                  <img alt="info" class="img1" class="style1" src="design/ico-info.gif" />
                <label class="lbl1">Enter your Username
                and Password.</label>
            </p>
        </div>
        <div id="form">
            <label class="">Username:</label>
            <input type="text" size="40" id="username" name="USERNAME" />
			<font color="red"><?php echo $msg; ?></font>
        </div>
        <div style="clear:both; height:8px;"></div>
        <div id="form1">
            <label class="">Password:</label>
            <input type="password" size="40" id="password" name="PASSWORD" />
         </div>
         <div style="clear:both; height:8px;"></div>
        
         <div id="form2">
               <input  class="chkbox" name="rememberme" value="" id="rememberme" type="checkbox">
                 &nbsp;<label class="">Remember Me</label>
                 <a href="forgot_password.php" id="A2" name="forgot_password">Forgot Password?</a>
          </div>
           <div style="clear:both; height:8px;"></div>
        
          <div id="form3">
                 <input type="submit" name="SUBMIT" class="submit" value="LOGIN" />
          </div>
           <div style="clear:both; height:8px;"></div>
		   </form>
    </div>
    
</body>
</html>
