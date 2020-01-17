<?php
  session_start();
  $title = "";
  if (array_key_exists("friends", $_GET)){
    $title = "Poorbook - amici";
  }else{
    $title = "Poorbook - cerca";
  }
?>

<html>
  <head>
    <title><?php echo $title; ?></title>
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
                            <li><a href="./logout.php" class=""> Logout </a></li>
                            <li><a href=" <?php echo 'profile.php?ptr_user=' . $_SESSION["user_id"] ?>" class=""><?php echo "" . $_SESSION["username"] . "" ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <!--<header style="background-color: #AAAAAA;">
      <div><h1> PoorBook </h1></div>
      <div id="saluto" style="width:49%; display: inline-block;">
        <?php //echo "Ciao <b>" . $_SESSION["username"] . "</b>"; ?>
        <form action="./logout.php" method="GET" style="display: inline-block;">
          <input type="submit" value="logout">
        </form>
      </div>
      <div id="ricerca" style="width:49%; display: inline-block;">
        <form action="./list.php" method="POST">
          <?php
            //echo '<input type="text" name="search" value="' . $_POST["search"] . '" style="display: inline-block">';
          ?>
          <input type="submit" value="cerca"  style="display: inline-block">
        </form>
      </div>  
    </header>-->

    <div class="main">
      <div class="container-fluid">
        <div class="col-sm-12">
          <ul>
    <?php
      if (array_key_exists("friends", $_GET)){
        require_once("dataaccess/utente.php");

        $users = Utente::CaricaAmici($_SESSION["user_id"]);

        foreach($users as $u){
          echo '<li><a href="profile.php?ptr_user=' . $u->user_id . '">' . $u->username . '</a></li>';
          }
      }else{
        require_once("dataaccess/utente.php");

        $users = Utente::CaricaUtentiFiltro($_POST["search"]);

        foreach($users as $u){
          echo '<li><a href="profile.php?ptr_user=' . $u->user_id . '">' . $u->username . '</a></li>';
        }
      }
    ?>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>  