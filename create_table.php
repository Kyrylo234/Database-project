<?php //login.php
	require 'connect.php'; //using require will include the connect.php file each time it is called.
			
	$query = " CREATE TABLE BooksDatabase (
			   id  INT(3) UNSIGNED NOT NULL PRIMARY KEY, 
			   title VARCHAR (30) NOT NULL,
               author VARCHAR(20) NOT NULL,   
			   genre VARCHAR(10) NOT NULL,
			   book_year INT(4) UNSIGNED NOT NULL           
			   )";
	
	$result = $conn->query($query);
	
	if (!$result) 
	{
		die($conn->error);
		echo '<br> Your Query failed';
	} 
	else
	{
		echo '<br> Your table has been created';
	}

	$conn->close();	
?>