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
  $csrf = bin2hex(random_bytes(32));
  $_SESSION['login_csrf'] = $csrf;
// Load our environment variables from the .env file:
    
     $html='<form class="w-80  shadow-2xl rounded-2xl p-4" onsubmit="handleLogin(event)">
     <div>
     <label  for="email">Email</label>
     <input class="block w-full border-2 p-2 rounded-xl mt-2 mb-4" id="email" name="email" type="email"/>
     </div>
     <div>
     <label  for="password">Password</label>
     <input class="block w-full border-2 p-2 rounded-xl mt-2 mb-4" id="password" name="password" type="password"/>
     <input type="hidden" name="login_csrf" value="'.$csrf.'"/>
     </div>
     <button class="w-full p-2 border-2 rounded-xl bg-black text-white">Login</button>
     </form>';
     include "../container.php";
  ?>
<script src="/js/main.js"></script>
</body>
</html>