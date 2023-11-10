<?php 

    $db = pg_connect("host=10.161.33.97 port=5432 dbname=jc_arulraj user=postgres password=ROOT");
//    $db = pg_connect("host=10.20.21.50 port=5432 dbname=jc user=postgres password=ROOT");
 //  $db = pg_connect("host=localhost port=5432 dbname=jcnew user=map_rgi password=Orgi@1121");


$admin_table = "admin_login";
$support_maill = "support@gmail.com";
$databaseinfo = array(
    'user' => 'postgres',
    'pass' => 'ROOT',
    'db'   => 'jc_arulraj',
    'host' => '10.161.33.97'
);

// $databaseinfo = array(
//     'user' => 'map_rgi',
//     'pass' => 'Orgi@1121',
//     'db'   => 'jcnew',
//     'host' => '10.20.21.49'
// );
// echo "$db".$db;
// exit();

?>