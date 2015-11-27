<?php include "include/db_connect_oo.php" ?>
<?php include "include.php" ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <?php include "include_head.php" ?>
  <title>Proposal</title>

  <script>
    $(document).ready(function() {
      // This command is used to initialize some elements and make them work properly
      $.material.init();

    });
  </script>
</head>
<body>
  <?php include_once("include/analyticstracking.php") ?>
  <?php
    function getFacebookProfilePictureUrl($id) {
      return "https://graph.facebook.com/$id/picture?type=large";
    }
  ?>
  <div class="container">
    <h1>Proposal</h1>

    <div class="row">

      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Panel info</h3>
          </div>
          <div class="panel-body">
            Panel content
          </div>
        </div>
      </div>

    </div>

  </div>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
