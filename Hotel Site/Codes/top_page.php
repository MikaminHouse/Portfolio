<!DOCTYPE html>
<html>
    <head>
        <title>ホームページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body id = "top_body">
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  ログアウト処理  //
            if($_GET['logout']){
                require("logout.php");
            }
            //  部屋情報ページに移動  //
            if($_GET['room']){
                $_SESSION['room_back'] = "room";
                header("Location:room_page.php");
            }
            //  予約情報ページに移動  //
            if($_GET['promise']){
                $_SESSION['room_back'] = "gest_promise";
                header("Location:gest_promise_page.php");
            }
            //  会員情報ページに移動  //
            if($_GET['member']){
                header("Location:update_member_page.php");
            }
            //  部屋一覧ページに移動  //
            if($_GET['all_room']){
                header("Location:all_room_page.php");
            }
            //  予約一覧ページに移動  //
            if($_GET['all_promise']){
                header("Location:all_promise_page.php");
            }
            //  会員一覧ページに移動  //
            if($_GET['all_member']){
                header("Location:all_member_page.php");
            }
        ?>
        <h2>トップページ</h2>
        <!-- <h2>ようこそ</h2> -->
        <?php
            if($_SESSION['gest_email']){
                echo '
                    <header>
                        <h2>利用者用</h2>
                        <form method = "GET">
                            <input type = "submit" name = "room" value = "部屋情報ページ">
                            <input type = "submit" name = "promise" value = "予約情報ページ">
                            <input type = "submit" name = "member" value = "会員情報ページ">
                        </form>
                        <form method = "GET" id = "logout_form">
                            <input type = "submit" name = "logout" value = "ログアウト">
                        </form>
                    </header>
                ';
            }
            if($_SESSION['host_email']){
                echo '
                    <header>
                        <h2>管理者用</h2>
                        <form method = "GET">
                            <input type = "submit" name = "all_room" value = "部屋一覧ページ">
                            <input type = "submit" name = "all_promise" value = "予約一覧ページ">
                            <input type = "submit" name = "all_member" value = "会員一覧ページ">
                        </form>
                        <form method = "GET" id = "logout_form">
                            <input type = "submit" name = "logout" value = "ログアウト">
                        </form>
                    </header>
                ';
            }
        ?>
    </body>
</html>