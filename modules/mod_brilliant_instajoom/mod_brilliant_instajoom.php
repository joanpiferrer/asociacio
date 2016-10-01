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

// подключаем наш хелпер
use MetzWeb\Instagram\Instagram;

$instagram = new Instagram(array(
    'apiKey'      => 'e454f03697234f9e9334cc13bb5cbbd0',
    'apiSecret'   => '20b2d7143e2547f79aa2f0a659b1f559',
    'apiCallback' => 'http://irregularesplanb.hol.es'
));
//TODO fer la autenticacio i capturar el tema

//подключаем CSS
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_brilliant_instajoom/tmpl/style.css');

//берем параметры из файла конфигурации
$AdminPhotoCount = $params->get('AdminPhotoCount');
$CLIENT_ID = $params->get('CLIENT_ID');
$USER_ID = $params->get('USER_ID');
$PHOTO_WIDTH = $params->get('PHOTO_WIDTH');
$USER_NAME = $params->get('USER_NAME');
$DISPLAY_DEV_LINK = $params->get('DISPLAY_DEV_LINK');
$DISPLAY_ALL_PHOTOS_LINK = $params->get('DISPLAY_ALL_PHOTOS_LINK');
$DISPLAY_IMG_HOVER_EFFECT = $params->get('DISPLAY_IMG_HOVER_EFFECT');

//вызываем метод getInstaPhotos(), который находится в хелпере
//$InstaPhotos = modBrilliantInstaJoom::getInstaPhotos($CLIENT_ID, $USER_NAME);

//подключаем html-шаблон для вывода содержания модуля (шаблон default).
//require JModuleHelper::getLayoutPath('mod_brilliant_instajoom', $params->get('layout', 'default'));
