<!DOCTYPE html>
<html>
    <head>
        <title>ログインページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
        ?>
        <?php
            if($_SESSION['gest_email']){
                unset($_SESSION['gest_email']);
                unset($_SESSION['gest_pass']); 
            }
            if($_SESSION['host_email']){
                unset($_SESSION['host_email']);
                unset($_SESSION['host_pass']);
            }
            header("Location:index.php");
        ?>
    </body>
</html>