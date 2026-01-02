<?php
session_start();
 date_default_timezone_set("Asia/Kolkata"); // Set to your local timezone
 $currentTime = strtotime(date("H:i"));
//  echo $currentTime;
 $startTime = strtotime("00:00");
 $endTime = strtotime("23:30");
 $isWorkingHours = $currentTime >= $startTime && $currentTime <= $endTime ? true: false;
 
$isCsrfValid =
    isset($_POST['attendance_csrf'], $_SESSION['attendance_csrf']) &&
    hash_equals($_SESSION['attendance_csrf'], $_POST['attendance_csrf']);

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isWorkingHours && $isCsrfValid) {
    if (!isset($_SESSION['user']['id']) || !isset($_SESSION['user']['user_key'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
    };
    $userId = intval($_SESSION['user']['id']);
     
    $deviceInfo = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $attendanceDay = date("Y-m-d");
    $checkinTime = date("Y-m-d H:i:s");
 
$conn = new mysqli(
    "db.fr-pari1.bengt.wasmernet.com",
    "a890400970b4800092c62a05eeea",
    "0694a890-4009-71fc-8000-31acc0d66b54",
    "userfeedbacks",
    10272
);


    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => $conn->connect_error]);
         exit;
    }

    $stmt = $conn->prepare(
        "SELECT user_id FROM attendance WHERE user_id = ? AND attended_at = ?"
    );
    $stmt->bind_param("is", $userId, $attendanceDay);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "failure",
            "message" => "Attendance Marked Already"
        ]);
         exit;

    } else {
        $stmt = $conn->prepare(
        "INSERT INTO attendance 
        (user_id, attended_at, check_in_time, device_info)
        VALUES (?, ?, ?, ?)"
    );
        $stmt->bind_param("isss", $userId, $attendanceDay,$checkinTime,$deviceInfo);
        if($stmt->execute()){
            echo json_encode([
                "status" => "success",
                "message" => "Attendance Marked Successfully"
            ]);
            $_SESSION['user']['attendance'] = true;
             unset($_SESSION['attendance_csrf']);
            exit;

        }
        else{
                if ($stmt->errno) { // duplicate entry
                    echo json_encode([
                "status" => "success",
                "message" => "Duplicate Found"
            ]);
            exit;
    }   
        };
 
}
}
else{
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request"
    ]);
    exit;
}