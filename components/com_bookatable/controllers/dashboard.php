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
     * @since    1.6
     */
    public function getModel($name = 'Booking', $prefix = 'BookaTableModel')
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }


    public function getBookings()
    {
        $post = JFactory::getApplication()->input->post;
        $user = JFactory::getUser();
        $db   = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select('b.id, b.date, t.name as table_name, b.evening')
            ->from('#__bookatable_bookings as b')
            ->join('LEFT', '#__bookatable_tables AS t ON b.table_id = t.id')
            ->where('date >= CURDATE()')
            ->where('user_id = ' . $user->id);

        $db->setQuery($query);

        $db->execute();

        if (count($db->loadObjectList()) > 0) {
            $data = array(
                'bookings' => $db->loadObjectList()
            );
        }

        echo json_encode($data);
        die;
    }

    public function getGames()
    {
        $post = JFactory::getApplication()->input->post;
        $user = JFactory::getUser();
        $db   = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select('*')
            ->from('#__bookatable_gamesystems');

        $db->setQuery($query);

        $db->execute();

        if (count($db->loadObjectList()) > 0) {
            $data = array(
                'games' => $db->loadObjectList()
            );
        }

        echo json_encode($data);
        die;
    }

    public function getTables()
    {

        $post = JFactory::getApplication()->input->post;

        $data = array(
            'date' => $post->get('date'),
            'franja' => $post->get('franja'),
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

        foreach ($tables as &$table) {

            $query = $db->getQuery(true);

            $query->select('*')
                ->from('#__bookatable_bookings')
                ->where('date = "' . $data['date'] . '"')
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

    /**
     * @throws Exception
     */
    public function setBooking()
    {
        $post = JFactory::getApplication()->input->post;
        $user = JFactory::getUser();

        $data = array(
            'table_id' => $post->get('table_id'),
            'date' => $post->get('date'),
            'franja' => $post->get('franja'),
            'gamesystem_id' => $post->get('selected_game'),
            'user_id' => $user->id,
        );

        //comprovacio overbooking
        /** @var JDatabaseDriver $db */
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*')
            ->from('#__bookatable_bookings')
            ->where('date = "' . $data['date'] . '"')
            ->where('table_id = ' . $data['table_id'])
            ->where('evening = ' . $data['franja']);

        $db->setQuery($query);

        $db->execute();

        if (count($db->loadObjectList()) > 0) {
            $data = array(
                'success' => false,
                'msg' => "La reserva no se ha podido llevar a cabo, esta mesa ya esta ocupada."
            );
            echo json_encode($data);
            die;

        }

        $query = $db->getQuery(true);

        $query->select('*')
            ->from('#__bookatable_bookings')
            ->where('date > CURDATE()')
            ->where('user_id = ' . $data['user_id']);

        $db->setQuery($query);

        $db->execute();

        if (count($db->loadObjectList()) > 0) {
            $data = array(
                'success' => false,
                'msg' => "La reserva no se ha podido llevar a cabo, has cumplido el cupo de una reserva activa por usuario."
            );
            echo json_encode($data);
            die;
        }


        // Insert new count
        $query->insert('#__bookatable_bookings')
            ->columns(
                array(
                    $db->quoteName('table_id'), $db->quoteName('user_id'),
                    $db->quoteName('date'), $db->quoteName('evening'),
                    $db->quoteName('gamesystem_id')
                )
            )
            ->values($data['table_id'] . ', ' . $data['user_id'] . ',' . $db->quote($data['date']) . ',' . $data['franja'] . ',' . $data['gamesystem_id']);

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            $data = array(
                'success' => false,
                'msg' => $e->getMessage()
            );
            echo json_encode($data);
            die;
        }

        $data = array(
            'success' => true,
            'msg' => "Reserva creada con éxito."
        );

        echo json_encode($data);
        die;
    }

    public function deleteBooking()
    {
        $post = JFactory::getApplication()->input->post;
        $user = JFactory::getUser();

        $data = array(
            'id' => $post->get('id'),
            'user_id' => $user->id,
        );

        /** @var JDatabaseDriver $db */
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // Insert new count
        $query->delete('#__bookatable_bookings')
            ->where('id = '.$data['id'])
            ->where('user_id = '.$data['user_id']);

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            $data = array(
                'success' => false,
                'msg' => $e->getMessage()
            );
            echo json_encode($data);
            die;
        }


        $data = array(
            'success' => true,
            'msg' => "Reserva eliminada con éxito."
        );

        echo json_encode($data);
        die;

    }
}
