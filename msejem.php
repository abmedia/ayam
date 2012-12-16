<?php
$conn =  mssql_connect('server', 'usuario', 'pass');
$mssql_select_db('dn', $conn);
$query = mssql_query();
:

?>

