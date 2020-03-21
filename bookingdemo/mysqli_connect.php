 <?php
 
 DEFINE('DB_USER', 'root');
 DEFINE('DB_PASSWORD', '');
 DEFINE('DB_HOST', 'localhost');
 DEFINE('DB_NAME', 'airlines');
 
 global $dbc;
 $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Προέκυψε κάποιο σφάλμα.  Ζητούμε συγγνώμη για την ενόχληση!' . mysqli_connect_error() );
 mysqli_set_charset($dbc,"utf8");
 
 ?>