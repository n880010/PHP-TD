<?php
$cookie_name = "chocolat";
$cookie_value = "noir_70%";
$cookie_duration = time() + 2 * 3600;

if (isset($_COOKIE[$cookie_name])) {
    echo "Cookie '$cookie_name' présent : " . $_COOKIE[$cookie_name];
} else {
    setcookie($cookie_name, $cookie_value, $cookie_duration, "/");
    echo "Création cookie '$cookie_name'";
}
?>
