<?php
$user = $_POST['username'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

$file = fopen("users.txt", "a");
fwrite($file, "User: $user | PassHash: $pass\n");
fclose($file);

echo "Saved safely (hashed password)";
?>