<?php
/**
 * BookaTable Administrator entry point
 *
 * @package    	com_bookatable
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Bookatable
$controller = JControllerLegacy::getInstance('BookaTable');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
