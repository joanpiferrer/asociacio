<?php
/**
 * EJB - Easy Joomla Backup for Joomal! 3.x
 * License: GNU/GPL - http://www.gnu.org/licenses/gpl.html
 * Author: Viktor Vogel
 * Project page: http://joomla-extensions.kubik-rubik.de/ejb-easy-joomla-backup
 *
 * @license GNU/GPL
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class EasyJoomlaBackupViewCreatebackup extends JViewLegacy
{
    function display($tpl = null)
    {
        $task = JFactory::getApplication()->input->get('task');

        if($task == 'fullbackup')
        {
            JToolBarHelper::title(JText::_('COM_EASYJOOMLABACKUP').' - '.JText::_('COM_EASYJOOMLABACKUP_CREATEBACKUP_FULLBACKUP'), 'easyjoomlabackup-add');
        }
        elseif($task == 'databasebackup')
        {
            JToolBarHelper::title(JText::_('COM_EASYJOOMLABACKUP').' - '.JText::_('COM_EASYJOOMLABACKUP_CREATEBACKUP_DATABASEBACKUP'), 'easyjoomlabackup-add');
        }
        elseif($task == 'filebackup')
        {
            JToolBarHelper::title(JText::_('COM_EASYJOOMLABACKUP').' - '.JText::_('COM_EASYJOOMLABACKUP_CREATEBACKUP_FILEBACKUP'), 'easyjoomlabackup-add');
        }

        JToolBarHelper::custom('backup_create_'.JFactory::getApplication()->input->get('task'), 'new', 'new', JText::_('COM_EASYJOOMLABACKUP_CREATEBACKUP_BUTTON'), false);
        JToolBarHelper::cancel('cancel');

        $document = JFactory::getDocument();
        $document->addStyleSheet('components/com_easyjoomlabackup/css/easyjoomlabackup.css');

        // Get donation code message
        require_once JPATH_COMPONENT.'/helpers/easyjoomlabackup.php';
        $donation_code_message = EasyJoomlaBackupHelper::getDonationCodeMessage();
        $this->donation_code_message = $donation_code_message;

        parent::display($tpl);
    }

}
