<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "device-width, initial scale = 1">
    <link rel = "stylesheet" href = "assets/css/bootstrap.min.css">
    <title>Title</title>
</head>
<body style = "background-image : url('3.jpeg'); background-repeat : no-repeat; background-position : center;background-attachment: fixed;">
	<div class = "container">
	<div style = "width : 500px; margin : 40px auto">
		 <center>
		<table>
<?php 
include_once 'database.php';

$sql = "SELECT NAME, MIS, YEAR, BRANCH, EMAIL FROM students";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    echo "<table border = 2px>";
    while($row = $result->fetch_assoc()) {
        echo "<tr> <td>". $row["NAME"]."</td> ". " <td>". $row["MIS"]."</td>". "<td>" . $row["YEAR"] ."</td>". "<td>".$row["BRANCH"]."</td>". "<td>". $row["EMAIL"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
</table>
</center>
</div>
</div>
           <hr/>
           <center> <a href = "student.html"><font size = "5px">Main Menu</font></a></center>
</body>
</html>