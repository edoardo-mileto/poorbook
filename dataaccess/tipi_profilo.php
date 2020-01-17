<?php
  require_once("dbconnect.php");

  class tipiProfilo
  {
  var $type_id;
  var $description;

	public static function CaricaTipiProfilo(){
	  $res = array();

    $conn = connect();
        
    $query = "SELECT * FROM profiletypes";

    $result = $conn->query($query);

    if ($result->num_rows)
      {
        while ($row = $result->fetch_assoc())
        {
          $t = new tipiProfilo();
          $t->type_id = $row["profiletype_id"];
          $t->description = $row["description"];
          $res[] = $t;
        }
      }

      $conn->close();

	  return $res;
	 }
  }
?>