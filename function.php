<?php

function addEvent($connect, $data){
    $ip = $_SERVER["REMOTE_ADDR"];
    $event = $data['event'];
    $auth = $data['auth'];
    $now = date('Y-m-d');
    $ip = '127.0.0.7';

    $result = pg_prepare($connect, "query", "insert into statistics (ip, event, auth, date) values($1, $2, $3, $4);");
    $result = pg_execute($connect, "query", [$ip, $event, $auth, $now]);

    http_response_code(201);

    $res = [
        'result_status' => pg_result_status($result),
    ];

    echo json_encode($res);
}

function getAll($connect){
    $result = pg_query($connect, 'select * from statistics');
    if (!$result) {
        echo 'Ошибка при выполнении запроса: ' . pg_result_error($result);
        exit;
    }
    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_assoc($result)) {
            echo json_encode($row);
        }
    }
}

function filter_on_date_event_ip($connect, $date, $event, $ip){
    $json = [];

    $specificEventCounters = pg_prepare($connect, "query1", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2
    ");
    $specificEventCounters = pg_execute($connect, "query1", [$date, $event]);
    if (pg_num_rows($specificEventCounters) > 0) {
        $specificEventCounters = pg_fetch_assoc($specificEventCounters);
        $json['specific event counters'] = $specificEventCounters;
    }

    $eventCountersByIP = pg_prepare($connect, "query2", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2 and 
    ip = $3
    ");
    $eventCountersByIP = pg_execute($connect, "query2", [$date, $event, $ip]);
    if (pg_num_rows($eventCountersByIP) > 0) {
        $eventCountersByIP = pg_fetch_assoc($eventCountersByIP);
        $json['event counters by IP'] = $eventCountersByIP;
    }

    $eventCounterNotAuth = pg_prepare($connect, "query3", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2 and 
    auth = 'f'
    ");
    $eventCounterNotAuth = pg_execute($connect, "query3", [$date, $event]);
    if (pg_num_rows($eventCounterNotAuth) > 0) {
        $eventCounterNotAuth = pg_fetch_assoc($eventCounterNotAuth);
        $json['event counter by authorize user'] = $eventCounterNotAuth;
    }

    $eventCounterAuth = pg_prepare($connect, "query4", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2 and 
    auth = 't'
    ");
    $eventCounterAuth = pg_execute($connect, "query4", [$date, $event]);
    if (pg_num_rows($eventCounterAuth) > 0) {
        $eventCounterAuth = pg_fetch_assoc($eventCounterAuth);
        $json['event counter by not authorize user'] = $eventCounterAuth;
    }

    print_r(json_encode($json));

}


function filter_on_date_event($connect, $date, $event){
    $json = [];

    $specificEventCounters = pg_prepare($connect, "query5", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2
    ");
    $specificEventCounters = pg_execute($connect, "query5", [$date, $event]);
    if (pg_num_rows($specificEventCounters) > 0) {
        $specificEventCounters = pg_fetch_assoc($specificEventCounters);
        $json['specific event counters'] = $specificEventCounters;
    }

    $eventCounterNotAuth = pg_prepare($connect, "query6", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2 and 
    auth = 'f'
    ");
    $eventCounterNotAuth = pg_execute($connect, "query6", [$date, $event]);
    if (pg_num_rows($eventCounterNotAuth) > 0) {
        $eventCounterNotAuth = pg_fetch_assoc($eventCounterNotAuth);
        $json['event counter by authorize user'] = $eventCounterNotAuth;
    }

    $eventCounterAuth = pg_prepare($connect, "query7", "
    select count(*) from statistics where 
    date = $1 and 
    event = $2 and 
    auth = 't'
    ");
    $eventCounterAuth = pg_execute($connect, "query7", [$date, $event]);
    if (pg_num_rows($eventCounterAuth) > 0) {
        $eventCounterAuth = pg_fetch_assoc($eventCounterAuth);
        $json['event counter by not authorize user'] = $eventCounterAuth;
    }

    print_r(json_encode($json));

}

function filter_on_event($connect, $event){
    $json = [];

    $specificEventCounters = pg_prepare($connect, "query8", "
    select count(*) from statistics where 
    event = $1
    ");
    $specificEventCounters = pg_execute($connect, "query8", [$event]);
    if (pg_num_rows($specificEventCounters) > 0) {
        $specificEventCounters = pg_fetch_assoc($specificEventCounters);
        $json['specific event counters'] = $specificEventCounters;
    }

    $eventCounterNotAuth = pg_prepare($connect, "query9", "
    select count(*) from statistics where 
    event = $1 and 
    auth = 'f'
    ");
    $eventCounterNotAuth = pg_execute($connect, "query9", [$event]);
    if (pg_num_rows($eventCounterNotAuth) > 0) {
        $eventCounterNotAuth = pg_fetch_assoc($eventCounterNotAuth);
        $json['event counter by authorize user'] = $eventCounterNotAuth;
    }

    $eventCounterAuth = pg_prepare($connect, "query10", "
    select count(*) from statistics where 
    event = $1 and 
    auth = 't'
    ");
    $eventCounterAuth = pg_execute($connect, "query10", [$event]);
    if (pg_num_rows($eventCounterAuth) > 0) {
        $eventCounterAuth = pg_fetch_assoc($eventCounterAuth);
        $json['event counter by not authorize user'] = $eventCounterAuth;
    }

    print_r(json_encode($json));

}

function filter_on_date($connect, $date){
    $json = [];

    $specificEventCounters = pg_prepare($connect, "query11", "
    select count(*) from statistics where 
    date = $1
    ");
    $specificEventCounters = pg_execute($connect, "query11", [$date]);
    if (pg_num_rows($specificEventCounters) > 0) {
        $specificEventCounters = pg_fetch_assoc($specificEventCounters);
        $json['specific event counters'] = $specificEventCounters;
    }

    $eventCounterNotAuth = pg_prepare($connect, "query12", "
    select count(*) from statistics where 
    date = $1 and 
    auth = 'f'
    ");
    $eventCounterNotAuth = pg_execute($connect, "query12", [$date]);
    if (pg_num_rows($eventCounterNotAuth) > 0) {
        $eventCounterNotAuth = pg_fetch_assoc($eventCounterNotAuth);
        $json['event counter by authorize user'] = $eventCounterNotAuth;
    }

    $eventCounterAuth = pg_prepare($connect, "query13", "
    select count(*) from statistics where 
    date = $1 and 
    auth = 't'
    ");
    $eventCounterAuth = pg_execute($connect, "query13", [$date]);
    if (pg_num_rows($eventCounterAuth) > 0) {
        $eventCounterAuth = pg_fetch_assoc($eventCounterAuth);
        $json['event counter by not authorize user'] = $eventCounterAuth;
    }

    print_r(json_encode($json));
}

