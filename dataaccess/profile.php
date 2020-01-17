<?php
  require_once("dbconnect.php");

  class InfoProfilo
  {
  var $profile_id;
  var $pr_id;
  var $type;
	var $value;
	var $visibility;
  var $position;

  public function save(){
    $conn = connect();
      
    $query = "INSERT INTO profilerows VALUES (NULL," . $this->user . ", " . $this->type . ", '" . $this->message . "', " . $this->vis . ", " . $this->pos . ")";
               
    $result = $conn->query($query);

    $conn->close();
      
    return $result;
  }

  public function update()
  {
    $conn = connect();
      
    $query = "UPDATE profilerows SET type = " . $this->type . ", value = '" . $this->message . "', visibility = " . $this->vis . ", position = " . $this->pos . " WHERE profilerows.pr_id = " . $this->pr_id;
     
    $result = $conn->query($query);

    $conn->close();
  }

  public function delete()
  {
    $conn = connect();

    $query = "DELETE FROM poorbook.profilerows WHERE pr_id= " . $this->pr_id;

    $conn->query($query);

        $conn->close();
  }

	public static function CaricaInfoProfilo($pid, $vis){
	  $res = array();

    $conn = connect();
        
    $query = "SELECT p.profile_id, pr.pr_id, pt.description, pr.value, pr.visibility, pr.position FROM profiles p " .
             "INNER JOIN profilerows pr ON pr.profile = p.profile_id " .
             "INNER JOIN profiletypes pt ON pr.type = pt.profiletype_id " .
             "WHERE profile = " . $pid . " AND pr.visibility >= " . $vis . " ORDER BY pr.position";

    $result = $conn->query($query);

    if ($result->num_rows)
      {
        while ($row = $result->fetch_assoc())
        {
          $p = new InfoProfilo();
          $p->profile_id = $row["profile_id"];
          $p->pr_id = $row["pr_id"];
          $p->type = $row["description"];
          $p->value = $row["value"];
          $p->visibility = $row["visibility"];
          $p->position = $row["position"];
          $res[] = $p;
        }
      }

      $conn->close();

	  return $res;
	 }

   public static function CaricaProfileRow($profilerow_id)
  {
    $res = null;

    $conn = connect();

    $query = "SELECT p.profile_id, pr.pr_id, pt.description, pr.value, pr.visibility, pr.position FROM profiles p " .
             "INNER JOIN profilerows pr ON pr.profile = p.profile_id " .
             "INNER JOIN profiletypes pt ON pr.type = pt.profiletype_id " .
             "WHERE pr_id=" . $profilerow_id;

    $result = $conn->query($query);

    if ($result->num_rows > 0)
    {
      $row = $result->fetch_assoc();
      $res = new InfoProfilo();
      $res->profile_id = $row["profile_id"];
      $res->pr_id = $row["pr_id"];
      $res->type = $row["description"];
      $res->value = $row["value"];
      $res->visibility = $row["visibility"];
      $res->position = $row["position"];
    }
    
    $conn->close();

    return $res;
  }
  }
?>