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
                $_SESSION['insert_type'] = "all_room";
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
        <h2>部屋登録ページ</h2>
        <form method = "GET">
            <label for = "name">部屋名</label>
            <input type = "text" name = "name">
            <br>
            <lable for = "text">案内文</lable>
            <textarea type = "text" name = "text" rows = "10"></textarea>
            <br>
            <lable for = "image">部屋画像メイン</lable>
            <input type = "file" name = "image_main">
            <br>
            <lable for = "image">部屋画像1</lable>
            <input type = "file" name = "image1">
            <br>            
            <lable for = "image">部屋画像2</lable>
            <input type = "file" name = "image2">
            <br>            
            <lable for = "image">部屋画像3</lable>
            <input type = "file" name = "image3">
            <br>
            <lable for = "price">宿泊料金</lable>
            <input type = "text" name = "price">
            <br>
            <lable for = "number">部屋数</lable>
            <input type = "text" name = "number">
            <br>
            <lable for = "type">部屋タイプ</lable>
            <input type = "text" name = "type">
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