<?php
require_once "pdo.php";
session_start();
header('Content-Type: application/json');
$stmt = $pdo->query("SELECT item, date, id FROM lt");
$rows = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  $rows[] = $row;
}
echo json_encode($rows, JSON_PRETTY_PRINT);
