<?php
use Orpheus\Rendering\HTMLRendering;

/* @var string $CONTROLLER_OUTPUT */
/* @var HTMLRendering $this */
/* @var HTTPController $Controller */
/* @var HTTPRequest $Request */
/* @var HTTPRoute $Route */
/* @var User $user */

/* @var array $Breadcrumb */
/* @var string $PageTitle */
/* @var boolean $NoContentTitle */
/* @var string $ContentTitle */
/* @var string $titleRoute */

global $APP_LANG;

$routeName = $Controller->getRouteName();
$user = User::getLoggedUser();

$invertedStyle = $Controller->getOption('invertedStyle', 1);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="<?php echo $APP_LANG; ?>" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?php echo $APP_LANG; ?>">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo !empty($PageTitle) ? $PageTitle : SITENAME; ?></title>
	<meta name="Description" content=""/>
	<meta name="Author" content="<?php echo AUTHORNAME; ?>"/>
	<meta name="application-name" content="<?php echo SITENAME;?>" />
	<meta name="msapplication-starturl" content="<?php echo DEFAULTLINK; ?>" />
	<meta name="Keywords" content="projet"/>
	<meta name="Robots" content="Index, Follow"/>
	<meta name="revisit-after" content="16 days"/>
	<link rel="icon" type="image/png" href="<?php echo STATIC_URL.'images/icon.png'; ?>" />
<?php
foreach($this->listMetaProperties() as $property => $content) {
	echo '
	<meta property="'.$property.'" content="'.$content.'"/>';
}
?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" type="text/css" media="screen" />
<?php
/*
	<link rel="stylesheet" href="//shared.sowapps.com/select2/select2-3.5.2/select2.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="//shared.sowapps.com/select2-bootstrap-css/select2-3.5.2/select2-bootstrap.css" type="text/css" media="screen" />
	
<!--	 <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css"> -->
*/

foreach($this->listCSSURLs(HTMLRendering::LINK_TYPE_PLUGIN) as $url) {
	echo '
	<link rel="stylesheet" href="'.$url.'" type="text/css" media="screen" />';
}
?>
	
	<link rel="stylesheet" href="<?php echo HTMLRendering::getCSSURL(); ?>sb-admin.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo STATIC_URL.'style/base.css'; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo HTMLRendering::getCSSURL(); ?>style.css" type="text/css" media="screen" />
<?php
foreach($this->listCSSURLs() as $url) {
	echo '
	<link rel="stylesheet" href="'.$url.'" type="text/css" media="screen" />';
}
?>
	
	<!-- External JS libraries -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
</head>
<body class="<?php echo $invertedStyle ? 'body-inverse' : 'body-default'; ?>">

<div id="wrapper">

	<!-- Sidebar -->
	<nav class="navbar <?php echo $invertedStyle ? 'navbar-inverse' : 'navbar-default'; ?> navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php _u(DEFAULTROUTE); ?>"><?php _t($Controller->getOption('main_title', 'adminpanel_title')); ?></a>
		</div>
	
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<?php
			$this->showMenu($Controller->getOption('mainmenu', 'adminmenu'), 'menu-sidebar');
			?>
			
			<ul class="nav navbar-nav navbar-right navbar-user">
			<?php
			if( $user ) {
				?>
				<li class="dropdown user-dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php _u(ROUTE_ADM_MYSETTINGS); ?>"><i class="fa fa-gear"></i> <?php _t(ROUTE_ADM_MYSETTINGS); ?></a></li>
						<li><a href="<?php _u(ROUTE_LOGOUT); ?>"><i class="fa fa-power-off"></i> <?php _t(ROUTE_LOGOUT); ?></a></li>
					</ul>
				</li>
			<?php
			}
			?>
			</ul>
		</div>
	</nav>

	<div id="page-wrapper">

		<div class="container-fluid">

			<div class="row">
				<div class="col-lg-12">
					<?php
// 					debug('$ContentTitle', $ContentTitle);
					if( empty($NoContentTitle) ) {
						?>
					<h1 class="page-header"><?php echo isset($ContentTitle) ? $ContentTitle : t(isset($titleRoute) ? $titleRoute : $routeName); ?> <small><?php _t((isset($titleRoute) ? $titleRoute : $routeName).'_legend'); ?></small></h1>
					<?php
					}
					if( !empty($Breadcrumb) ) {
						?>
					<ol class="breadcrumb">
						<?php
						$bcLast	= count($Breadcrumb)-1;
						foreach( $Breadcrumb as $index => $page ) {
							if( $index >= $bcLast || empty($page->link) ) {
								echo '
						<li class="active">'.$page->label.'</li>';
							} else {
								echo '
						<li><a href="'.$page->link.'">'.$page->label.'</a></li>';
							}
						}
						?>
					</ol>
					<?php
					}
					$this->display('reports-bootstrap3');
					?>
				</div>
			</div>
			
			<?php
			echo $CONTROLLER_OUTPUT;
			echo $Content;
			?>
	
		</div>
	</div>

</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/fr.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.5/js/jquery.tablesorter.js"></script>
	
<?php
foreach($this->listJSURLs(HTMLRendering::LINK_TYPE_PLUGIN) as $url) {
	echo '
	<script type="text/javascript" src="'.$url.'"></script>';
}
?>
	
	<script src="<?php echo JSURL; ?>orpheus.js"></script>
	<script src="<?php echo JSURL; ?>script.js"></script>
	<?php /*
	<script src="<?php echo JSURL; ?>form.js"></script>
	*/ ?>
	<script src="<?php echo HTMLRendering::getJSURL(); ?>orpheus.js"></script>
	<script src="<?php echo HTMLRendering::getJSURL(); ?>script.js"></script>
	
<?php
foreach($this->listJSURLs() as $url) {
	echo '
	<script type="text/javascript" src="'.$url.'"></script>';
}
?>
</body>
</html>