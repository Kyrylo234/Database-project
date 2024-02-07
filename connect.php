<?php
$hn='mysql';
$db = '23db292';
$un = '23usr292';
$pw = 'bvo9dsKTicix';

$conn = new mysqli($hn, $un,$pw,$db);

if ($conn->connect_error)
  { die($conn->connect_error);
  echo '<br>';
  echo 'Unfortunately you could not be connected to the database
        please check you have the correct credentials';
}
else 
{	
  echo '<br>';
  echo 'You have connected to the databse successfully <br><br>';
  
};

?>