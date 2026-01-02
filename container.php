<?php
$isAdminLoggedIn=isset($_SESSION['admin_id'])?'<form method="POST" action="/logout.php">
<button type="submit" class="bg-black text-white px-4 py-2 rounded-xl">Logout</button>
</form>':null;
$html;
echo '
<nav class="mx-auto max-w-200 p-4 flex   justify-between w-full items-center rounded-lg">
<span class="text-3xl">User Feedback</span>'.$isAdminLoggedIn.'

</nav>
<div class="mx-auto max-w-200 p-4 grid place-items-center">

'
.$html.
'</div>'
?>