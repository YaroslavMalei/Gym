<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="css/style1.css">
	<style>
		table,td {
			border: 1px solid #333333;
			border-collapse: collapse;
			padding:10px;

		}
	</style>
</head>
<body>
	<main>
		<article>
			<a href="index.php">Головне меню</a><br>
			<a href="user.php">Користувачі</a><br>
			<a href="gym.php">Абонементи</a><br>
			<a href="coach.php">Тренери</a>
		</article>

		<?php 
		$host = "localhost";
		$user = "root";
		$password = "";
		$database = "gym";

		$id = "";
		$employee_id = "";
		$text = "";
		$user_id = "";

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		// connect to mysql database
		try{
		$connect = mysqli_connect($host, $user, $password, $database);
	} catch (mysqli_sql_exception $ex) {
	echo 'Error';
}


function getPosts()
{
	$posts = array();
	$posts[0] = $_POST['id'];
	$posts[1] = $_POST['employee_id'];
	$posts[2] = $_POST['text'];
	$posts[1] = $_POST['user_id'];
	return $posts;
}


$sql = "SELECT * FROM comment ORDER BY 'ASC' LIMIT 10";

if (!$result = mysqli_query($connect, $sql)) {
echo "Вибачте, виникла помилка у роботі сайту.";
exit;
}
echo '<center> |';
	echo "<table>\n";
		echo "<thead><tr><th colspan = '4'>Відгуки</tr></th></thead>\n";
		while ($comment = $result->fetch_assoc()) {
		echo "<tr>\n";
			echo "<td>" . $comment['id'] . "</td><td>". $comment['employee_id'] . "</td><td>" . $comment['text'] . "</td><td>" .  $comment['user_id'] . "</td>";
		echo "</tr>";
	}
echo "</table>\n";
echo '</center>';
// Search
if(isset($_POST['search']))
{
	$data = getPosts();

	$search_Query = "SELECT * FROM comment WHERE id = $data[0]";

	$search_Result = mysqli_query($connect, $search_Query);

	if($search_Result)
	{
		if(mysqli_num_rows($search_Result))
		{
			while($row = mysqli_fetch_array($search_Result))
			{
				$id = $row['id'];
				$employee_id = $row['employee_id'];
				$text = $row['text'];
				$user_id = $row['user_id'];
			}
		}else{
		echo 'No Data For This Id';
	}
} else{
echo 'Result Error';
}
}



//Insert
if(isset($_POST['insert']))
{
	$data = getPosts();
	$insert_Query = "INSERT INTO `comment`(`employee_id`, `text`, `user_id`) VALUES ('$data[1]','$data[2]','$data[3]')";
	try{
	$insert_Result = mysqli_query($connect, $insert_Query);

	if($insert_Result)
	{
		if(mysqli_affected_rows($connect) > 0)
		{
			echo 'Data Inserted';
		}else{
		echo 'Data Not Inserted';
	}
}
} catch (Exception $ex) {
echo 'Error Insert '.$ex->getMessage();
}
}


// Delete
if(isset($_POST['delete']))
{
	$data = getPosts();
	$delete_Query = "DELETE FROM `comment` WHERE `id` = $data[0]";
	try{
	$delete_Result = mysqli_query($connect, $delete_Query);

	if($delete_Result)
	{
		if(mysqli_affected_rows($connect) > 0)
		{
			echo 'Data Deleted';
		}else{
		echo 'Data Not Deleted';
	}
}
} catch (Exception $ex) {
echo 'Error Delete '.$ex->getMessage();
}
}


// Edit
if(isset($_POST['update']))
{
	$data = getPosts();
	$update_Query = "UPDATE `comment` SET `employee_id`='$data[1]',`text`='$data[2]',`user_id`='$data[3]' WHERE `id` = $data[0]";
	try{
	$update_Result = mysqli_query($connect, $update_Query);

	if($update_Result)
	{
		if(mysqli_affected_rows($connect) > 0)
		{
			echo 'Data Updated';
		}else{
		echo 'Data Not Updated';
	}
}
} catch (Exception $ex) {
echo 'Error Update '.$ex->getMessage();
}
}



?>

<form action="coment.php" method="post"><br><br>
	<input type="number" name = "id" placeholder = "Id" value="<?php echo $id;?>"><br><br>
	<input type="number" name = "employee_id" placeholder = "Employee_id" value="<?php echo $employee_id;?>"><br><br>
	<input type="text" name = "text" placeholder = "Text" value="<?php echo $text;?>"><br><br>
	<input type="number" name = "user_id" placeholder = "User_id" value="<?php echo $user_id;?>"><br><br>

	<div>
		<input type="submit" name = "insert" value="Add">
		<input type="submit" name = "update" value="Update">
		<input type="submit" name = "delete" value="Delete">
		<input type="submit" name = "search" value="Search">
	</div>
</form>




</main>
</body>
</html>