<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Darkperiods Controller
 */
class BookaTableControllerDashboard extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Booking', $prefix = 'BookaTableModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}


	public function getBookings()
	{
		$post = JFactory::getApplication()->input->post;

		$data = array(
			'date' => $post->get('date')
		);

		echo json_encode($data);
		die;
	}

	public function getTables()
	{

		$post = JFactory::getApplication()->input->post;

		$data = array(
			'date'   => $post->get('date'),
			'franja' => $post->get('franja'),
			'user_id' => $post->get('user_id'),
		);

		/** @var JDatabaseDriver $db */
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*')
			->from('#__bookatable_tables')
			->where('active = 1');

		$db->setQuery($query);

		$db->execute();

		$tables = $db->loadObjectList();

		foreach($tables as &$table){

			$query = $db->getQuery(true);

			$query->select('*')
				->from('#__bookatable_bookings')
				->where('date = "' . $data['date'] .'"')
				->where('table_id = ' . $table->id)
				->where('evening = ' . $data['franja']);

			$db->setQuery($query);

			$db->execute();

			if (count($db->loadObjectList()) > 0) {
				$table->occupied = true;
			}

		}
		$data = array(
			'tables' => $tables
		);

		echo json_encode($data);
		die;
	}
}
