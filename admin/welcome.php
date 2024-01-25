<?php

    require_once './common/config/config.inc.php';

?>



		<!-- NAVBAR -->

		<?php require_once SOURCE_ROOT.'header.inc.php'; ?>

		<!-- END NAVBAR -->

		<!-- LEFT SIDEBAR -->

		<?php require_once SOURCE_ROOT.'leftsidebar.inc.php'; ?>

		<?php require_once SOURCE_ROOT.'obituaries/obituaries_class/class.obituaries.php';

		      require_once SOURCE_ROOT.'condolence/condolence_class/class.condolence.php';

	        $objObituaries=Factory::getInstanceOf('Obituaries');

	        $objcondolence=Factory::getInstanceOf('Condolence');

	         $result=$objObituaries->getTotalObituaries();

	         $result1=$objcondolence->getTotalcondolence();

	        // print_r($result1);

	         // print_r($result[0][count('*')]);

	        // print_r($result);



	        ?>

		<!-- END LEFT SIDEBAR -->

		<!-- MAIN -->

		<div class="main">

			<!-- MAIN CONTENT -->

			<div class="main-content">

				<div class="container-fluid">

					<!-- OVERVIEW -->

					<div class="panel panel-headline">

						<div class="panel-heading">

							<h3 class="panel-title">Welcome to Admin Section</h3>

							<p class="panel-subtitle">Date: <?php echo date('l, d M Y ');?></p>

						</div>

						<div class="panel-body">

							<div class="row">

								<div class="col-md-3">

									<div class="metric">

										<span class="icon"><i class="lnr lnr-drop"></i></span>

										<p>

											<span class="number"><?php echo $result[0]['total_record']; ?></span>

											<span class="title">Obituaries</span>

										</p>

									</div>

								</div>

								<div class="col-md-3">

									<div class="metric">

										<span class="icon"><i class="lnr lnr-drop"></i></span>

										<p>

											<span class="number"><?php echo $result1[0]['total_record']; ?></span>

											<span class="title">Condolence</span>

										</p>

									</div>

								</div>

								

								

							</div>

							

						</div>

					</div>

					

							<!-- END REALTIME CHART -->

						</div>

					</div>

				</div>

			</div>

			<!-- END MAIN CONTENT -->

		</div>

		<!-- END MAIN -->

		<div class="clearfix"></div>

		<?php require_once SOURCE_ROOT.'footer1.inc.php'; ?>