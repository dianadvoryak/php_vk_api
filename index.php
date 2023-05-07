<?php

header('Content-type: json/application');
require 'connect.php';
require 'function.php';

$query = pg_query($connect, "
        CREATE TABLE IF NOT EXISTS statistics (
        id SERIAL PRIMARY KEY,
        ip CHARACTER VARYING(30),
        event CHARACTER VARYING(30),
        auth boolean,
        date timestamp
    )
");

// $addData = pg_query($connect, "
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'error', '0', '2023-04-01');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'abort', '0', '2023-04-02');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'load', '0', '2023-04-03');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'online', '0', '2023-04-04');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'open', '0', '2023-04-04');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'focus', '0', '2023-04-04');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'copy', '0', '2023-04-05');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'keydown', '0', '2023-04-05');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'click', '0', '2023-04-05');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'mousemove', '0', '2023-04-05');
//     INSERT INTO statistics (ip, event, auth, date) values('127.0.0.1', 'drag', '0', '2023-04-06');

//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'error', '1', '2023-04-07');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'abort', '1', '2023-04-08');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'load', '1', '2023-04-01');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'online', '1', '2023-04-01');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'open', '1', '2023-04-02');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'focus', '1', '2023-04-02');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'copy', '1', '2023-04-12');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'keydown', '1', '2023-04-12');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'click', '1', '2023-04-12');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'mousemove', '1', '2023-04-09');
//     INSERT INTO statistics (ip, event, auth, date) values('153.0.0.2', 'drag', '1', '2023-04-09');

//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'error', '1', '2023-04-01');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'abort', '1', '2023-04-02');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'load', '1', '2023-04-03');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'online', '1', '2023-04-04');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'open', '0', '2023-04-05');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'focus', '0', '2023-04-05');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'copy', '0', '2023-04-06');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'keydown', '0', '2023-04-07');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'click', '0', '2023-04-07');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'mousemove', '0', '2023-04-08');
//     INSERT INTO statistics (ip, event, auth, date) values('164.0.0.3', 'drag', '0', '2023-04-08');
// ");


// $query = pg_query($connect, '
//     DROP TABLE statistics;
// ');

// $query = pg_query($connect, '
// DELETE FROM statistics;
// ');
// die();

// $query = pg_query($connect, '
//     SELECT * FROM statistics;
// ');
// $res = pg_query($connect, "SELECT * FROM statistics;");
//   $i = pg_num_fields($res);
//   for ($j = 0; $j < $i; $j++) {
//       echo "column $j<br>";
//       $fieldname = pg_field_name($res, $j);
//       echo "fieldname: $fieldname<br>";
//       echo "printed length: " . pg_field_prtlen($res, $fieldname) . " characters<br>";
//       echo "storage length: " . pg_field_size($res, $j) . " bytes<br>";
//       echo "field type: " . pg_field_type($res, $j) . " <br><br>";
//   }
// var_dump($query);



$method = $_SERVER['REQUEST_METHOD'];


$q = $_GET['q'];

$params = explode('/', $q);

$type = $params[0];

if($method === 'GET'){
    if($type === 'filter'){
    
        if(isset($_GET['date']) & isset($_GET['event']) & isset($_GET['ip'])){
            filter_on_date_event_ip($connect, $_GET['date'], $_GET['event'], $_GET['ip']);
            
        } elseif (isset($_GET['date']) & isset($_GET['event'])){
            filter_on_date_event($connect, $_GET['date'], $_GET['event']);

        } elseif (isset($_GET['event'])){
            filter_on_event($connect, $_GET['event']);

        } elseif (isset($_GET['date'])){
            filter_on_date($connect, $_GET['date']);

        } else {
            echo 'incorrect parameters in url';
        }
    
    } elseif($type === 'allstat'){
        getAll($connect);
    } else {

    }

} elseif($method === 'POST'){
    if($type == 'addevent'){
        addEvent($connect, $_POST); // in post consist event & auth 
    }
}




// column 0
// fieldname: id
// printed length: characters
// storage length: 4 bytes
// field type: int4 

// column 1
// fieldname: ip
// printed length: characters
// storage length: -1 bytes
// field type: varchar 

// column 2
// fieldname: event
// printed length: characters
// storage length: -1 bytes
// field type: varchar 

// column 3
// fieldname: auth
// printed length: characters
// storage length: 1 bytes
// field type: bool 

// column 4
// fieldname: date
// printed length: characters
// storage length: 8 bytes
// field type: timestamp 
