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
    <div class="col-lg-10 col-lg-offset-1">
      <h1>Proposal</h1>
      <h2><?php echo $project_name; ?> for <?php echo $android; ?></h2>
    </div>

    <div class="row">

      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo $objective; ?></h3>
          </div>
          <div class="panel-body">
            <p>
              <?php echo $objective_1; ?>
            </p>
            <p>
              <?php echo $objective_2; ?>
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo $idea; ?></h3>
          </div>
          <div class="panel-body">
            <?php echo $idea_text; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo $desc; ?></h3>
          </div>
          <div class="panel-body">
            <?php echo $desc_text; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo $highlights; ?></h3>
          </div>
          <div class="panel-body">
            <?php echo $highlights_text; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo $benefit; ?></h3>
          </div>
          <div class="panel-body">
            <?php echo $benefit_text; ?>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
