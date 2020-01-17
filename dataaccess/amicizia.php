<?php
  require_once("dbconnect.php");

  class Amicizia
  {
	var $friendship_id;
	var $friend_1;
	var $friend_2;
	var $accepted;

	/**
	 * Salva l'amicizia inserendola se friendship_id non è valorizzato, o 
	 * aggiornando il campo accepted altrimenti.
	 */
	public function save()
	{
		$conn = connect();
		
		$query = "";
		if ($this->friendship_id == null)
		{
          $query = "INSERT INTO friendships (friendship_id, friend_1, friend_2, accepted) " .
                   "VALUES (NULL, " . $this->friend_1 . ", " . $this->friend_2 . ", " . $this->accepted . ")";
		}     
		else
		{
		  $query = "UPDATE friendships f " . 
                   "SET f.accepted=" . $this->accepted . " " .
                   "WHERE f.friendship_id=" . $this->friendship_id;
		}     
        
		$result = $conn->query($query);

        $conn->close();
      
        return $result;
	}

	public function delete()
	{
		$conn = connect();

		$query = "DELETE FROM poorbook.friendships WHERE friendship_id= " . $this->friendship_id;

		$conn->query($query);

        $conn->close();
	}

	public static function CaricaAmiciziaFF($f1, $f2)
	{
		$res = null;

		$conn = connect();

		$query = "SELECT * " .
		         "FROM friendships f " .
				     "WHERE (f.friend_1 = $f1 AND f.friend_2 = $f2) OR " .
				           "(f.friend_1 = $f2 AND f.friend_2 = $f1)";

		$result = $conn->query($query);

		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$res = new Amicizia();
			$res->friendship_id = $row["friendship_id"];
			$res->friend_1 = $row["friend_1"];
			$res->friend_2 = $row["friend_2"];
			$res->accepted = $row["accepted"];
		}

		return $res;
	}

	public static function CaricaAmicizia($friendship_id)
	{
		$res = null;

		$conn = connect();

		$query = "SELECT * " .
		         "FROM friendships f " .
				 "WHERE friendship_id=" . $friendship_id;

		$result = $conn->query($query);

		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$res = new Amicizia();
			$res->friendship_id = $row["friendship_id"];
			$res->friend_1 = $row["friend_1"];
			$res->friend_2 = $row["friend_2"];
			$res->accepted = $row["accepted"];
		}

		return $res;
	}

	
  }
?>