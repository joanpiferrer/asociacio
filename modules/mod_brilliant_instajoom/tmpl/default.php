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
<div class="row">
    <div class="col-md-9">
        <div id="instagram" class="x_panel">
            <div class="x_title">
                <h1>Asociación Irregulares de Planb</h1>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="row">


                    <template v-for="photo in media | slice 0 <?php echo $AdminPhotoCount ?>">
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <a v-bind:href="photo.link" target="_blank">
                                    <div class="image view view-first" style="cursor: pointer">
                                        <img style="width: 100%; height:100%; display: block;"
                                             v-bind:src="photo.images.standard_resolution.url" alt="image">
                                        <div class="mask">s
                                        </div>
                                    </div>
                                </a>
                                <div class="caption">
                                    <p>{{photo.caption.text}}</p>
                                </div>

                            </div>
                        </div>
                    </template>
                </div>
                <?php if ($DISPLAY_ALL_PHOTOS_LINK == 1)
                    echo '<div><a rel="nofollow" target="_blank" href = "http://instagram.com/' . $USER_NAME . '">ver todas las fotos en instagram</a></div>';
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div id="stadistics" class="x_panel">
            <div class="x_title">
                <h2>A que se juega?</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="x_content">
                    <div class="widget_summary" v-for="stat in stats">
                        <div class="w_left w_25">
                            <span>{{stat.name}}</span>
                        </div>
                        <div class="w_center w_55">
                            <div class="progress">
                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{stat.percent}}" aria-valuemin="0" aria-valuemax="100" v-bind:style="{width: stat.percent+'%'};">
                                    <span class="sr-only">{{stat.percent}}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="w_right w_20">
                            <span>{{stat.valor}}</span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    // create a new Vue instance and mount it to our div element above with the id of app
    var instagram = new Vue({
        el: '#instagram',
        data: {
            client_id: '<?php echo $client_id ?>',
            media: {}
        },
        methods: {
            getMedia: function () {

                $.ajax({
                    type: "GET",
                    dataType: "jsonp",
                    url: 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' + instagram.client_id,
                    success: function (data) {
                        instagram.media = data.data;
                    }
                });

            }
        }
    });


    stadistics = new Vue({
        el: '#stadistics',
        data: {
            stats: {}
        },
        methods: {
            getStats: function() {
                this.$http.get('/index.php?option=com_bookatable&task=dashboard.getStats').then((response) => {
                    stadistics.stats = JSON.parse(response.body).stats;
            }, (response) => {
                    // error callback
                    alert('Ha ocurrido un error vuelve a cargar la página e intentalo otra vez.');
                });
            }
        }
    });

    Vue.filter('slice', function (value, begin, end) {
        return value.slice(begin, end)
    });

    instagram.getMedia();
    stadistics.getStats();

</script>
