<?php

defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_banners/helpers/banner.php';
$doc             = JFactory::getDocument();

//$doc->addScript("templates/planb/bootstrap/js/carousel.js");

$baseurl = JUri::base();
$n = 0;
?>

<?php if ($headerText) : ?>
    <?php echo $headerText; ?>
<?php endif; ?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="5000">

    <div class="carousel-inner">
        <?php foreach ($list as $item) : ?>
            <?php $link = JRoute::_('index.php?option=com_banners&task=click&id=' . $item->id); ?>
            <?php $n++; ?>
            <?php $class = ($n == 1) ? "active" : ""; ?>
            <?php if ($item->type == 1) : ?>
                <?php // Text based banners ?>
                <?php echo str_replace(array('{CLICKURL}', '{NAME}'), array($link, $item->name), $item->custombannercode); ?>
            <?php else: ?>
                <?php $imageurl = $item->params->get('imageurl'); ?>
                <?php $width = $item->params->get('width'); ?>
                <?php $height = $item->params->get('height'); ?>
                <?php if (BannerHelper::isImage($imageurl)) : ?>
                    <?php // Image based banner ?>
                    <?php $alt = $item->params->get('alt'); ?>
                    <?php $alt = $alt ? $alt : $item->name; ?>
                    <?php $alt = $alt ? $alt : JText::_('MOD_BANNERS_BANNER'); ?>
                    <?php if ($item->clickurl) : ?>
                        <?php // Wrap the banner in a link?>
                        <?php $target = $params->get('target', 1); ?>
                        <?php if ($target == 1) : ?>
                            <?php // Open in a new window?>
                            <div class="item <?php echo $class; ?>">
                                <a
                                    href="<?php echo $link; ?>" target="_blank"
                                    title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>">
                                    <img
                                        src="<?php echo $baseurl . $imageurl; ?>"
                                        alt="<?php echo $alt; ?>"
                                        <?php if (!empty($width)) echo 'width ="' . $width . '"'; ?>
                                        <?php if (!empty($height)) echo 'height ="' . $height . '"'; ?>
                                        />
                                </a>
                            </div>
                        <?php elseif ($target == 2): ?>
                            <?php // open in a popup window?>
                            <div class="item <?php echo $class; ?>">
                                <a
                                    href="<?php echo $link; ?>" onclick="window.open(this.href, '',
								'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');
								return false"
                                    title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>">
                                    <img
                                        src="<?php echo $baseurl . $imageurl; ?>"
                                        alt="<?php echo $alt; ?>"
                                        <?php if (!empty($width)) echo 'width ="' . $width . '"'; ?>
                                        <?php if (!empty($height)) echo 'height ="' . $height . '"'; ?>
                                        />
                                </a>
                            </div>
                        <?php
                        else : ?>
                            <?php // open in parent window?>
                            <div class="item <?php echo $class; ?>">
                                <a
                                    href="<?php echo $link; ?>"
                                    title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>">
                                    <img
                                        src="<?php echo $baseurl . $imageurl; ?>"
                                        alt="<?php echo $alt; ?>"
                                        <?php if (!empty($width)) echo 'width ="' . $width . '"'; ?>
                                        <?php if (!empty($height)) echo 'height ="' . $height . '"'; ?>
                                        />
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php // Just display the image if no link specified?>
                        <div class="item <?php echo $class; ?>">
                            <img
                                src="<?php echo $baseurl . $imageurl; ?>"
                                alt="<?php echo $alt; ?>"
                                <?php if (!empty($width)) echo 'width ="' . $width . '"'; ?>
                                <?php if (!empty($height)) echo 'height ="' . $height . '"'; ?>
                                />
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>
    <?php $n = 0;?>
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($list as $item) : ?>
            <?php $class = ($n == 0) ? "active" : ""; ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?php echo $n; ?>"
                class="<?php echo $class; ?>"></li>
            <?php $n++; ?>
        <?php endforeach; ?>

    </ol>
    <!-- Controls-->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>

<script>
    jQuery('.carousel').carousel();
</script>

<?php if ($footerText) : ?>
    <div class="bannerfooter">
        <?php echo $footerText; ?>
    </div>
<?php endif; ?>
