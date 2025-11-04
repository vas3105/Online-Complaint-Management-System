<?php
// hash_generator.php
$passwordToHash = 'password123';
$hash = password_hash($passwordToHash, PASSWORD_DEFAULT);

echo "<h3>Your new password hash is:</h3>";
echo "<p>Please copy this entire line of 60 characters:</p>";
echo "<pre>" . $hash . "</pre>";
echo "<p>Length: " . strlen($hash) . "</p>";
?>