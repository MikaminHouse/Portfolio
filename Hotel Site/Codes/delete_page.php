<html>
    <head>
        <title>会員・予約・部屋削除ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  削除処理  //
            if($_GET['ok']){
                require("delete.php");
            }
            //  対応したページに戻る  //
            if($_GET['no']){
                //  会員情報ページに移動  //
                if($_SESSION['delete_type'] == "gest_member"){
                    header("Location:gest_member_page.php");
                }
                //  予約情報ページに移動
                if($_SESSION['delete_type'] == "gest_promise"){
                    header("Location:gest_promise_page.php");
                }
                //  会員一覧ページに移動  //
                if($_SESSION['delete_type'] == "all_member"){
                    header("Location:all_member_page.php");
                }
                //  予約一覧ページに移動  //
                if($_SESSION['delete_type'] == "all_promise"){
                    header("Location:all_promise_page.php");
                }            
                //  部屋一覧ページに移動  //
                if($_SESSION['delete_type'] == "all_room" || $_SESSION['delete_type'] == "all_roomtype"){
                    header("Location:all_room_page.php");
                }          
            }
        ?>
        <h2>削除確認ページ</h2>
        <p class = "error_text">削除してもよろしいですか？※「はい」を押すと会員情報が削除され、「いいえ」を押すと前のページに戻ります</p>
        <form>
            <input type = "submit" name = "ok" value = "はい">
            <input type = "submit" name = "no" value = "いいえ">
        </form>
    </body>
</html>
            
