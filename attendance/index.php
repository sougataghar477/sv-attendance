<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHP App</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

  <h1>PHP Server Running</h1>

  <?php
   
 date_default_timezone_set("Asia/Kolkata"); // Set to your local timezone
 $currentTime = strtotime(date("H:i"));
 $startTime = strtotime("00:00");
 $endTime = strtotime("23:30");
 $isWorkingHours = $currentTime>=$startTime && $currentTime<=$endTime?true:false;
 $deviceInfo = $_SERVER['HTTP_USER_AGENT'];
  $isLoggedIn =isset($_SESSION['user']);
  $role = $isLoggedIn ? $_SESSION['user']['role']:null;
  $userkey = $isLoggedIn ? $_SESSION['user']['user_key']:null;
  $attendanceMarkedOnce = $isLoggedIn? $_SESSION['user']['attendance']:false;
  echo $attendanceMarkedOnce;
    if($isLoggedIn && $userkey){
        if (!isset($_SESSION['attendance_csrf'])) {
            $_SESSION['attendance_csrf'] = bin2hex(random_bytes(32));
}
        if($isWorkingHours){
            $html = !$attendanceMarkedOnce
    ? '<form class="w-80 shadow-2xl rounded-2xl p-4" onsubmit="handleAttendance(event)">
          <input type="hidden" name="attendance_csrf" value="' . trim(htmlspecialchars($_SESSION['attendance_csrf'])) . '">
          <button class="w-full p-2 border-2 rounded-xl bg-black text-white">
              Mark Attendance
          </button>
       </form>'
    : '<h1>Attendance Marked Successfully</h1>';

        }
        else{
            $html='<h1>You missed the time window to mark attendance.</h1>';
        }
    }
    else{
        if($isWorkingHours){
            $html='<h1><a href="/login">Please Log In To Mark Attendance</a></h1>';
        }
        else{
            $html = '<div>
                <h1>You missed the time window</h1>
            </div>';
        }
    }
         
    include "../container.php";
    
  ?>
<script src="/js/main.js"></script>
</body>
</html>