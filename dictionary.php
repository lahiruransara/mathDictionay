<!doctype html>
<html lang="en">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Online Mathematics Word Dictionary</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
<?php 
	$search='';
	if (isset($_POST['search'])) {
		$search = $_POST['search'];
	}
?>

<h1>Search for a word to translate</h1>

<form action="index.php" method="post">
	<input type="text" name="search" value="<?php echo $search ?>" size="80">
	<input type="submit" name="" value="Search Word">

</form> 
</center> 
<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	echo "<h1 align='center'>Results</h1>"; 
	echo "<table width='600' align='center'>"; 
	echo "<tr><th>ID</th><th>Word</th><th>Definition</th></tr>"; 

	class TableRows extends RecursiveIteratorIterator{ 

		function _construct($it){ 
			parent::_construct($it, self::LEAVES_ONLY); 
		} 

		function current(){ 
			return "<td align='center'>". parent::current()."</td>"; 
		} 

		function beginChildren(){ 
			echo "<tr>"; 
		} 

		function endChildren(){
		 echo "</tr>" . "\n"; 
		} 
	} 

	$search=$_POST["search"]; 
	$servername = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname = "dic"; 
	$sql = "SELECT * FROM Word WHERE Word LIKE '%$search%';"; 

	try{ $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	$stmt = $conn ->prepare("$sql"); 
	$stmt-> execute(); //set the resulting array to associative 
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v){
		 echo $v; 
		} 
	} 

	catch(PDOException $e){
		 echo "Error:" . $e->getMessage(); 
		} 

	$conn = null; 
echo "</table>"; 
} 
?> 

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body> 


</html>