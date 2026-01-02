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
$isAdminLoggedIn =
    isset($_SESSION['user'], $_SESSION['user']['role'], $_SESSION['user']['user_key'])
    && $_SESSION['user']['role'] === "admin";

if ($isAdminLoggedIn) {

    if (!isset($_SESSION['admin_csrf'])) {
        $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
    }

    $conn = new mysqli(
        "db.fr-pari1.bengt.wasmernet.com",
        "a890400970b4800092c62a05eeea",
        "0694a890-4009-71fc-8000-31acc0d66b54",
        "userfeedbacks",
        10272
    );

    if ($conn->connect_error) {
        $html = "<h1>Database connection failed</h1>";
    } else {

        $result = $conn->query(
            "SELECT user_id, attended_at, check_in_time, device_info FROM attendance"
        );

        if ($result && $result->num_rows > 0) {

            $attendances = '';

            while ($row = $result->fetch_assoc()) {
                $attendances .= '
                <tr>
                    <td>' . $row['user_id'] . '</td>
                    <td>' . $row['attended_at'] . '</td>
                    <td>' . $row['check_in_time'] . '</td>
                    <td>' . $row['device_info'] . '</td>
                </tr>';
            }

            $html = '
            <form>
            
            </form>
            <table class="border w-full mt-4 text-center">
                <tr class="bg-gray-200">
                    <th>User ID</th>
                    <th>Attended At</th>
                    <th>Check In Time</th>
                    <th>Device Info</th>
                </tr>
                ' . $attendances . '
            </table>';

        } else {
            $html = '<h1>0 Results</h1>';
        }
    }
}
else{
  $html ='<h1>Please Login as Admin</h1>';
}
include "../container.php";
?>

<script src="/js/main.js"></script>
</body>
</html>
