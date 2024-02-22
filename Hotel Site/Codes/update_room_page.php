
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
                $_SESSION['update_type'] = "all_room";
                require("update.php");
            }
        ?>
        <h2>部屋変更ページ</h2>
        <?php
            //  ログインしている会員の会員番号と一致する予約内容を抽出する  //
            $query = "SELECT 部屋タイプ番号,部屋タイプ名,最大宿泊人数 FROM hotel_roomtype";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
        <div>
            <form method = "GET">
                <table>
                    <tr>
                        <th>部屋タイプ番号</th><th>部屋タイプ名</th><th>最大宿泊人数</th>
                    </tr>
                    <?php
                        for($i = 0; $i < count($row); $i++){
                            echo '<tr>';
                            for($j = 0; $j < count($row[$i]); $j++){
                                echo '<td>'.$row[$i][$j].'</td>';
                            }
                            echo '</tr>';
                        }
                    ?>
                </table>
            </form>
        </div>
        <br>
        
        <form method = "GET">
            <label for = "name">部屋名</label>
            <input type = "text" name = "name" value = <?php echo $_SESSION['room0'];?>>
            <br>
            <lable for = "text">案内文</lable>
            <textarea type = "text" name = "text" rows = "10"><?php echo $_SESSION['room1'];?></textarea>
            <br>
            <lable for = "image">部屋画像メイン</lable>
            <input type = "file" name = "image_main" value = <?php echo $_SESSION['room2'];?>>
            <br>
            <lable for = "image">部屋画像1</lable>
            <input type = "file" name = "image1" path = <?php echo $_SESSION['room3'];?>>
            <br>            
            <lable for = "image">部屋画像2</lable>
            <input type = "file" name = "image2" value = <?php echo $_SESSION['room4'];?>>
            <br>            
            <lable for = "image">部屋画像3</lable>
            <input type = "file" name = "image3" value = <?php echo $_SESSION['room5'];?>>
            <br>
            <lable for = "price">宿泊料金</lable>
            <input type = "text" name = "price" value = <?php echo $_SESSION['room6'];?>>
            <br>
            <lable for = "number">部屋数</lable>
            <input type = "text" name = "number" value = <?php echo $_SESSION['room7'];?>>
            <br>
            <lable for = "type">部屋タイプ</lable>
            <input type = "text" name = "type" value = <?php echo $_SESSION['room8'];?>>
            <br>
            <input type = "submit" name = "update" value = "変更する">
        </form>
        <form method = "GET" class = "back_form">
            <input type = "submit" name = "back" value = "部屋一覧ページに戻る">
        </form>
    </body>
</html>
