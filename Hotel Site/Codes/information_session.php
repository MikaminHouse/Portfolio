<html>
    <head>
        <title>制作</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  会員情報保存処理  //
            if($_SESSION['session_type'] == "member_session"){
                //  利用者用の会員情報保存処理  //
                if($_SESSION['gest_email']){
                    // 会員の会員番号を除く情報をセッションに格納する //
                    $query = "SELECT * FROM hotel_gest WHERE メールアドレス = '".$_SESSION['gest_email']."'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 0; $i < count($row); $i++){
                        for($j = 0; $j < count($row[$i]); $j++){
                            $_SESSION['gest'.$j] = $row[$i][$j];
                            //echo $j."：".$_SESSION['gest'.$j];
                        }
                    }
                }
                //  管理者用の会員情報保存処理  //
                if($_SESSION['host_email']){
                    // 会員の会員番号を除く情報をセッションに格納する //
                    $query = "SELECT * FROM hotel_gest WHERE 会員番号 = '".$_SESSION['update_number']."'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_all($result);
                    for($i = 0; $i < count($row); $i++){
                        for($j = 0; $j < count($row[$i]); $j++){
                            $_SESSION['gest'.$j] = $row[$i][$j];
                            //echo $j."：".$_SESSION['gest'.$j];
                        }
                    }
                }
            }
            //  予約情報保存処理  //
            if($_SESSION['session_type'] == "promise_session"){
                $query = "SELECT ゲスト番号,予約日,予約時間,宿泊人数,部屋 FROM hotel_appointment WHERE 予約番号 = '".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_all($result);            
                for($i = 0; $i < count($row); $i++){
                    for($j = 0; $j < count($row[$i]); $j++){
                        $_SESSION['promise'.$j] = $row[$i][$j];
                        //echo $_SESSION['promise'.$j];
                    }
                }
            }
            if($_SESSION['session_type'] == "room_session"){
                $query = "SELECT 部屋名,案内文,部屋画像メイン,部屋画像1,部屋画像2,部屋画像3,宿泊料金,部屋数,部屋タイプ FROM hotel_room WHERE 部屋番号 = '".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_all($result);            
                for($i = 0; $i < count($row); $i++){
                    for($j = 0; $j < count($row[$i]); $j++){
                        $_SESSION['room'.$j] = $row[$i][$j];
                        //echo $_SESSION['room'.$j];
                    }
                }
            }
            if($_SESSION['session_type'] == "roomtype_session"){
                $query = "SELECT 部屋タイプ名,最大宿泊人数 FROM hotel_roomtype WHERE 部屋タイプ番号 = '".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_all($result);            
                for($i = 0; $i < count($row); $i++){
                    for($j = 0; $j < count($row[$i]); $j++){
                        $_SESSION['roomtype'.$j] = $row[$i][$j];
                        //echo $_SESSION['room'.$j];
                    }
                }
            }        ?>
    </body>
</html>
            
