<?php

function input_check($input) {
    return $_POST[$input] ?? null;
}

function get_in_server():void {
    $user = input_check("user");
    $pass = input_check("pass");
    $username = input_check("username");
    if (is_null($user) or is_null($pass)) {
        echo "You can not enter user or pass.<br>";
        die();
    }
    try {
        $connect = mysqli_connect("localhost:3306", "root", "");
    } catch (mysqli_sql_exception $exception) {
        echo $exception->getMessage();
        exit();
    }
    mysqli_select_db($connect,"switch");
    $query = "select * from configs";
    $result = mysqli_query($connect, $query);
    if ($configs = (mysqli_fetch_all($result))) {
        foreach ($configs as $config_data) {
            if ($config_data[3] == $username) {
                $data = [
                    "username" => $config_data[3],
                    "ip" => $config_data[1],
                    "port" => $config_data[2],
                    "datetime" => $config_data[4],
                ];
                echo json_encode($data) . "\n";
                die();
            }
        }
        echo "Username not found.<br>";
    } else {
        die();
    }
}

function get_list_server():void {
    $user = input_check("user");
    $pass = input_check("pass");
    if (is_null($user) or is_null($pass)) {
        echo "You can not enter user or pass.<br>";
        die();
    }
    try {
        $connect = mysqli_connect("localhost:3306", "root", "");
    } catch (mysqli_sql_exception $exception) {
        echo $exception->getMessage();
        exit();
    }
    mysqli_select_db($connect, "switch");
    $query = "select * from configs";
    $result = mysqli_query($connect, $query);
    if ($configs = (mysqli_fetch_all($result))) {
        echo "{";
        foreach ($configs as $config_data) {
            echo "$config_data[0] : ";
                $data = [
                    "username" => $config_data[3],
                    "ip" => $config_data[1],
                    "port" => $config_data[2],
                    "datetime" => $config_data[4],
                ];
                echo json_encode($data) . "\n";
                echo ",";
        }
        echo "}";
    } else {
        die();
    }
}

function send_to_server() {
    $ip = input_check("ip");
    $port = input_check("port");
    $username = input_check("username");
    $datetime = input_check("datetime");
    if (is_null($ip) or is_null($port) or is_null($username) or is_null($datetime)) {
        echo "You must enter all fields.<br>";
        echo "You cannot leave them blank.<br>";
        die();
    }
    try {
        $connect = mysqli_connect("localhost:3306", "root", "");
    } catch (mysqli_sql_exception $exception) {
        echo $exception->getMessage();
        exit();
    }
    mysqli_select_db($connect, "switch");
    $statment = mysqli_prepare($connect,"insert into configs (ip , port , username , datetime) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($statment , "sssi", $ip , $port , $username , $datetime);
    if (mysqli_stmt_execute($statment)) {
        $result = true;
    } else {
        echo "error : " . mysqli_error($connect);
        $result = false;
    }
    mysqli_close($connect);
    return $result;
}

function select_mode($mode): void {
    if ($mode == "send_to_server") {
        send_to_server();
    } elseif ($mode == "get_in_server") {
        get_in_server();
    } elseif ($mode == "get_list_server") {
        get_list_server();
    } else {
        echo "nothing";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    var_dump($_SERVER);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mode = input_check("mode");
    select_mode($mode);
}

