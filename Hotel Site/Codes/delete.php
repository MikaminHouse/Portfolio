<html>
    <head>
        <title>会員・予約・部屋削除処理ページ</title>
        <link href = "style.css" rel = "stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  利用者からの予約情報の削除処理  //
            if($_SESSION['delete_type'] == "gest_promise"){
                $query = "DELETE FROM hotel_appointment WHERE 予約番号 = '".$_SESSION['delete_number']."'";
                $result = mysqli_query($db, $query);
                //echo "予約情報を削除しました";
                header("Location:gest_promise_page.php");
            }
            //  利用者からの会員情報の削除処理  //
            if($_SESSION['delete_type'] == "gest_member"){
                $query = "DELETE FROM hotel_gest WHERE メールアドレス = '".$_SESSION['gest_email']."'";
                $result = mysqli_query($db, $query);
                //echo "会員情報を削除しました";
                require("logout.php");  //メールアドレスとパスワードのセッションを削除
                header("Location:index.php");  //ホームページに移動
            }
            //  管理者からの会員情報の削除処理  //
            if($_SESSION['delete_type'] == "all_member"){
                $query = "DELETE FROM hotel_gest WHERE 会員番号 = '".$_SESSION['delete_number']."'";
                $result = mysqli_query($db, $query);
                //echo "会員情報を削除しました";
                require("logout.php");  //メールアドレスとパスワードのセッションを削除
                header("Location:all_member_page.php");  //ホームページに移動
            }
            //  管理者からの予約情報の削除処理  //
            if($_SESSION['delete_type'] == "all_promise"){
                $query = "DELETE FROM hotel_appointment WHERE 予約番号 = '".$_SESSION['delete_number']."'";
                $result = mysqli_query($db, $query);
                //echo "会員情報を削除しました";
                header("Location:all_promise_page.php");  //ホームページに移動
            }
            //  管理者からの部屋情報の削除処理  //
            if($_SESSION['delete_type'] == "all_room"){
                $query = "DELETE FROM hotel_room WHERE 部屋番号 = '".$_SESSION['delete_number']."'";
                $result = mysqli_query($db, $query);
                //echo "会員情報を削除しました";
                header("Location:all_room_page.php");  //ホームページに移動
            }
            //  管理者からの部屋タイプ情報の削除処理  //
            if($_SESSION['delete_type'] == "all_roomtype"){
                $query = "DELETE FROM hotel_roomtype WHERE 部屋タイプ番号 = '".$_SESSION['delete_number']."'";
                $result = mysqli_query($db, $query);
                //echo "会員情報を削除しました";
                header("Location:all_room_page.php");  //ホームページに移動
            }
        ?>
    </body>
</html>
            