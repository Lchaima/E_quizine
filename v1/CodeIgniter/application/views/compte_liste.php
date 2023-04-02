 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Compte Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title"> number of accounts </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6> <?php 
                          if($nombre->number_accounts != 0 ){
                            echo $nombre->number_accounts ;
                          }else{
                            echo " there is no account yet !" ;
                          }
                      ?></h6>
                    </div>
                  </div>

                </div>
              </div>
            </div><!-- End Compte Card -->
         
            <!-- list compte -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">
                <h5 class="card-title"> <?php echo $titre;?> </h5>
    						<?php
    						if($pseudos != NULL) {
    							foreach($pseudos as $login){
    							 echo '<div class="list-group">';
                   echo '<a href="#" class="list-group-item ">'.$login["cpt_pseudo"].'</a>' ;
                   echo '</div>' ;
    							}
    						}else {
                  echo "<br />";
      						echo "Aucun compte !";
      					}
      					?>
              </div>
            </div><!-- End list compte -->
          </div>
        </div><!-- End Left side columns -->
    </div>
  </section>

  </main><!-- End #main -->

