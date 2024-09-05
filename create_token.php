<?php

session_start();
header('Content-Type: application/json; charset=utf-8');

include 'conn.php';
#echo "OK";



if( isset( $_POST['user'] ) &&  strlen( $_POST['user'] ))
{
    #echo "Valid INPUT";
}
else
{
  //error either $_POST['login'] is not set or $_POST['login'] is empty form field
    echo "Invalid INPUT<br>";
}
#check user

$user=pg_escape_string($_POST['user']);
$pwd=pg_escape_string($_POST['pwd']);

#echo $user ."<br>";

$query0="SELECT password FROM public.users WHERE username=$1";

$result0 = pg_prepare($conn_api, "my_query0", $query0);
$result0 = pg_execute($conn_api, "my_query0", array($user));
#echo $result. "<br>";
#echo $query;
#exit;
while($r0 = pg_fetch_assoc($result0)) {
    $pwd_db=$r0['password'];
}

if (password_verify($pwd,$pwd_db)==1) {
    # creo il token
    $insert_query="INSERT INTO public.session
    (username, user_token, token_expire)
    VALUES($1, substr(md5(random()::text), 0, 15) , now() + interval '30 minutes');";
    $result1 = pg_prepare($conn_api, "my_query1", $insert_query);
    $result1 = pg_execute($conn_api, "my_query1", array($user));

    $select_token= "SELECT user_token FROM public.session WHERE username=$1 order by token_expire desc limit 1;";
    $result2 = pg_prepare($conn_api, "my_query2", $select_token);
    $result2 = pg_execute($conn_api, "my_query2", array($user));

    print json_encode(array_values(pg_fetch_all($result2)));
	


} else {
    echo "ERROR: check user credential;";
}
pg_close($conn_api);
?>