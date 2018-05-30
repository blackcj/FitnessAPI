<?php
function getHeartrate() {
  $sql = "SELECT * from heartrate;";

  try {
    $db = connect_db(); // open the connection, see phpmysqlconnect.php
    $query = $db->query($sql);
    $query->setFetchMode(PDO::FETCH_ASSOC);
    while($result = $query->fetch()){
      $data[] = $result;
    }
    $db = NULL; // close the connection
    echo json_encode($data);
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
}

function postHeartrate() {
  // TODO: Complete this route.
}
