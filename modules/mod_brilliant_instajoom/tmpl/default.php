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

$i = 1;
echo '<div class="insta_container">';

echo '</div>';


if ($DISPLAY_DEV_LINK == 1)
	echo '<div><a class = "dev_link" target="_blank" href = "http://yuragalin.com/joomla-instagram-module">' . JText::_('MOD_BRILLIANT_INSTAJOOM_DEV_TEXT') . '</a></div>';

?>
<div class="x_panel">
	<div class="x_title">
		<h2>Está sucediendo en IPB</h2>
		<ul class="nav navbar-right panel_toolbox">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
						class="fa fa-wrench"></i></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Settings 1</a>
					</li>
					<li><a href="#">Settings 2</a>
					</li>
				</ul>
			</li>
			<li><a class="close-link"><i class="fa fa-close"></i></a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">

		<div class="row">


			<?php
			foreach ($InstaPhotos as $item) :
//                echo '<a class = "insta_link" rel="nofollow" target=_blank href = "'.$item["link"].'"><img style = "width: '.$PHOTO_WIDTH.';" class= "instagram_image ';
//                if($DISPLAY_IMG_HOVER_EFFECT==1)
//                    echo 'instagram_hover';
//                echo '" src = "'.$item["images"]["thumbnail"]["url"].'">';
//                echo '<div class="thumbnail-text">'.$item["caption"]["text"].'</div></a>';
				$i++;
				if ($i > $AdminPhotoCount) break;

				?>

				<div class="col-md-3">
					<div class="thumbnail" >
						<a href="<?php echo $item["link"] ?>" target="_blank">
							<div class="image view view-first"style="cursor: pointer">
								<img style="width: 100%; height:100%; display: block;"
								     src="<?php echo $item["images"]["standard_resolution"]["url"] ?>" alt="image">
								<div class="mask">s
								</div>
							</div>
						</a>
						<div class="caption">
							<p><?php echo $item["caption"]["text"]; ?></p>
						</div>

					</div>
				</div>
				<?php
			endforeach;
			?>
		</div>
		<?php if ($DISPLAY_ALL_PHOTOS_LINK == 1)
			echo '<div><a rel="nofollow" target="_blank" href = "http://instagram.com/' . $USER_NAME . '">ver todas las fotos en instagram</a></div>';
		?>
	</div>
</div>
