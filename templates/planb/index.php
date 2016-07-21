<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;


$user 			 = JFactory::getUser();
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$this->language  = $doc->language;
$this->direction = $doc->direction;

$doc->addStyleSheet('templates/planb/css/template.css');

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.tooltip');


// Adjusting content width
if ($this->countModules('sidebar-right') && $this->countModules('sidebar-left'))
{
	$col = "col-md-7";
}
elseif ($this->countModules('sidebar-right') && !$this->countModules('sidebar-left'))
{
	$col = "col-md-9";
}
elseif (!$this->countModules('sidebar-right') && $this->countModules('sidebar-left'))
{
	$col = "col-md-10";
}
else
{
	$col = "col-md-12";
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="'. JUri::root() . $this->params->get('logoFile') .'" alt="'. $sitename .'" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. htmlspecialchars($this->params->get('sitetitle')) .'</span>';
}
else
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. $sitename .'</span>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<?php
	// Use of Google Font
	if ($this->params->get('googleFont'))
	{
	?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName');?>' rel='stylesheet' type='text/css' />
		<style type="text/css">
			h1,h2,h3,h4,h5,h6,.site-title{
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName'));?>', sans-serif;
			}|
		</style>
	<?php
	}
	?>

	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">
	<!-- Body -->
	<div class="body">
		<div class="container">
			<!-- Header -->
			<header class="header" role="banner">
				<div class="header-inner clearfix">
					<div class="row">
						<a class="brand col-md-4" href="<?php echo $this->baseurl; ?>">
							<?php echo $logo;?> <?php if ($this->params->get('sitedescription')) { echo '<div class="site-description">'. htmlspecialchars($this->params->get('sitedescription')) .'</div>'; } ?>
						</a>
						<div class="col-md-2 col-xs-7">
							<br>
							Passatge de Nogués nº53<br>
							irregularesplanb@gmail.com<br><br>
						</div>
						<div class="col-md-2 col-xs-5">

						</div>
						<div class="col-md-2 col-xs-7">
							<jdoc:include type="modules" name="header-social" style="none" />
						</div>
						<div class="col-md-2 col-xs-5" style="text-align:center;padding-top:10px;">
							<!-- <jdoc:include type="modules" name="header-login" style="none" /> -->
							<!--<a href="<?php echo JRoute::_('index.php?option=com_users&view=login&tmpl=component') ?>" class="btn btn-primary modal" rel="{size: {x: 375, y: 415}}">
							<span class="glyphicon glyphicon-log-in"></span> Identificarse
							</a>-->
							<?php //var_dump($user); ?>
							<?php if($user->guest): ?>
							<a style="margin-bottom:10px;" class="btn btn-primary" data-toggle="modal" href="<?php echo 'index.php?option=com_users&view=login&tmpl=component';?>" data-target="#myModal">
							<span class="glyphicon glyphicon-log-in"></span> Identificarse
							</a>
								<?php
								$usersConfig = JComponentHelper::getParams('com_users');
								if ($usersConfig->get('allowUserRegistration')) : ?>
									<a class="btn btn-primary" data-toggle="modal" href="index.php?option=com_users&view=registration&tmpl=component" data-target="#myModal2">
									<span class="glyphicon glyphicon-plus-sign"></span> Registrarse
									</a>
								<?php endif; ?>
						<?php else:

						?>
						<form method="POST" action="index.php?option=com_users&task=user.logout">
						<button type="submit" class="btn btn-primary" >
							<span class="glyphicon glyphicon glyphicon-log-out"></span> Salir
							</button>
							<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()); ?>" />
							<?php echo JHtml::_('form.token');?>
						</form>
						<br>
						<a class="btn btn-primary"href="component/users/?task=profile.edit&user_id=<?php echo $user->id; ?>">
							<span class="glyphicon glyphicon-user"></span> Editar perfil<!--<?php echo $user->name; ?>-->
							</a>
							<?php

						?>
						<?php

						endif;

						?>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Login</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Registration</h4>
            </div>
            <div class="modal-body"><div class="te"></div></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

						</div>
					</div>
				</div>
			</header>
			<?php if ($this->countModules('navigation')) : ?>
			<nav class="navbar navbar-default" role="navigation">
				<jdoc:include type="modules" name="navigation" style="none" />
			</nav>
			<?php endif; ?>

			<div class="row">
				<?php if ($this->countModules('sidebar-left')) : ?>
				<!-- Begin Sidebar -->
				<div id="sidebar" class="col-md-2" style="padding-left: 15px;padding-top: 8px;">
					<div class="sidebar-nav">
						<jdoc:include type="modules" name="sidebar-left" style="xhtml" />
					</div>
				</div>
				<!-- End Sidebar -->
				<?php endif; ?>
				<main id="content" role="main" class="<?php echo $col;?>">
					<!-- Begin Content -->
                    <jdoc:include type="modules" name="banner" style="xhtml" />
					<jdoc:include type="modules" name="above-component" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<jdoc:include type="modules" name="below-component" style="none" />
					<!-- End Content -->
				</main>
				<?php if ($this->countModules('sidebar-right')) : ?>
				<div id="sidebar-right" class="col-md-3">
					<!-- Begin Right Sidebar -->
					<jdoc:include type="modules" name="sidebar-right" />
					<!-- End Right Sidebar -->
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container<?php echo ($params->get('fluidContainer') ? '' : '');?>">
			<hr />
			<jdoc:include type="modules" name="footer" style="none" />
			<p style="float:left">
				&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
			</p>
			<p style="float:right">
				Powered by <a target="_blank" href="http://es.linkedin.com/in/joanpiferrer/">Joan Piferrer</a>
			</p>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />

</body>
</html>
