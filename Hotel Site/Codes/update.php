<html>
    <head>
        <title>制作</title>
        <link href = "style.css" rel = "stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  利用者からの会員情報の変更処理  //
            if($_SESSION['update_type'] == "gest_member"){
                $query = "UPDATE hotel_gest SET メールアドレス = '".$_GET['email']."',パスワード = '".$_GET['pass']."',苗字 = '".$_GET['name1']."',名前 = '".$_GET['name2']."',生年月日 = '".$_GET['birth']."',年齢 = '".$_GET['age']."',性別 = '".$_GET['gender']."',住所 = '".$_GET['address']."',電話番号（自宅） = '".$_GET['tel_home']."',電話番号（携帯） = '".$_GET['tel_phone']."' WHERE メールアドレス='".$_SESSION['gest_email']."'";
                $result = mysqli_query($db, $query);
                $_SESSION['gest_email'] = $_GET['email'];
                $_SESSION['gest_pass'] = $_GET['pass'];
                $_SESSION['session_type'] = "member_session";  //会員情報を保存する処理を行う為の数値
                require("information_session.php");  //会員情報を保存
                echo "会員情報を変更しました";
            }
            if($_SESSION['update_type'] == "host_member"){
                $query = "UPDATE hotel_gest SET メールアドレス = '".$_GET['email']."',パスワード = '".$_GET['pass']."',苗字 = '".$_GET['name1']."',名前 = '".$_GET['name2']."',生年月日 = '".$_GET['birth']."',年齢 = '".$_GET['age']."',性別 = '".$_GET['gender']."',住所 = '".$_GET['address']."',電話番号（自宅） = '".$_GET['tel_home']."',電話番号（携帯） = '".$_GET['tel_phone']."' WHERE 会員番号='".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $_SESSION['session_type'] = "member_session";  //会員情報を保存する処理を行う為の数値
                require("information_session.php");  //会員情報を保存
                echo "会員情報を変更しました";
            }
            //  予約情報の変更処理  //
            if($_SESSION['update_type'] == "all_promise"){
                echo $_GET['gest_number'];
                echo $_GET['date'];
                echo $_GET['time'];
                echo $_GET['number'];
                echo $_GET['type'];
                $query = "UPDATE hotel_appointment SET ゲスト番号 = '".$_GET['gest_number']."',予約日 = '".$_GET['date']."',予約時間 = '".$_GET['time']."',宿泊人数 = '".$_GET['number']."人',部屋 = '".$_GET['type']."' WHERE 予約番号='".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $_SESSION['session_type'] = "promise_session";  //予約情報を保存する処理を行う為の数値
                require("information_session.php");  //予約情報を保存
                echo '予約情報を変更しました';    
            }
            //  部屋情報の変更処理  //
            if($_SESSION['update_type'] == "all_room"){
                $query = "UPDATE hotel_room SET 部屋名 = '".$_GET['name']."',案内文 = '".$_GET['text']."',宿泊料金 = '".$_GET['price']."',部屋数 = '".$_GET['number']."',部屋タイプ = '".$_GET['type']."' WHERE 部屋番号='".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $_SESSION['session_type'] = "room_session";  //部屋情報を保存する処理を行う為の数値
                require("information_session.php");  //部屋情報を保存
                echo '部屋情報を変更しました';    
            }
            //  部屋情報の変更処理  //
            if($_SESSION['update_type'] == "all_roomtype"){
                $query = "UPDATE hotel_roomtype SET 部屋タイプ名 = '".$_GET['name']."',最大宿泊人数 = '".$_GET['number']."' WHERE 部屋タイプ番号='".$_SESSION['update_number']."'";
                $result = mysqli_query($db, $query);
                $_SESSION['session_type'] = "roomtype_session";  //部屋情報を保存する処理を行う為の数値
                require("information_session.php");  //部屋情報を保存
                echo '部屋情報を変更しました';    
            }
        ?>
    </body>
</html>
            