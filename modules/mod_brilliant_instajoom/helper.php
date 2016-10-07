<?php


/**
 * @version       1.0.0 $ 18.01.2014
 * @package       brilliant_instajoom
 * @copyright (C) 2014 Yuriy Galin
 * @license       GNU General Public License version 3 or later
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

class modBrilliantInstaJoom
{
	function callInstagram($url)
	{
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 2
		));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

}
