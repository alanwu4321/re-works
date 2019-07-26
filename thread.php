<?php
include "dbConfig.php";
// print_r($_POST);
if (isset($_POST["comment"])) {
    $comment = "";
    $date = "";
    $s_Id = 0;
    $jobID = 0;

    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
    }
    if (isset($_POST['s_Id'])) {
        $s_Id = $_POST['s_Id'];
    }
    if (isset($_POST['jobID'])) {
        $jobID = $_POST['jobID'];
    }
    date_default_timezone_set('America/New_York');
    $date = date('Y-m-d h:i:s', time());
    $sql = "INSERT INTO SJ_Ranks (s_Id, jobID, note, date) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iiss",intval($s_Id), intval($jobID), $comment, $date);
    $stmt->execute();
    $res = ($stmt->affected_rows === 0) ? "error" : "success";
    header('Content-type: application/json');
    echo json_encode(['response' => $res]);
    $stmt->close();
}
