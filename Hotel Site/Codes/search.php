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
            $query = "SELECT * FROM hotel_gest";
            $query = "SELECT * FROM $table_name WHERE 会員番号 LIKE '%".$_GET['target_number']."%'";
            $result = mysqli_query($db, $query);
            
        ?>
    </body>
</html>
    