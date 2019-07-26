<?php
include "dbConfig.php";
// print_r($_POST);
if (isset($_POST["username"]) || isset($_POST["password"])) {
    $username = "";
    $password = "";
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    // $stmt =  $mysqli->stmt_init();
    $sql = "SELECT * FROM User WHERE userName=? AND password=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    // print_r("Error: %s.\n", $stmt->error);
    if ($result->num_rows == 1) {
        $response = $result->fetch_all(MYSQLI_ASSOC);
        // print_r($response);
        $studentIDSQL = "SELECT s_Id FROM Student WHERE userId = ?";
        $intIDSQL = "SELECT i_Id FROM Interviewer WHERE userId = ?";
        $table = ($response[0]["type"] == "Student") ? $studentIDSQL : $intIDSQL;
        $typeIDmt = $mysqli->prepare($table);
        $typeIDmt->bind_param("i",$response[0]["userID"]);
        $typeIDmt->execute();
        $typeID = $typeIDmt->get_result()->fetch_assoc();
        $key = ($response[0]["type"] == "Student") ? "s_Id" : "i_Id";
        $cookieValue = $response[0]["userID"] . "," . $response[0]["type"] . "," . $response[0]["userName"] . "," . $response[0]["name"] . "," . $typeID[$key];
        setcookie("curUser", $cookieValue, time()+40000, "/"); 
        header('Content-type: application/json');
        echo json_encode(['response' => 'success', 'data' => $response]);
    }else{
        header('Content-type: application/json');
        echo json_encode(['response' => 'error']);
    }
}
?>


