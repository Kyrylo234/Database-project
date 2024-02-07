<html>
<head>
	<meta charset = "utf-8">
  <link rel="stylesheet" type="text/css" href="styleSheet.css">
</head>


<body>
<ul>
  <li><a href="index.php">Home</a></li>
  <li><a class="active" href="add_row.php">Add data</a></li>
  <li><a href="delete_row.php">Delete data</a></li>
  <li><a href="edit_row.php">Edit & Update </a></li>
  
</ul>


<?php // connect.php allows connection to the database




  require_once 'connect.php'; //using require will include the connect.php file each time it is called.
  print<<<_HTML
  <form action=" " method="post">
 
   Book id:     <input type="number" name="id" value = ""> <br><br>
   Book title:  <input type="text" name="title" value = ""> <br><br>
   Author name: <input type="text" name="author" value = ""> <br><br>
   Genre: <input type="text" name="genre" value = ""> <br><br>
   Publish year:     <input type="number" name="book_year" value = ""> <br><br>
     
   <input type="submit" name = "submit" value="add record">
 
  </form>
_HTML;


  if(isset($_POST['submit'])){
     if (  strlen($_POST['id']) == 3 &&
           is_numeric($_POST['id']) &&
           isset($_POST['title']) &&
           strlen($_POST['title'] ) < 31 &&
           isset($_POST['author']) &&
           strlen($_POST['author'] ) < 21 &&
           isset($_POST['genre']) &&
           strlen($_POST['genre'] ) < 11 &&
           strlen($_POST['book_year']) == 4 &&
           $_POST['book_year'] < 2024 &&
           is_numeric($_POST['book_year']) 

		){
    $id     = assign_data($conn, 'id');
    $title  = assign_data($conn, 'title');
    $author = assign_data($conn, 'author');
    $genre = assign_data($conn, 'genre');
    $book_year = assign_data($conn, 'book_year');
    
    $query  = "SELECT * FROM BooksDatabase WHERE id = '$id'";
    $result = $conn->query($query);
    if ($result->num_rows>0){
      echo '<p>Error this id already exists</p>';
    }
    else{

  	$query    = "INSERT INTO BooksDatabase VALUES ('$id', '$title', '$author', '$genre', '$book_year')";
		
    $result   = $conn->query($query);
    if (!$result) echo "<br><br>INSERT failed: $query<br>" .
	
      $conn->error . "<br><br>";
    }
    }
    else{
      echo '<p>Error incorrect input</p>';
    }
  }
    




  
  
  function assign_data($conn, $var)
  {
  
    return $conn->real_escape_string($_POST[$var]);
  }
  
  
  $query  = "SELECT * FROM BooksDatabase";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;


print<<<_HTML
   <b>Here is your Books list</b>
   
   
   <table id = "book_table">
   <tr>
    <th>Book ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Genre</th>
		<th>Publish Year</th>
   </tr>
_HTML;

 
 	if ($result->num_rows >0)
			{
			echo "The books list:<br><br>";
			while($row = $result->fetch_assoc()) 
				{
						echo "<tr>";
						echo "<td>".$row["id"]."</td>";
						echo "<td>".$row["title"]."</td>";
						echo "<td>".$row["author"]."</td>";
            echo "<td>".$row["genre"]."</td>";
           	echo "<td>".$row["book_year"]."</td>";
						echo "</tr>";
				}
			} 
			else 
			{
				echo "0 results";
			}


print<<<_HTML
</table>
<br>
<a href="index.php" target="_self"> <p>Home</p></a> 
_HTML;
				
$result->close();
$conn->close(); 
?>
 
</body>	
</html>