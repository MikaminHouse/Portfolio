<!DOCTYPE html>
<html>
    <head>
        <title>ホームページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body id = "index_body">
        <?php
            //  ログインページに移動  //
            if($_GET['login']){
                header("Location:login_page.php");
            }
            //  部屋情報ページに移動  //
            if($_GET['room']){
                header("Location:room_page.php");
            }
        ?>
        <header>
            <h2>ホームページ</h2>
            <h2>ホテル予約サイト</h2>
            <form method = "GET">
                <input type = "submit" name = "login" value = "ログインページ">
                <input type = "submit" name = "room" value = "ルームページ">
            </form>
        </header>
    </body>
</html>