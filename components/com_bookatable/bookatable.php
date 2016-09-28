<?php
/**
 * Availability Calendar Site entry point
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

$controller	= JControllerLegacy::getInstance('BookaTable');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
