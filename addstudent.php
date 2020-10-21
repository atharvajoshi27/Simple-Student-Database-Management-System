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
$mis_and_email = 0;
$error = FALSE;
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
	  if (empty($_POST["name"]))
	   {
	   		
	   		$error = TRUE;
    		$nameerror = "Name is required";
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
 if (empty($_POST["branch"]))
  {
	   		
	    $error = TRUE;
        $brancherror = "Branch is required";
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

  if ($_POST["year"] == "")
  {
  	$error = TRUE;
    $yearerror = "Year is required";
  }
  else
  {

  		$year = $_POST["year"];
  } 

 if (empty($_POST["MIS"]))
  {
  	$error = TRUE;
    $miserror = "MIS is required";
  } 
  else
  {
    $mis = test_input($_POST["MIS"]);
   	$sql = "SELECT MIS FROM students WHERE MIS = '$mis'";
	$result = $conn->query($sql);
	if($result->num_rows == 1)
	{
		$failure = 'MIS ALREADY EXISTS';
		$mis_and_email = 1;
	}
  }

  if (empty($_POST["email"]))
  {
  	$error = TRUE;
    $emailerror = "Email is required";
  }
  else
  {
  		$email = test_input($_POST["email"]);
  		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
  		{
  			$error = TRUE;
  			$emailerror = "Invalid email format";
		}
		else
		{
			$sql = "SELECT EMAIL FROM students WHERE EMAIL = '$email'";
			$result = $conn->query($sql);
			if($result->num_rows == 1)
			{
				$failure = 'EMAIL ALREADY EXISTS';
				$mis_and_email = $mis_and_email + 1;
			}
		}

  }
  if($mis_and_email > 0)
	{	
		$nameerror = "";
		$miserror = "";
		$yearerror = "";
		$brancherror = "";
		$emailerror = "";
	}
  if($mis_and_email == 2)
  {
  	$failure = 'BOTH MIS AND EMAIL ALREADY EXIST';
  }
  
if(!$error && !isset($failure))
{
	$sql = "insert into students(NAME, MIS, YEAR, BRANCH, EMAIL) values('$name', '$mis', '$year', '$branch', '$email')";
	if(mysqli_query($conn, $sql))
	{
		$success = 'Added Successfully';
	}
}
}
?>
<div class = "container">
	<div style = "width : 500px; margin : 40px auto">

		<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<h2>Student Information</h2>
			<hr/>
			<?php
			if(!isset($failure) && isset($success))
			{
			 ?>
			 <div class = "alert alert-success">
			 	<span class = "glyphicon glyphicon-info-sign"></span>
			 	<?php echo $success; ?>
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
				<label for = "name" class = "control-label"><font size = 5px>Enter Name</font></label>
				<input type = "text" name = "name" class = "form-control">
				<span class = "text-danger"><?php if(isset($nameerror)) echo $nameerror;?></span>
			</div>
			<div class = "form-group">
				<label for = "MIS" class = "control-label"><font size = 5px>Enter MIS</font></label>
				<input type = "number" name = "MIS" class = "form-control" autocomplete = "off" MIN = 111600000 MAX = 112200000>
				<span class = "text-danger"><?php if(isset($miserror)) echo $miserror;?></span>
			</div>
			<div class = "form-group">
				<label for = "year" class = "control-label"><font size = 5px>Select Year</font></label>
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
				<label for = "Branch" class = "control-label"><font size = 5px>Enter Branch</font></label>
				<input type = "text" name = "branch" class = "form-control">
				<span class = "text-danger"><?php if(isset($brancherror)) echo $brancherror;?></span>
			</div>
			<div class = "form-group">
				<label for = "email" class = "control-label"><font size = 5px>Enter Email</font></label>
				<input type = "email" name = "email" class = "form-control">
				<span class = "text-danger"><?php if(isset($emailerror)) echo $emailerror;?></span>
			</div>
			<div class = "form-group">
				<center><input type = "submit" name = "ADD" value = "ADD" class = "btn btn-primary"></center>
			</div>
			<hr/>
			<a href = "student.html"><font size = "5px">Main Menu</font></a>
</form>
</body>
</html>