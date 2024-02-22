<!DOCTYPE html>
<html>
    <head>
        <title>部屋一覧ページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            if($_GET['back']){
                header("Location:top_page.php");
            }
            if($_GET['insert']){
                header("Location:insert_room_page.php");
            }
            if($_GET['update']){
                $_SESSION['update_number'] = $_GET['select_number'];
                $_SESSION['session_type'] = "room_session";
                require("information_session.php");
                header("Location:update_room_page.php");
            }
            if($_GET['delete']){
                $_SESSION['delete_type'] = "all_room";
                $_SESSION['delete_number'] = $_GET['select_number'];  //選択したドロップダウンリストの値(予約番号)を格納
                header("Location:delete_page.php");
            }

            if($_GET['type_insert']){
                header("Location:insert_roomtype_page.php");
            }
            if($_GET['type_update']){
                $_SESSION['update_number'] = $_GET['select_number'];
                $_SESSION['session_type'] = "roomtype_session";
                require("information_session.php");
                header("Location:update_roomtype_page.php");
            }
            if($_GET['type_delete']){
                $_SESSION['delete_type'] = "all_roomtype";
                $_SESSION['delete_number'] = $_GET['select_number'];  //選択したドロップダウンリストの値(予約番号)を格納
                header("Location:delete_page.php");
            }
        ?>
        <form method = "GET">
            <select name = "select_number">
                <?php
                    $query = "SELECT * FROM hotel_room";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 0; $i < count($row); $i++){
                        echo '<option>'.$row[$i][0].'</option>';
                    }
                ?>
            </select>
            <input type = "submit" name = "insert" value = "登録する">
            <input type = "submit" name = "update" value = "編集する">
            <input type = "submit" name = "delete" value = "削除する">
        </form>
        <h2>部屋一覧ページ</h2>
        <?php
            //  ログインしている会員の会員番号と一致する予約内容を抽出する  //
            $query = "SELECT 部屋番号,部屋名,宿泊料金,部屋数,部屋タイプ名,最大宿泊人数 FROM hotel_room INNER JOIN hotel_roomtype ON 部屋タイプ = 部屋タイプ番号";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
        <form method = "GET">
            <table>
                <tr>
                    <th>部屋番号</th><th>部屋名</th><th>宿泊料金</th><th>部屋数</th><th>部屋タイプ</th><th>最大宿泊人数</th>
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
        <br>
        <form method = "GET">
            <select name = "select_number">
                <?php
                    $query = "SELECT * FROM hotel_roomtype";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 0; $i < count($row); $i++){
                        echo '<option>'.$row[$i][0].'</option>';
                    }
                ?>
            </select>
            <input type = "submit" name = "type_insert" value = "登録する">
            <input type = "submit" name = "type_update" value = "編集する">
            <input type = "submit" name = "type_delete" value = "削除する">
        </form>
        <h2>部屋タイプ一覧ページ</h2>
        <?php
            //  ログインしている会員の会員番号と一致する予約内容を抽出する  //
            $query = "SELECT 部屋タイプ番号,部屋タイプ名,最大宿泊人数 FROM hotel_roomtype";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_all($result);        
        ?>
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

        <form method = "GET" class = "back_form">
            <input type = "submit" name = "back" value = "トップページに戻る"> 
        </form>
    </body>
</html>