	<section class="main">
		<section class="tab-content" id="tab-content">
			<section class="tab-pane active fade in content" id="configuration">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-9">
							<a href="#"><span class="fa fa-users fa-2x"> Configuration</span></a>
						</div>
					</div><br />
					<div class="row">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#user_roles" aria-controls="user_roles" role="tab" data-toggle="tab"> User Roles</a></li>
						<li role="presentation"><a href="#nav_code" aria-controls="nav_code" role="tab" data-toggle="tab"> NAV Code</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="user_roles">
							<?php include('user_roles.php'); ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="nav_code">
							<?php include('nav_code.php'); ?>
						</div>
					</div>
				</div>
			</section>
		</section>
	</section>
</article>

<!-- 
	Script - Homapage Google Like Search 
-->
<script>
	var username 				= $('#hd_username') .val();
	var handler_configuration 	= 'handler/handler_configuration.php';


	/* ****************
		Test Codes
	****************** */
	// $('#container_user_crud .panel-body,#container_user_crud .panel-heading').toggle(500);
</script>

<script type="text/javascript" src="../common_functions/common_functions.js"></script>
<script type="text/javascript" src="js/configuration/user_roles.js?132135s"></script>
<script type="text/javascript" src="js/configuration/nav_code.js?1234"></script>
