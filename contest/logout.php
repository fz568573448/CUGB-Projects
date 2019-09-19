<?php
    session_start();
    $FLAGGG=false;
    if (isset($_SESSION['department'])) $FLAGGG=true;
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
    session_destroy();
    if ($FLAGGG) echo '<script type="text/javascript">window.location.href="./admin.php"</script>';
    else echo '<script type="text/javascript">window.location.href="."</script>';
 ?>
