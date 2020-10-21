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
<body  style = "background-image : url('3.jpeg'); background-repeat : no-repeat; background-position : center;background-attachment: fixed;">
<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {

 		if(empty($_POST['email']) && empty($_POST['MIS']))
 		{
 			$failure = 'PLEASE ENTER AT LEAST ONE FIELD';
 		}
 		if(empty($_POST['email']) && !empty($_POST['MIS']))
 		{
 			$mis = $_POST['MIS'];
 			$sql = "SELECT MIS FROM students WHERE MIS = '$mis'";
			$result = $conn->query($sql);
			if($result->num_rows == 0)
			{
				$failure = 'MIS DOES NOT EXIST';
			}
			else
			{
	 			$sql = " DELETE FROM students WHERE MIS = '$mis' ";
				if(mysqli_query($conn, $sql))
				{
				$success = 'REMOVED SUCCESSFULLY';
				}
			}
 		}

 		if(!empty($_POST['email']) && empty($_POST['MIS']))
 		{
  				$email = test_input($_POST["email"]);
  				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  				{
  					$failure = "INVALID EMAIL FORMAT";
				}
				else
				{
					$sql = "SELECT EMAIL FROM students WHERE EMAIL = '$email'";
					$result = $conn->query($sql);
					if($result->num_rows == 0)
					{
						$failure = 'EMAIL ID DOES NOT EXIST';
					}
					else
					{
			 			$sql = " DELETE FROM students WHERE EMAIL = '$email' ";
						if(mysqli_query($conn, $sql))
						{
						$success = 'REMOVED SUCCESSFULLY';
						}
					}
				}

 		}

  		if(!empty($_POST['email'] && !empty($_POST['MIS'])))
  		{
  			$mis = $_POST['MIS'];
  			$email = test_input($_POST["email"]);
  			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  			{
  					$failure = "INVALID EMAIL FORMAT";
			}
			else
			{
				$sql = "SELECT MIS FROM students WHERE MIS = '$mis' AND EMAIL = '$email'";
				$result = $conn->query($sql);
				if($result->num_rows == 1)
				{
						$sql = "DELETE FROM students WHERE MIS = '$mis'";
						if(mysqli_query($conn, $sql))
						{
							$success = 'REMOVED SUCCESSFULLY';
						}
				}
				if($result->num_rows == 0)
				{
					$failure = 'MIS AND EMAIL DOES NOT BELONG TO SAME PERSON';
				}

			}
  		}

}

 ?>	
<div class = "container">
	
	<div style = "width : 500px; margin : 40px auto">
		
		<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
			<h2>Student Information</h2>
			<hr/>
			<?php
			if(isset($success))
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
				<label for = "MIS"  class = "control-label"><font size = 5px>Enter MIS</font></label>
				<input type = "number" name = "MIS" class = "form-control" MIN = 111600000 MAX = 112200000>
			</div>

			<div class = "form-group">
				<center><label for = "OR"  class = "control-label"><font size = 5px><u><b>OR</b></u></font></label></center>
			</div>

			<div class = "form-group">
				<label for = "email"  class = "control-label"><font size = 5px>Enter Email</font></label>
				<input type = "email" name = "email" class = "form-control">
			</div>

			<div class = "form-group">
				<center><input type = "submit" name = "REMOVE" value = "REMOVE" class = "btn btn-primary"></center>
			</div>

			<hr/>
			
			<a href = "student.html"><font size = "5px">Main Menu</font></a>
		
		</form>
	
	</div>

</div>

</body>

</html>