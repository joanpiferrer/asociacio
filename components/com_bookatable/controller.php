<?php
/**
 * Availability Calendar Site Controller
 *
 * @package    	com_availcal
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Availal Component Controller
 */
class BookaTableController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		$vName = $this->input->get('view', 'dashboard');
		$view = $this->getView($vName, 'html');
		$layout = $this->input->get('layout', 'default');
		$view->setLayout($layout);
		// Use the View display method
		$view->display();

	}
}
