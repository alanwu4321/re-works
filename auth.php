<?php
include "dbConfig.php";

if (isset($_POST["username"]) || isset($_POST["password"])) {
    $username = "";
    $password = "";
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    //User Validation
    $sql = "SELECT * FROM User WHERE userName=? AND password=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $response = $result->fetch_all(MYSQLI_ASSOC);

        //Get the typeID after User validation
        $studentIDSQL = "SELECT s_Id FROM Student WHERE userId = ?";
        $intIDSQL = "SELECT i_Id FROM Interviewer WHERE userId = ?";
        $table = ($response[0]["type"] == "Student") ? $studentIDSQL : $intIDSQL;
        $typeIDmt = $mysqli->prepare($table);
        $typeIDmt->bind_param("i",$response[0]["userID"]);
        $typeIDmt->execute();
        $typeID = $typeIDmt->get_result()->fetch_assoc();

        //Set Cookies 
        $key = ($response[0]["type"] == "Student") ? "s_Id" : "i_Id";
        $cookieValue = $response[0]["userID"] . "," . $response[0]["type"] . "," . $response[0]["userName"] . "," . $response[0]["name"] . "," . $typeID[$key];
        setcookie("curUser", $cookieValue, time()+40000, "/"); 

        //Set JSON response back to JS script
        header('Content-type: application/json');
        echo json_encode(['response' => 'success', 'data' => $response]);
    }else{
        header('Content-type: application/json');
        echo json_encode(['response' => 'error']);
    }
}
