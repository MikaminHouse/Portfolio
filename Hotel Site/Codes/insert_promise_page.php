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
            //  予約登録処理  //
            if($_GET['insert']){
                $_SESSION['insert_type'] = "gest_promise";
                if($_SESSION['host_email']){
                    $_SESSION['insert_type'] = "host_promise";
                }
                require("insert.php");
            }
            //  ホームページに移動  //
            if($_GET['back']){
                //  会員一覧ページに移動  //
                if($_SESSION['gest_email']){
                    if($_SESSION['room_back'] == "room"){
                        header("Location:room_page.php");
                    }
                    else if($_SESSION['room_back'] == "gest_promise"){
                        header("Location:gest_promise_page.php");
                    }
                }
                else if($_SESSION['host_email']){
                    header("Location:all_promise_page.php");
                }
                //  ログインページに移動  //
                else{
                    header("Location:login_page.php");
                }
            }
            //  ログインしていなければログインページに飛ばす  //
            if($_SESSION['gest_email'] == false && $_SESSION['host_email'] == false){
                header("Location:login_page.php");
            }
        ?>

        <h2>予約登録ページ</h2>
        <form method = "GET">
            <?php
            if($_SESSION['host_email']){
                echo '<lable for = "gest_number">会員番号</lable>';
                echo '<select name = "gest_number">';
                $query = "SELECT 会員番号 FROM hotel_gest";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_all($result);
                for($i = 0; $i <count($row);$i++){
                    echo '<option>'.$row[$i][0].'</option>';
                }
                echo '</select>
                <br>
                ';            
            }
            ?>
            <label for = "date">予約日</label>
            <input type = "date" name = "date" required>
            <br>
            <lable for = "time">予約時間</lable>
            <input type = "time" name = "time" required>
            <br>
            <lable for = "number">宿泊人数</lable>
            <select name = "number">
                <?php
                    $query = "SELECT 最大宿泊人数 FROM hotel_room INNER JOIN hotel_roomtype ON 部屋タイプ = 部屋タイプ番号 WHERE 部屋番号 = '".$_SESSION['room_number']."'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 1; $i <$row[0][0] + 1 ;$i++){
                        echo '<option>'.$i.'</option>';
                    }
                ?>
            </select>人
            <br>
            <input type = "submit" name = "insert" value = "予約する">
        </form>
        <form method = "GET" class = "back_form">
            <?php
                if($_SESSION['gest_email'] || $_SESSION['host_email']){
                    if($_SESSION['room_back'] == "room"){
                        echo '<input type = "submit" name = "back" value = "ルームページに戻る">';
                    }
                    else if($_SESSION['room_back'] == "gest_promise"){
                        echo '<input type = "submit" name = "back" value = "予約情報ページに戻る">';
                    }
                }
                //  ホームページに移動  //
                else{
                    echo '<input type = "submit" name = "back" value = "ログインページに戻る">';
                }
            ?>
            
        </form>    
    </body>
</html>