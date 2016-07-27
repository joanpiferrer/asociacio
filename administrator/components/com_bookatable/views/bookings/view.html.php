<?php
/**
 * 	Bookatable Component Administrator Bookings View
 *
 * 	@package    	com_bookatable
 * 	@subpackage 	components
 * 	@link
 * 	@license			GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Bookings View
 *
 * @package    com_bookatable
 * @subpackage components
 */
class BookaTableViewBookings extends JViewLegacy

{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Accommodations view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 		$state = $this->get('State');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		$this->state = $state;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('BOOKINGS'));
		JToolBarHelper::deleteList('', 'bookings.delete');
		JToolBarHelper::editList('booking.edit');
		JToolBarHelper::addNew('booking.add');
	}

}
