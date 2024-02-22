<?php
require('../DB_Connect.php');
?>

<?php

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースからランダムに1つのデータを取得
    $stmt = $pdo->prepare("SELECT id, name FROM result_table ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // result_table_3テーブルにinsert（idはオートインクリメント）
    $stmt = $pdo->prepare("INSERT INTO result_table_3 (name) VALUES (:name)");
    $stmt->bindParam(':name', $result['name']);
    $stmt->execute();

    // result_tableからデータを削除
    $stmt = $pdo->prepare("DELETE FROM result_table WHERE id = :id");
    $stmt->bindParam(':id', $result['id']);
    $stmt->execute();

    // result_table_2の該当位置のnameカラムを更新
    $stmt = $pdo->prepare("UPDATE result_table_2 SET name = :name WHERE id = (SELECT MAX(id) FROM result_table_3)");
    $stmt->bindParam(':name', $result['name']);
    $stmt->execute();

    // 結果をJSON形式で出力
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
