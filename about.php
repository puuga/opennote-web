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
        <div class="panel-body">
          <div class="thumbnail">
    	      <img src="<?php echo getFacebookProfilePictureUrl(10207817507176671); ?>"
              class="img-responsive img-circle" alt="Siwawes Wongcharoen">
    	      <div class="caption">
    	        <h3 class="text-center">Siwawes Wongcharoen</h3>
    	        <p>
    						<dl class="text-center">
    							<dt>Contact Address</dt>
    							<dd>
    								Department of Computer Science and Information Tecnology,
    								Faculty of Science, Naresuan Univesity, Phitsanulok, Thailand
    							</dd>
    						</dl>

    						<dl class="text-center">
    							<dt>Email</dt>
    							<dd>
    								<a href="mailto:siwaoh@gmail.com">
                      siwaoh@gmail.com
                    </a>
    							</dd>
    						</dl>
    					</p>
    	      </div>
    	    </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="panel-body">
          <div class="thumbnail">
    	      <img src="<?php echo getFacebookProfilePictureUrl(439431556255704); ?>"
              class="img-responsive img-circle" alt="Nopphawit Punbua">
    	      <div class="caption">
    	        <h3 class="text-center">Nopphawit Punbua</h3>
    	        <p>
    						<dl class="text-center">
    							<dt>Contact Address</dt>
    							<dd>
    								Department of Computer Science and Information Tecnology,
    								Faculty of Science, Naresuan Univesity, Phitsanulok, Thailand
    							</dd>
    						</dl>

    						<dl class="text-center">
    							<dt>Email</dt>
    							<dd>
    								<a href="mailto:nopphawit.p@gmail.com">
                      nopphawit.p@gmail.com
                    </a>
    							</dd>
    						</dl>
    					</p>
    	      </div>
    	    </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="panel-body">
          <div class="thumbnail">
    	      <img src="<?php echo getFacebookProfilePictureUrl(1248659465150916); ?>"
              class="img-responsive img-circle" alt="Thanapong Nittayapapha">
    	      <div class="caption">
    	        <h3 class="text-center">Thanapong Nittayapapha</h3>
    	        <p>
    						<dl class="text-center">
    							<dt>Contact Address</dt>
    							<dd>
    								Department of Computer Science and Information Tecnology,
    								Faculty of Science, Naresuan Univesity, Phitsanulok, Thailand
    							</dd>
    						</dl>

    						<dl class="text-center">
    							<dt>Email</dt>
    							<dd>
    								<a href="mailto:tanapong.tor@gmail.com">
                      tanapong.tor@gmail.com
                    </a>
    							</dd>
    						</dl>
    					</p>
    	      </div>
    	    </div>
        </div>
      </div>

    </div>

  </div>

  <!--  nev bar -->
  <?php include "nev_bar.php" ?>
</body>
</html>
