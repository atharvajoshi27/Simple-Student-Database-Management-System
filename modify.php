<!--  style = "background-image : url('Student.png')" -->
<?php
include_once ('database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "device-width, initial scale = 1">
    <link rel = "stylesheet" href = "assets/css/bootstrap.min.css">
    <title>Title</title>
</head>
<body style = "background-image : url('3.jpeg'); background-repeat : no-repeat; background-position : center;background-attachment: fixed;">
<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$error = FALSE;
$count = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
	  if (empty($_POST["name"]))
	   {
	   		
	   		$count = $count + 1;
    		
       }
  	   else
  	   {
    		$name = test_input($_POST["name"]);
    		// check if name only contains letters and whitespace
    		if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
    		{
    			$error = TRUE;
     			$nameerror = "Only letters and white spaces are allowed";
  			}
  	    }
 if (empty($_POST["MIS"]))
  {
  	$count = $count + 1;
  	$error = TRUE;
    $miserror = "MIS is required";
  } 
  else
  {
    $mis = test_input($_POST["MIS"]);
    // check if e-mail address is well-formed
    if (!is_numeric($mis))
     {
     	$error = TRUE;
    	$miserror = "Invalid MIS";
   	 }
  }
  if (empty($_POST["NEWMIS"]))
  		{
  			$count = $count + 1;
  		}	 
  		else
  		{
    		$newmis = $_POST["NEWMIS"];
  		}
  if ($_POST["year"] == "")
  {
  
		$count = $count + 1;    
  }
  else
  {

  		$year = $_POST["year"];
  } 
  if (empty($_POST["email"]))
  {
  	$count = $count + 1;
  }
  else
  {
  		$email = test_input($_POST["email"]);
  		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  			$error = TRUE;
  		$emailerror = "Invalid email format";
		}

  }
  if (empty($_POST["branch"]))
	   {
	   		
	   		$count = $count + 1;
  	   }
  	   else
  	   {
    		$branch = test_input($_POST["branch"]);
    		// check if name only contains letters and whitespace
    		if (!preg_match("/^[a-zA-Z ]*$/",$branch)) 
    		{
    			$error = TRUE;
     			$brancherror = "Only letters and white spaces are allowed";
  			} 
  	    }
  	    if($count > 4) //Total 6 clolumns at least two must be given
		{
			$error = TRUE;
			$failure = 'Please enter at least two fields including MIS';
			if(isset($mis)) // When MIS is entered incorrectly and only one field is filled
				{
					$sql = "SELECT NAME FROM students WHERE MIS = '$mis'";
					$result = $conn->query($sql);
					if($result->num_rows == 0)
					{
						$failure = "PLEASE ENTER CORRECT MIS AND AT LEAST TWO FIELDS"; 
					}

					}
		}
if(!$error)
{
	echo 'entered';
	if(isset($mis))
	{
		$sql = "SELECT NAME FROM students WHERE MIS = '$mis'";
		$result = $conn->query($sql);
		if($result->num_rows == 0)
		{
			$failure = "MIS NOT FOUND";
		}

	}
	if(isset($name) && isset($mis))
	{
		$sql = " UPDATE students SET NAME = '$name' WHERE MIS = '$mis' ";
		if(mysqli_query($conn, $sql))
		{
			$success = 'Updated Successfully!';
		}

	}
	if(isset($year) && isset($mis))
	{
		$sql = " UPDATE students SET YEAR = '$year' WHERE MIS = '$mis' ";
		if(mysqli_query($conn, $sql))
		{
			$success = 'Updated Successfully!';
		}	
	}
	if(isset($branch) && isset($mis))
	{
		$sql = " UPDATE students SET BRANCH = '$branch' WHERE MIS = '$mis' ";
		if(mysqli_query($conn, $sql))
		{
			$success = 'Updated Successfully!';
		}	
	}
	if(isset($email) && isset($mis))
	{
		$sql = " UPDATE students SET EMAIL = '$email' WHERE MIS = '$mis' ";	
		if(mysqli_query($conn, $sql))
		{
			$success = 'Updated Successfully!';
		}
	}
	if(isset($newmis) && isset($mis))
	{
		$sql = " UPDATE students SET MIS = '$newmis' WHERE MIS = '$mis' ";	
		if(mysqli_query($conn, $sql))
		{
			$success = 'Updated Successfully!';
		}
	}
}
}
?>
<div class = "container">
	<div style = "width : 500px; margin : 40px auto">

		<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<br>
			<br>
			<h2>Student Information</h2>
			<hr/>
			<?php
			if(!isset($failure) && isset($success)) // If isset($)
			{
			 ?>
			 <div class = "alert alert-success">
			 	<span class = "glyphicon glyphicon-info-sign"></span>
			 	<?php echo $success;?>
			 </div>
			 <?php
			 }
			 ?>
			<?php
			if(isset($failure))
			{
			 ?>
			 <div class = "alert alert-danger">
			 	<span class = "glyphicon glyphicon-info-sign"></span>
			 	<?php echo $failure; ?>
			 </div>
			 <?php
			 }
			 ?>
			 <div class = "form-group">
				<label for = "MIS" class = "control-label"><font size = 5px>Enter MIS</font></label>
				<input type = "number" name = "MIS" class = "form-control" autocomplete = "off" MIN = 111600000 MAX = 112200000>
				<span class = "text-danger"><?php if(isset($miserror)) echo $miserror;?></span>
			</div>
			<div class = "form-group">
				<label for = "NEWMIS" class = "control-label"><font size = 5px>Update MIS</font></label>
				<input type = "number" name = "NEWMIS" class = "form-control" autocomplete = "off" MIN = 111600000 MAX = 112200000>
			</div>
			<div class = "form-group">
				<label for = "name" class = "control-label"><font size = 5px>Update Name</font></label>
				<input type = "text" name = "name" class = "form-control">
				<span class = "text-danger"><?php if(isset($nameerror)) echo $nameerror;?></span>
			</div>
			
			<div class = "form-group">
				<label for = "year" class = "control-label"><font size = 5px>Update Year</font></label>
				<select class = "form-control" name = "year">
					<option value = "FY BTECH">FY BTECH</option>
					<option value = "SY BTECH">SY BTECH</option>
					<option value = "TY BTECH">TY BTECH</option>
					<option value = "FINAL YEAR BTECH">FINAL YEAR BTECH</option>
					<option value = "FY MTECH">FY MTECH</option>
					<option value = "SY MTECH">SY MTECH</option>
					<option value = "" selected></option>
				</select>
				<span class = "text-danger"><?php if(isset($yearerror)) echo $yearerror;?></span>
			</div>
			<div class = "form-group">
				<label for = "Branch" class = "control-label"><font size = 5px>Update Branch</font></label>
				<input type = "text" name = "branch" class = "form-control">
				<span class = "text-danger"><?php if(isset($brancherror)) echo $brancherror;?></span>
			</div>
			<div class = "form-group">
				<label for = "email" class = "control-label"><font size = 5px>Update Email</font></label>
				<input type = "email" name = "email" class = "form-control">
				<span class = "text-danger"><?php if(isset($emailerror)) echo $emailerror;?></span>
			</div>
			<div class = "form-group">
				<center><input type = "submit" name = "UPDATE" value = "UPDATE" class = "btn btn-primary"></center>
			</div>
			<hr/>
			<a href = "student.html"><font size = "5px">Main Menu</font></a>
		</form>

</form>
</body>
</html>