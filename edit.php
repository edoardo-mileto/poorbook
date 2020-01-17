<?php
  session_start();

  if (!array_key_exists("user_id", $_SESSION))
  {
    header("location: login.php");
    exit;
  }

  if (!array_key_exists("profilerow_update", $_POST))
  {
      header("location: index.php");
      exit;
  }
?>

<html>
  <head>
    <title>Poorbook - profilo</title>
     <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/css/style.css"/>
      <link rel="stylesheet" href="assets/css/admin.css"/>
      <link rel="icon" href="assets/imgs/poorbook_logo_3.png">
      <style>
          .box{
              background: rgba(255,255,255,1);
              padding: 10px 20px;
              border-radius: 2px;
              box-shadow: 0px 0px 15px 5px rgba(0,0,0,0.4);
          }
      </style>
  </head>
  
  <body>
    <div class="header no-shadow">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo">
                            <h1> <a href="index.php" title="Torna alla home di PoorBook">Poorbook</a></h1>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <ul class="header-menu pull-right">
                            <li>
                              <form action="./list.php" method="POST">
                              <?php
                                echo '<input type="text" name="search" style="display: inline-block">';
                              ?>
                              <input type="submit" value="cerca"  style="display: inline-block">
                            </form></li>
                            <li><a href="./logout.php" class=""> logout </a></li>
                            <li><a href=" <?php echo 'profile.php?ptr_user=' . $_SESSION["user_id"] ?>" class=""><?php echo "" . $_SESSION["username"] . "" ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      <br>


<?php
        require_once('dataaccess/profile.php');
        $p = InfoProfilo::CaricaProfileRow($_POST['profilerow_update']);

        echo "<form action=\"./update_profilerow.php\" method=\"POST\">";
        echo "<h3>Aggiorna bio</h3><br>";

        echo '<textarea class="post col-sm-12" rows="5" cols="50" name="testo" placeholder="' . $p->value .'" style="resize: none;">' . $p->value .'</textarea><br>';

        echo 'Tipo: <select class="post" name="type">';

        require_once("dataaccess/tipi_profilo.php");
        $tipiProfilo = tipiProfilo::CaricaTipiProfilo();
        foreach ($tipiProfilo as $t){
          if($t->description === $p->type){
            echo '<option value="' . $t->type_id . '" selected>' . $t->description . '</option>';
          }else{
            echo '<option value="' . $t->type_id . '">' . $t->description . '</option>';
          }
        }
        echo "</select>";
        echo 'Posizione: <select class="post" name="pos">';
        $i = 1;
        while ($i < 10) {
          if($i == $p->position){
            echo '<option value="' . $i . '" selected>' . $i . '</option>';
          }else{
            echo '<option value="' . $i . '">' . $i . '</option>';
          }
          $i-=-1;
        }
        echo '</select>';
        $visArray = array(
          'Solo io',
          'Amici',
          'Tutti',
        );
        echo 'Visibilità: <select class="post" name="vis">';
        $k = 0;
        foreach($visArray as $opzioneVis) {
          if($k == $p->visibility){
            echo '<option value="' . $k . '" selected>' . $opzioneVis . '</option>';
          }else{
            echo '<option value="' . $k . '">' . $opzioneVis . '</option>';
          }
          $k-=-1;
        }
        echo '</select>';
        echo "<input type='hidden' name='pr_id' value='" . $_POST['profilerow_update'] . "'>";
        echo "<input type=\"submit\" value=\"salva\"></form>";
        ?>
     </body>
</html>
