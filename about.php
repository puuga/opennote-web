<?php include "include/db_connect_oo.php" ?>
<?php include "include.php" ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <?php include "include_head.php" ?>
  <title>About</title>

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
    <h1>About</h1>

    <div class="row">

      <div class="col-lg-4">
        <div class="panel panel-info">
          <div class="panel-body">
            <p class="text-center">
              <img src="<?php echo getFacebookProfilePictureUrl(10207817507176671); ?>"
                class="img-responsive" alt="Responsive image">
            </p>
            <h3 class="panel-title">Siwawes Wongcharoen</h3>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
