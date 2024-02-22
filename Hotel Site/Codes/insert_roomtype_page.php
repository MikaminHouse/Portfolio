<!DOCTYPE html>
<html>
    <head>
        <title>ホームページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            if($_GET['insert']){
                $_SESSION['insert_type'] = "all_roomtype";
                require("insert.php");
            }
            //  ホームページに移動  //
            if($_GET['back']){
                //  会員一覧ページに移動  //
                if($_SESSION['host_email']){
                    header("Location:all_room_page.php");
                }
                //  ログインページに移動  //
                else{
                    header("Location:login_page.php");
                }
            }
        ?>
        <h2>部屋タイプ登録ページ</h2>
        <form method = "GET">
            <label for = "name">部屋タイプ名</label>
            <input type = "text" name = "name">
            <br>
            <label for = "number">最大宿泊人数</label>
            <input type = "text" name = "number">
            <br>
            <input type = "submit" name = "insert" value = "登録する">
        </form>
        <form method = "GET" class = "back_form">
            <?php
                if($_SESSION['host_email']){
                    echo '<input type = "submit" name = "back" value = "部屋一覧ページに戻る">';
                }
                //  ホームページに移動  //
                else{
                    echo '<input type = "submit" name = "back" value = "ログインページに戻る">';
                }
            ?>
            
        </form>    
    </body>
</html>