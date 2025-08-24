<?php
echo "Hello from Railway!";
echo "<br>PHP Version: " . phpversion();
echo "<br>Current Time: " . date('Y-m-d H:i:s');
echo "<br>Environment: " . ($_ENV['APP_ENV'] ?? 'not set');
?>
