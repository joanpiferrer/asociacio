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


$user = JFactory::getUser();
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;


//$doc->addStyleSheet('templates/planb/css/template.css');

// Detecting Active Variables
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');
$layout = $app->input->getCmd('layout', '');
$task = $app->input->getCmd('task', '');
$itemid = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

// Adjusting content width
if ($this->countModules('sidebar-right') && $this->countModules('sidebar-left')) {
    $col = "col-md-7";
} elseif ($this->countModules('sidebar-right') && !$this->countModules('sidebar-left')) {
    $col = "col-md-9";
} elseif (!$this->countModules('sidebar-right') && $this->countModules('sidebar-left')) {
    $col = "col-md-10";
} else {
    $col = "col-md-12";
}
$app = JFactory::getApplication();
$menu = $app->getMenu();
if ($menu->getActive() == $menu->getDefault()) {
    // Logo file or site title param
    if ($this->params->get('logoFile')) {
        $logo = '<img class="main-logo" src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
    } elseif ($this->params->get('sitetitle')) {
        $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
    } else {
        $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
    }
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>"
      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <jdoc:include type="head"/>
    <?php
    // Use of Google Font
    if ($this->params->get('googleFont')) {
        ?>
        <link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>'
              rel='stylesheet' type='text/css'/>
        <style type="text/css">
            h1, h2, h3, h4, h5, h6, .site-title {
                font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName'));?>', sans-serif;
            }

            |
        </style>
        <?php
    }
    ?>
    <!-- Bootstrap -->
    <link href="templates/planb/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="templates/planb/css/font-awesome/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="templates/planb/css/custom.css" rel="stylesheet">
    <!--    pickadate-->
    <link href="templates/planb/css/default.css" rel="stylesheet">
    <link href="templates/planb/css/default.date.css" rel="stylesheet">
</head>

<!-- Body -->
<body class="nav-md site footer_fixed <?php echo $option
    . ' view-' . $view
    . ($layout ? ' layout-' . $layout : ' no-layout')
    . ($task ? ' task-' . $task : ' no-task')
    . ($itemid ? ' itemid-' . $itemid : '')
    . ($params->get('fluidContainer') ? ' fluid' : '');
?>">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 navbar-fixed left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                </div>

                <div class="clearfix"></div>

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <jdoc:include type="modules" name="navigation"/>
                    </div>
                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <div class="navbar-left">
                        Passatge de Nogués nº53 <br> <a href="mailto:irregularesplanb@gmail.com">irregularesplanb@gmail.com</a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <?php if ($user->guest): ?>
                                <a data-toggle="modal"
                                   href="<?php echo 'index.php?option=com_users&view=login&tmpl=component'; ?>"
                                   data-target="#myModal">
                                    <span class="fa fa-sign-in"></span> Identificarse
                                </a>
                                <?php
                                $usersConfig = JComponentHelper::getParams('com_users');
                                if ($usersConfig->get('allowUserRegistration')) : ?>
                                    <a class="btn btn-primary" data-toggle="modal"
                                       href="index.php?option=com_users&view=registration&tmpl=component"
                                       data-target="#myModal2">
                                        <span class="glyphicon glyphicon-plus-sign"></span> Registrarse
                                    </a>
                                <?php endif; ?>
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Login</h4>

                                            </div>
                                            <div class="modal-body">
                                                <div class="te"></div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Registration</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="te"></div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            <?php else:

                                ?>

                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fa fa-profile"></i><?php echo $user->name; ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="component/users/?task=profile.edit&user_id=<?php echo $user->id; ?>">
                                            <span class="fa fa-user"></span> Editar perfil
                                            <!--<?php echo $user->name; ?>-->
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:document.formlogout.submit();">
                                            <span class="fa glyphicon fa-sign-out"></span> Salir
                                        </a>
                                    </li>
                                </ul>
                                <form name="formlogout" id="formlogout" method="POST"
                                      action="index.php?option=com_users&task=user.logout">
                                    <input type="hidden" name="return"
                                           value="<?php echo base64_encode(JURI::base()); ?>"/>
                                    <?php echo JHtml::_('form.token'); ?>
                                </form>
                                <?php
                            endif;
                            ?>
                        </li>
                        <li>
                            <jdoc:include type="modules" name="header-social" style="none"/>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">

            <!-- Begin Content -->
            <a href="<?php echo $this->baseurl; ?>">
                <?php echo $logo; ?><?php if ($this->params->get('sitedescription')) {
                    echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>';
                } ?>
            </a>
            <jdoc:include type="modules" name="above-component" style="xhtml"/>
            <jdoc:include type="modules" name="banner" style="xhtml"/>
            <jdoc:include type="message"/>
            <jdoc:include type="component"/>
            <jdoc:include type="modules" name="below-component" style="none"/>
            <!-- End Content -->
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <jdoc:include type="modules" name="footer" style="none"/>
            <div class="pull-left">
                &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
            </div>
            <div class="pull-right">
                Powered by <a target="_blank" href="http://es.linkedin.com/in/joanpiferrer/">Joan Piferrer</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="templates/planb/js/jQuery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="templates/planb/js/bootstrap/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="templates/planb/js/custom.js"></script>
<script src="templates/planb/js/helper.js"></script>
<!-- pickadate -->
<script src="/templates/planb/js/picker.js"></script>
<script src="/templates/planb/js/picker.date.js"></script>
<script src="/templates/planb/js/es_ES.js"></script>
<script src="/templates/planb/js/moment/moment.min.js"></script>
<script src="/templates/planb/js/moment/es.js"></script>

<script src="/components/com_bookatable/assets/vue.js"></script>
<script src="/components/com_bookatable/assets/vue-resource.min.js"></script>
<script src="/components/com_bookatable/assets/dashboard.js"></script>
<script>
    $(document).ready(function() {
        var yesterday = new Date((new Date()).valueOf()-1000*60*60*24);
        $('.datepicker').pickadate({
            format: 'yyyy-mm-dd',
            firstDay: 1,
            disable: [
                { from: [0,0,0], to: yesterday }
            ]
        });
    });
</script>

<jdoc:include type="modules" name="debug" style="none"/>
</body>

</html>
