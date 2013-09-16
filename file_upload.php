<?php
include("header.php");
include("left.php");

if(!empty($_POST)){
	
// 	echo "<pre>"; 
// 	print_r($_POST);
// 	print_r($_FILES);
// 	exit;

	
	$target_path = "uploads/";
	$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
	$file_path   = $_FILES['uploadedfile']['tmp_name'];
	if(file_exists($target_path)){
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			echo "The file ".  basename( $_FILES['uploadedfile']['name']).
			" has been uploaded";
		} else{
			echo "There was an error uploading the file, please try again!";
		}
	}	
}else{
	
	
}
?>
	<hr class="noscreen" />
		<form name="VENDORFORM" action="" id="vendorform" method="post" enctype="multipart/form-data">

				<fieldset>
				<legend>File upload</legend>
				<table class="nostyle">
					<tr>
						<td style="width:70px;">Name:</td>
						<td>
							<input type="file" name="uploadedfile" id="uploadedfile" class="input-text"  />
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
			</form>

<?php
include "footer.php";
?>