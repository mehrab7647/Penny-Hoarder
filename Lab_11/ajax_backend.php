<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}

$username = "";
// TODO 5a: Get the username field from the incoming request.
$username= $_GET['username'];

if (strlen($username) > 0) {

    // Connect to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);

        // Query to get the last login detail for the user
        $query = "SELECT Loggers.username, Logins.login_time FROM Loggers INNER JOIN Logins on (Loggers.user_id = Logins.user_id) WHERE Loggers.username = '$username' ORDER BY Logins.login_time DESC LIMIT 3;";
        $result = $db->query($query);

        // Create an empty array
        $jsonArray = array();

        // TODO 5b: Loop the '$result' variable to store each row in the '$jsonArray' array.
        if ($result){
            foreach($result as $row)
            {
                $jsonArray[] = array(
                    "username" => $row["username"],
                    "login_time" => $row["login_time"]
                    );
            }
        }


        // TODO 5c: Encode the array into a JSON object and send it back to the client as a response.
        $json = json_encode($jsonArray);
        echo $json;
        \end{code}


        // Close the database connection
        $db = null;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
