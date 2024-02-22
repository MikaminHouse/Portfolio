
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
                header("Location:all_promise_page.php");
            }
            //  変更処理  //
            if($_GET['update']){
                $_SESSION['update_type'] = "all_promise";
                require("update.php");
            }
        ?>
        <h2>予約変更ページ</h2>
        <form method = "GET" id = "member_form">
        <lable for = "pass">会員番号</lable>
            <input type = "text" name = "gest_number" value = <?php echo $_SESSION['promise0'];?>>
            <br>
            <lable for = "email">予約日</lable>
            <input type = "date" name = "date" value = <?php echo $_SESSION['promise1'];?>>
            <br>
            <lable for = "pass">予約時間</lable>
            <input type = "time" name = "time" value = <?php echo $_SESSION['promise2'];?>>
            <br>

            <lable for = "pass">宿泊人数</lable>
            <select name = "number" value = <?php echo $_SESSION['promise3'];?>>
                <?php
                    for($i = 1; $i < 11; $i++){
                        echo '<option>'.$i.'</option>';
                    }
                    /*
                    $query = "SELECT 最大宿泊人数 FROM hotel_room INNER JOIN hotel_roomtype ON 部屋タイプ = 部屋タイプ番号 WHERE 部屋番号 = '".$_SESSION['room4']."'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 1; $i <$row[0][0] + 1 ;$i++){
                        if($i == $_SESSION['room3']){
                            echo '<option selected>'.$i.'</option>';
                        }
                        else{
                        }
                    }
                    */
                ?>
            </select>人
            <br>            
            <lable for = "pass">部屋</lable>
            <select name = "type" value = <?php echo $_SESSION['promise4'];?>>
                <?php
                    $query = "SELECT 部屋番号 FROM hotel_room";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 1; $i <count($row) + 1; $i++){
                        if($i == $_SESSION['room4']){
                            echo '<option selected>'.$i.'</option>';
                        }
                        else{
                            echo '<option>'.$i.'</option>';
                        }
                    }
                ?>
            </select>
            
            <br>
            <input type = "submit" name = "update" value = "変更する">
            <?php
                if($_SESSION['host_email']){
                    ;
                }
                else if($_SESSION['gest_email']){
                    echo '<input type = "submit" name = "delete" value = "退会する">';
                }
            ?>
            
        </form>
        <form method = "GET" class = "back_form">
            <input type = "submit" name = "back" value = "予約一覧ページに戻る">
        </form>
    </body>
</html>