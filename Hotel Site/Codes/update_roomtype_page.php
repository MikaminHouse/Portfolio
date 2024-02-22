
<!DOCTYPE html>
<html>
    <head>
        <title>ルームページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  トップページに移動  //
            if($_GET['back']){
                header("Location:all_room_page.php");
            }
            //  変更処理  //
            if($_GET['update']){
                $_SESSION['update_type'] = "all_roomtype";
                require("update.php");
            }
        ?>
        <h2>部屋タイプ変更ページ</h2>
        <form method = "GET">
            <label for = "name">部屋タイプ名</label>
            <input type = "text" name = "name" value = <?php echo $_SESSION['roomtype0'];?>>
            <br>
            <label for = "number">最大宿泊人数</label>
            <input type = "text" name = "number" value = <?php echo $_SESSION['roomtype1'];?>>
            <br>
            <input type = "submit" name = "update" value = "変更する">
        </form>
        <form method = "GET" class = "back_form">
            <input type = "submit" name = "back" value = "部屋一覧ページに戻る">
        </form>
    </body>
</html>
