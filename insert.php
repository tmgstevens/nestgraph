<?php
error_reporting(E_ALL);
require 'inc/config.php';
require 'inc/class.db.php';
require 'collect.php';
require 'weather.php';

try {
  $db = new DB($config);
  $data = get_nest_data();
var_dump($data);
  $outsideTemp = getCurrentTemp();
  if (!empty($data['timestamp'])) {
    if ($stmt = $db->res->prepare("REPLACE INTO data (timestamp, heating, target, current, humidity, outside, updated) VALUES (?,?,?,?,?,?,NOW())")) {
      $stmt->bind_param("siddii", $data['timestamp'], $data['heating'], $data['target_temp'], $data['current_temp'], $data['humidity'], $outsideTemp);
      $stmt->execute();
      $stmt->close();
    }
  }
  $db->close();
} catch (Exception $e) {
  $errors[] = ("DB connection error! <code>" . $e->getMessage() . "</code>.");
}

?>
