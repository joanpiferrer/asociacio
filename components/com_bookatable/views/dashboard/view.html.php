<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Bookatable Site view
 *
 * @package    	com_bookatable
 * @subpackage 	components
 * @link
 * @license			GNU/GPL
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the AvailCal Component
 */
class BookaTableViewDashboard extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		$doc = JFactory::getDocument();

		// Display the view
		parent::display($tpl);

	}
}
