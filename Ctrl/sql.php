<?php
#header("Content-type: text/html;charset=gbk");

$user = 'sa'; 
$password = '123123'; 
 
$dbh = new PDO("sqlsrv:Server=192.168.0.193,1433;Database=mssql1000y", $user , $password); //这行报错了
 
$stmt = $dbh->prepare("select * from account1000y");
$stmt->execute();
 
while ($row = $stmt->fetch()) {
      echo $row['account'].", ".$row['char1']."<br />";
}
 

unset($dbh);
unset($stmt);

exit;


$serverName = "192.168.0.193"; //serverName\instanceName
$connectionInfo = array( "Database"=>"mssql1000y", "UID"=>"sa", "PWD"=>"123123");
$conn = sqlsrv_connect( $serverName,$connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( var_dump( sqlsrv_errors(), true));
}

$sql = "SELECT * FROM dbo.account1000y";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


/*

  try {
    $hostname = "localhost";
    $port = 1433;
    $dbname = "mssql1000y";
    $username = "sa";
    $pw = "123123";
    $dbh = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }
  $stmt = $dbh->prepare("select name from master..sysdatabases where name = db_name()");
  $stmt->execute();
  while ($row = $stmt->fetch()) {
    print_r($row);
  }
  unset($dbh); unset($stmt);


/*
$conn = sqlsrv_connect('localhost', array('Database' => 'mssql1000y', 'UID' => 'sa' , 'PWD' => '123123'));
var_dump(sqlsrv_errors());
