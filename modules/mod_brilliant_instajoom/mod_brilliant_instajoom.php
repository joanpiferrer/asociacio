<?php
/**
* @version 1.0.0 $ 18.01.2014
* @package brilliant_instajoom
* @copyright (C) 2014 Yuriy Galin
* @license GNU General Public License version 3 or later
*
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

defined('_JEXEC') or die;


$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_brilliant_instajoom/tmpl/style.css');

$AdminPhotoCount = $params->get('AdminPhotoCount');
$client_id = $params->get('CLIENT_ID');
$USER_ID = $params->get('USER_ID');
$PHOTO_WIDTH = $params->get('PHOTO_WIDTH');
$USER_NAME = $params->get('USER_NAME');
$DISPLAY_ALL_PHOTOS_LINK = $params->get('DISPLAY_ALL_PHOTOS_LINK');

$tag = 'irregularesplanb';
$client_id = "3989015589.3a9e90b.975f8a629b814302a21be4260ec0eacb";

require JModuleHelper::getLayoutPath('mod_brilliant_instajoom', $params->get('layout', 'default'));
