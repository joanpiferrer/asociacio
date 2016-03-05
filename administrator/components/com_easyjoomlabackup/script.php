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

class Com_EasyJoomlaBackupInstallerScript
{
    function install($parent)
    {
        $manifest = $parent->get('manifest');
        $parent = $parent->getParent();
        $source = $parent->getPath('source');

        $installer = new JInstaller();

        foreach($manifest->plugins->plugin as $plugin)
        {
            $attributes = $plugin->attributes();
            $plg = $source.'/'.$attributes['folder'].'/'.$attributes['plugin'];
            $installer->install($plg);
        }
    }

    function uninstall($parent)
    {
        // Not needed at the moment
    }

    function update($parent)
    {
        $manifest = $parent->get('manifest');
        $parent = $parent->getParent();
        $source = $parent->getPath('source');

        $installer = new JInstaller();

        foreach($manifest->plugins->plugin as $plugin)
        {
            $attributes = $plugin->attributes();
            $plg = $source.'/'.$attributes['folder'].'/'.$attributes['plugin'];
            $installer->install($plg);
        }
    }

    function postflight($type, $parent)
    {
        $db = JFactory::getDbo();

        // Enable the cronjob plugin
        $db->setQuery("UPDATE ".$db->quoteName('#__extensions')." SET ".$db->quoteName('enabled')." = 1 WHERE ".$db->quoteName('element')." = 'easyjoomlabackupcronjob' AND ".$db->quoteName('type')." = 'plugin'");
        $db->execute();
    }

}