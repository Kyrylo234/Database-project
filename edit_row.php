<html>
<head>
	<meta charset = "utf-8">
  <link rel="stylesheet" type="text/css" href="styleSheet.css">
</head>


<body>
<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="add_row.php">Add data</a></li>
  <li><a href="delete_row.php">Delete data</a></li>
  <li><a class="active" href="edit_row.php">Edit & Update </a></li>
  
</ul>


<?php // connect.php allows connection to the database




  require_once 'connect.php'; //using require will include the connect.php file each time it is called.
  print<<<_HTML
  <form action=" " method="post">
   Select what you want to change:     <select name="selected">
        <option value=" ">Select an option</option>
        <option value="id">Book id</option>
        <option value="title">Book title</option>
        <option value="author">Author</option>
        <option value="genre">Genre</option>
        <option value="book_year">Year Published</option>
    </select>
    <br><br>
   Book id:     <input type="number" name="id" value = ""> <br><br>
   What to change to:     <input type="text" name="new_input" value = ""> <br><br>
   <input type="submit" name = "submit" value="edit record">
 
  </form>
_HTML;


  if(isset($_POST['submit'])){
    $pass = false;
    if($_POST['selected'] == ' '){
        echo '<p>Select one of the options</p>';
    }
    else{
    if($_POST['selected'] == 'id'){
        if(strlen($_POST['new_input']) == 3 &&
        is_numeric($_POST['new_input'])){
            $pass = true;
        }
    }
    if($_POST['selected'] == 'title'){
        if(isset($_POST['new_input']) &&
            strlen($_POST['new_input']) < 31){
            $pass = true;
        }
    }
    if($_POST['selected'] == 'author'){
        if(isset($_POST['new_input']) &&
            strlen($_POST['new_input']) <21){
            $pass = true;
        }
    }
    if($_POST['selected'] == 'genre'){
        if(isset($_POST['new_input']) &&
            strlen($_POST['new_input']) <11){
            $pass = true;
        }
    }
    if($_POST['selected'] == 'book_year'){
        if(strlen($_POST['new_input']) == 4 &&
        $_POST['new_input'] < 2024 &&
        is_numeric($_POST['new_input'])){
            $pass = true;
        }
    }
    if (strlen($_POST['id']) == 3 &&
        is_numeric($_POST['id']) &&
        $pass == true
		){
      
      $id     = assign_data($conn, 'id');
      $selected = assign_data($conn, 'selected');
      $new_input = assign_data($conn, 'new_input');
    
      $query  = "SELECT * FROM BooksDatabase WHERE id = '$id'";
      $result = $conn->query($query);
      if ($result->num_rows<1){
        echo '<p>Error this id does not exist</p>';
      }
      else{
        // No validation is performed so far
        $query    = "UPDATE BooksDatabase SET $selected = '$new_input' WHERE id = '$id'";
        
        $result   = $conn->query($query);
        if (!$result) echo "<br><br>INSERT failed: $query<br>" .
      
          $conn->error . "<br><br>";
        }
      }
      else{
        echo '<p>Error incorrect input</p>';
      }
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