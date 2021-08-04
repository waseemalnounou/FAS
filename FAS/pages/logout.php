<?php
function unset_cookie($cookie_name) {
    if (isset($_COOKIE[$cookie_name])) {
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, null,"01 Jan 1970 00:00:01 GMT",'/');
    } else { return false; }
}
     function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
//logout.php
unset_cookie("FAS");
unset($_COOKIE["FAS"]);
session_start();
session_destroy();
Redirect('login.php', false);

?>
<script>

   
</script>