<?php

function connect_db() {
  $host = DB_HOST;
  $dbname = DB_NAME;

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
    echo "Connected to $dbname at $host successfully.";
  } catch (PDOException $pe) {
    die("Could not connect to the database $dbname on $host:" . $pe->getMessage());
  }
  return $conn;
}
