<!DOCTYPE html>
<html>
    <head>
        <title>トップページ</title>
        <link href = "style.css" rel = "stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <?php
            session_start();
            require("dbconnect.php");
        ?>
        <?php
            //  会員情報の登録処理  //
            if($_SESSION['insert_type'] == "gest_member" || $_SESSION['insert_type'] == "all_member"){
                $birth = $_GET['year']."/".$_GET['month']."/".$_GET['day'];  //生年月日
                $tel_home = $_GET['tel_home1']."-".$_GET['tel_home2']."-".$_GET['tel_home3'];  //電話番号（自宅）
                $tel_phone = $_GET['tel_phone1']."-".$_GET['tel_phone2']."-".$_GET['tel_phone3'];  //電話番号（携帯）    
                //  入力されたメールアドレスが既に登録されていないかデータベースを参照する  //
                $query = "SELECT メールアドレス FROM hotel_gest";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_all($result);
                for($i = 0; $i < count($row); $i++){
                    for($j = 0; $j < count($row[$i]); $j++){
                        if($_GET['email'] == $row[$i][$j]){
                            $count = 1;
                        }
                    }
                }
                //  登録実行コード （else：入力されたメールアドレスが既に使用されているとエラー文を表示する） //
                if($count == 0){
                    $query = "INSERT INTO hotel_gest(メールアドレス,パスワード,苗字,名前,生年月日,年齢,性別,住所,電話番号（自宅）,電話番号（携帯)) VALUE ('".$_GET['email']."','".$_GET['pass']."','".$_GET['name1']."','".$_GET['name2']."','".$birth."','".$_GET['age']."','".$_GET['gender']."','".$_GET['address']."','".$tel_home."','".$tel_phone."')";
                    $result = mysqli_query($db, $query);
                    echo "登録完了しました";    
                }
                else if($count == 1){
                    echo '<p class = "error">既に登録されているメールアドレスです</p>';
                }    
            }
            //  利用者からの予約情報の登録処理  //
            if($_SESSION['insert_type'] == "gest_promise"){
                $query = "INSERT INTO hotel_appointment(ゲスト番号,予約日,予約時間,宿泊人数,部屋) VALUE ('".$_SESSION['gest0']."','".$_GET['date']."','".$_GET['time']."','".$_GET['number']."人','".$_SESSION['room_number']."')";
                $result = mysqli_query($db, $query);
                echo "予約完了しました";    
            }
            //  管理者からの予約情報の登録処理
            if($_SESSION['insert_type'] == "host_promise"){
                $query = "INSERT INTO hotel_appointment(ゲスト番号,予約日,予約時間,宿泊人数,部屋) VALUE ('".$_GET['gest_number']."','".$_GET['date']."','".$_GET['time']."','".$_GET['number']."人','".$_SESSION['room_number']."')";
                $result = mysqli_query($db, $query);
                echo "予約完了しました";    
            }
            //  部屋情報の登録処理  //
            if($_SESSION['insert_type'] == "all_room"){
                echo "ok";
                $query = "INSERT INTO hotel_room(部屋名,案内文,部屋画像メイン,部屋画像1,部屋画像2,部屋画像3,宿泊料金,部屋数,部屋タイプ) VALUE ('".$_GET['name']."','".$_GET['text']."','".$_GET['image_main']."','".$_GET['image1']."','".$_GET['image2']."','".$_GET['image3']."','".$_GET['price']."円','".$_GET['number']."','".$_GET['type']."')";
                $result = mysqli_query($db, $query);
                echo "部屋を登録しました";    
            }
            //  部屋情報の登録処理  //
            if($_SESSION['insert_type'] == "all_roomtype"){
                echo "ok";
                $query = "INSERT INTO hotel_roomtype(部屋タイプ名,最大宿泊人数) VALUE ('".$_GET['name']."','".$_GET['number']."人')";
                $result = mysqli_query($db, $query);
                echo "部屋タイプを登録しました";    
            }        
        ?>

        
    </body>
</html>