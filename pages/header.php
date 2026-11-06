<!-- Redirect to another page (for no-js support) (place it in your <head>) -->
<noscript><meta http-equiv="refresh" content="0;url=pages/nojs-version.php"></noscript>    
<html>
<title>PAYROLL</title>
<head>
<?php require_once('pages/login_validation.php'); ?>
<?php require_once('libraries/includes.php'); ?>
<?php require_once('get_user_roles.php'); ?>
<?php echo '<input type="hidden" id="txt_selected_menu" value="'.$selected_menu.'">'; ?>


<?php 
/* used for standalone testing purposed only - remove on live or do not patch this page */
// $_SESSION['username'] = 'ronfern'; 
?>
<?php 
// $_SESSION['rapid_account_type'] = 2; 
/* used for standalone testing purposed only - remove on live or do not patch this page */
?>
<input type="text" id="hd_username" value="<?php echo $_SESSION['username']; ?>">
</head>
<body>
	<div id="loading_overlay">
		<div id="loading_overlay_center">
			<center>
				<!-- <img src="images/loader.gif"><br />	 -->
				<h2>Loading Module...</h2>
			</center>
		</div>
	</div>
	<nav class="navbar navbar-default navbar-fixed-top topbar">
		<div class="">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">
					<span class="hidden-xs">PAYROLL</span>
				</a>

				<p class="navbar-text">
					
				</p>
			</div>

			<div class="navbar-collapse collapse" id="navbar-collapse-main">
				<ul class="nav navbar-nav navbar-left">
					<li>
						<a href="#" class="sidebar-toggle" id="toggle-menu">
							<i class="fa fa-bars"></i>
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right" style="padding-right:8px;">
					<li class="dropdown">
						<button class="navbar-btn" data-toggle="dropdown">
							<!-- <i class="fa fa-globe fa-2x"></i> <i class="badge">5</i> -->
						</button>
						<ul class="dropdown-menu">
							<!-- <li><a href="#">(IQC) In-coming Quality Inspection <i class="badge">1</i></a></li> -->
							<!-- <li><a href="#">(OQC) Out-going Quality Inspection <i class="badge">4</i></a></li> -->
							<li class="nav-divider"></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
	<article class="wrapper toggled">
	
	<aside class="sidebar">
		<ul class="sidebar-nav">
			<li class="active" id="li_dashboard"><a href="#dashboard" data-toggle="tab"><i class="fa fa-dashboard fa-lg"></i> <span>Dashboard</span></a></li>
			<?php 
				echo '<li id="li_eom"><a href="#" data-toggle="tab"><i class="fa fa-globe fa-lg"></i> <span>EOM</span></a></li>';			
				echo '<li id="li_hmo"><a href="#" data-toggle="tab"><i class="fa fa-heartbeat fa-lg"></i> <span>HMO</span></a></li>';				
				echo '<li id="li_payroll_info"><a href="#" data-toggle="tab"><i class="fa fa-rub fa-lg"></i> <span>Payroll Info.</span></a></li>';
				echo '<li id="li_taxes"><a href="#" data-toggle="tab"><i class="fa fa-money fa-lg"></i> <span>Taxes</span></a></li>';
				echo '<li id="li_working_days"><a href="#" data-toggle="tab"><i class="fa fa-calendar fa-lg"></i> <span>Working Days</span></a></li>';
				echo '<li id="li_leaves"><a href="#" data-toggle="tab"><i class="fa fa-envira"></i><i class="fa fa-leaf"></i> <span>Leaves</span></a></li>';
				echo '<li id="li_pagibig"><a href="#" data-toggle="tab"><i class="fa fa-home fa-2x"></i><span> Pag-ibig</span></a></li>';
				echo '<li id="li_sss"><a href="#" data-toggle="tab"><i class="fa fa-id-card fa-lg"></i> <span>SSS</span></a></li>';				
				echo '<li id="li_payroll_reports"><a href="#" data-toggle="tab"><i class="fa fa-file-excel-o fa-lg"></i> <span>Reports</span></a></li>';
				echo '<li id="li_configuration"><a href="#" data-toggle="tab"><i class="fa fa-cogs fa-lg"></i> <span>Configuration</span></a></li>';
			
			?>
		</ul>
	</aside>
	
	<script>
		var script_url = '';
		var handler = 'handler/handler.php';
		var selected_menu = $('#txt_selected_menu').val();
		$(function () { $('[data-toggle="popover"]').popover(); });

		$(document).on("click",".sidebar-toggle",function(){
			$(".wrapper").toggleClass("toggled");
		});
		
		$('.sidebar li').click(function(){
			console.log('ID: ', this.id);
			fn_get_page(this.id);
		});
		
		display_loading_screent();
		function display_loading_screent(){
			document.getElementById("loading_overlay").style.display = "block";
			setTimeout(function(){
				document.getElementById("loading_overlay").style.display = "none";
			},300);
		}
		
		function fn_get_page(page_id){
			var data = {
				"action"	: "fn_get_page",
				"page_id"	: page_id
			}
			data = $.param(data);
			$.ajax({
				type	: "post",
				dataType: "json",
				data 	: data,
				url 	: handler,
				success	:function(result){
					console.log('result:', result);
					window.location.href = "index.php?page="+result['page'];
				},error	: function(result){
					console.log('result:', result);
				}
			});
		}
		
		fn_set_active_nav(selected_menu);
		function fn_set_active_nav(selected_menu){
			if(selected_menu == ''){
				$('.sidebar .sidebar-nav li').attr('class','');
				$('.sidebar .sidebar-nav #li_dashboard').attr('class','active');
			}else{
				$('.sidebar .sidebar-nav li').attr('class','');
				$('.sidebar .sidebar-nav #li_'+selected_menu).attr('class','active');
			}
		}
	</script>
	<script src="js/common_functions.js?456456456" type="text/javascript"></script>
