<?php

defined('_JEXEC') or die('Restricted access');

/**
 * @package             Joomla
 * @subpackage          CoalaWeb Gears
 * @author              Steven Palmer
 * @author url          http://coalaweb.com
 * @author email        support@coalaweb.com
 * @license             GNU/GPL, see /assets/en-GB.license.txt
 * @copyright           Copyright (c) 2014 Steven Palmer All rights reserved.
 *
 * CoalaWeb Contact is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
jimport('joomla.plugin.plugin');
jimport('joomla.environment.browser');
jimport('joomla.filesystem.file');
jimport('joomla.application.module.helper');

class plgSystemCwgears extends JPlugin {

    var $pinterest;

    function __construct(&$subject, $config) {
        parent::__construct($subject, $config);

        // load the CoalaWeb Gears language file
        $lang = JFactory::getLanguage();
        if ($lang->getTag() != 'en-GB') {
            // Loads English language file as fallback (for undefined stuff in other language files)
            $lang->load('plg_system_cwgears', JPATH_ADMINISTRATOR, 'en-GB');
        }
        $lang->load('plg_system_cwgears', JPATH_ADMINISTRATOR, null, 1);
    }

    public function onAfterRoute() {

        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        $option = JRequest::getCmd('option');
        $ext = JRequest::getCmd('extension');
        $baseUrl = '../media/coalaweb/';


        if (JFactory::getApplication()->isAdmin()) {

            if ($option == 'com_categories' && ($ext == 'com_coalawebquotes' || $ext == 'com_coalawebmarket' || $ext == 'com_coalawebtraffic')) {
                if (version_compare(JVERSION, '3.0', '>')) {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base-j3.css");
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-categories.css");
                } else {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base.css");
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-categories.css");
                }
            }

            if (in_array($option, array('com_coalawebcontact', 'com_coalawebsociallinks', 'com_coalawebtraffic', 'com_coalawebmarket', 'com_coalawebpaypal'))) {

                if (version_compare(JVERSION, '3.0', '>')) {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base-j3.css");
                } else {
                    $doc->addStyleSheet($baseUrl . "components/generic/css/com-coalaweb-base.css");
                }
            }
        }
    }

    public function onBeforeCompileHead() {

        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();

        //Jquery Loading--------------------------------------------------------
        $loadJquery = $this->params->get('jquery_on', 0);
        if ($loadJquery && !$app->isAdmin()) {

            // Let create a link to our local directory.
            $localURL = JURI::root(true) . "/media/coalaweb/plugins/system/gears/js";

            // Lets choose the location we want to use.
            switch ($this->params->get("jquery_server")) {

                case 1: // code.jquery.com
                    $url = "//code.jquery.com/jquery-" . $this->params->get("jquery_library") . ".min.js";
                    break;

                case 2: // ajax.googleapis.com
                    $url = "//ajax.googleapis.com/ajax/libs/jquery/" . $this->params->get("jquery_library") . "/jquery.min.js";
                    break;

                case 3: // ajax.aspnetcdn.com
                    $url = "//ajax.aspnetcdn.com/ajax/jQuery/jquery-" . $this->params->get("jquery_library") . ".min.js";
                    break;

                case 4: // cdnjs.cloudflare.com
                    $url = "//cdnjs.cloudflare.com/ajax/libs/jquery/" . $this->params->get("jquery_library") . "/jquery.min.js";
                    break;

                default: // Localhost
                    $url = $localURL . "/jquery-" . $this->params->get("jquery_library") . ".min.js";
                    break;
            }

            if ($this->params->get("jquery_noconflict")) {
                JHtml::_('behavior.framework');
            }

            $doc->addScript($url);

            if ($this->params->get("jquery_noconflict")) {
                $doc->addScript($localURL . "/jquery-noconflict.js");
            }

            if ($this->params->get("jquery_migrate")) {
                $doc->addScript($localURL . "/jquery-migrate-1.2.1.min.js");
            }

            // Order scripts
            $headData = $doc->getHeadData();

            $allowedJQuery = array("jquery.min.js", "jquery-" . $this->params->get("jquery_library") . ".min.js", "jquery-noconflict.js", "jquery-migrate-1.2.1.min.js");

            $first = array();
            $jquery = array();
            foreach ($headData["scripts"] as $key => $value) {

                if ((false !== strpos($key, "mootools-core-uncompressed.js")) OR ( false !== strpos($key, "mootools-core.js"))) {
                    $first[$key] = $value;
                    unset($headData["scripts"][$key]);
                }

                if ((false !== strpos($key, "mootools-more-uncompressed.js")) OR ( false !== strpos($key, "mootools-more.js"))) {
                    $first[$key] = $value;
                    unset($headData["scripts"][$key]);
                }

                if (false !== strpos($key, "jquery")) {
                    $baseName = basename($key);

                    // Order only jQuery library and no conflict script
                    if (in_array($baseName, $allowedJQuery)) {
                        $jquery[$key] = $value;
                    }
                }
            }

            $jquery = $this->orderLibrarires($jquery);
            $first = array_merge($first, $jquery);

            $second = $headData["scripts"];
            $headData["scripts"] = array_merge($first, $second);

            $doc->setHeadData($headData);

            unset($first);
            unset($second);
            unset($scripts);
            unset($headData);
        }

        //Custom CSS -----------------------------------------------------------
        $ccssAdd = $this->params->get('ccss_add');
        if ($ccssAdd && !$app->isAdmin() && $doc->getType() == 'html') {
            $ccssCode = $this->params->get('ccss_code');
            // Remove comments.
            if ($this->params->get('ccss_remove_comments')) {
                $ccssCode = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $ccssCode);
            }

            // Convert short absolute paths to full absolute paths.
            if ($this->params->get('ccss_full_paths')) {
                $ccssCode = str_replace('url(/', 'url(' . JURI::base(), $ccssCode);
                $ccssCode = str_replace("url('/", "url('" . JURI::base(), $ccssCode);
                $ccssCode = str_replace('url("/', 'url("' . JURI::base(), $ccssCode);
            }

            // Minimize.
            if ($this->params->get('ccss_minimize')) {
                $ccssCode = str_replace(array("\r\n", "\r", "\n", "\t"), '', $ccssCode);
                $ccssCode = preg_replace('/ +/', ' ', $ccssCode); // Replace multiple spaces with single space.
                $ccssCode = trim($ccssCode);  // Trim the string of leading and trailing space.
            }

            $doc->addCustomTag('<style type="text/css">' . $ccssCode . '</style>');
        }

        //Custom Javascript ----------------------------------------------------
        $cjsAdd = $this->params->get('cjs_add');
        if ($cjsAdd && !$app->isAdmin() && $doc->getType() == 'html') {
            $cjsCode = $this->params->get('cjs_code');

            // Remove comments.
            if ($this->params->get('cjs_remove_comments')) {
                $cjsCode = preg_replace('(// .+)', '', $cjsCode);
                $cjsCode = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $cjsCode);
            }

            // Minimize.
            if ($this->params->get('cjs_minimize')) {
                $cjsCode = str_replace(array("\r\n", "\r", "\n", "\t"), '', $cjsCode);
                $cjsCode = preg_replace('/ +/', ' ', $cjsCode); // Replace multiple spaces with single space.
                $cjsCode = trim($cjsCode);  // Trim the string of leading and trailing space.
            }

            $doc->addScriptDeclaration($cjsCode);
        }

        //Async ----------------------------------------------------------------
        $defer = $this->params->get('defer');
        $async = $this->params->get('async');
        if (($defer || $async) && !$app->isAdmin() && $doc->getType() == 'html') {

            $scripts_to_handle = trim((string) $this->params->get('script_list', ''));

            // Detect language
            $lang = JFactory::getLanguage();
            $locale = $lang->getTag();
            $locale = str_replace("-", "_", $locale);

            // Facebook and Google only seem to support es_ES and es_LA for all of LATAM
            $locale = (substr($locale, 0, 3) == 'es_' && $locale != 'es_ES') ? 'es_LA' : $locale;

            if ($scripts_to_handle) {
                $paths = array_map('trim', (array) explode(",", $scripts_to_handle));
                foreach ($paths as $path) {
                    if (strpos($path, 'http') === 0) {
                        continue;
                    }

                    $withoutroot = str_replace(JURI::root(true), '', $path);
                    if ($withoutroot != $path) {
                        $paths[] = $withoutroot;
                    }
                    $withroot = JURI::root(true) . $path;
                    if ($withroot != $path) {
                        $paths[] = $withroot;
                    }
                    $withdomain = JURI::root(false) . $path;
                    if ($withdomain != $path) {
                        $paths[] = $withdomain;
                    }

                    $facebook = '//connect.facebook.net/all.js#xfbml=1';
                    if ($path === $facebook) {
                        $facebookLang = '//connect.facebook.net/' . $locale . '/all.js#xfbml=1';
                        $paths[] = $facebookLang;
                    }
                }

                foreach ($doc->_scripts as $url => $scriptparams) {
                    if (in_array($url, $paths)) {
                        if ($defer) {
                            $doc->_scripts[$url]['defer'] = true;
                        }
                        if ($async) {
                            $doc->_scripts[$url]['async'] = true;
                        }
                    }
                }
            }

            return true;
        }

        //Zoo Editor Tweak -----------------------------------------------------
        $yooEditorTweak = $this->params->get('zoo_editor_tweak');
        if ($yooEditorTweak && $app->isAdmin()) {
            $zooEditorTweak = '.creation-form textarea {width: 100%; height:400px;}';
            $doc->addCustomTag('<style type="text/css">' . $zooEditorTweak . '</style>');
        }
    }

    /**
     * Order jQuery libraries in valid order
     * @param array $libs
     */
    private function orderLibrarires($libs) {

        $strings = array("code.jquery.com", "ajax.googleapis.com", "ajax.aspnetcdn.com", "cdnjs.cloudflare.com", "cwjquery");

        $first = array();
        foreach ($libs as $key => $value) {
            foreach ($strings as $string) {

                if (false !== strpos($key, $string)) {
                    $first[$key] = $value;
                    unset($libs[$key]);
                }
            }
        }

        $first = array_merge($first, $libs);
        return $first;
    }

    function onAfterRender() {
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();

        // Only render for HTML output
        if ($doc->getType() == 'html' && $app->getName() == 'site') {

            //Lets add Pinterest JS if the Social Links module needs it.
            $module = JModuleHelper::getModule('coalawebsociallinks');
            $moduleTwo = JModuleHelper::getModule('coalawebsocialtabs');
            if ($module) {
                $modParams = new JRegistry;
                $modParams->loadString($module->params, 'JSON');
                $this->pinterest = $modParams->get('display_pinterest_bm');
            } elseif ($moduleTwo) {
                $modParams = new JRegistry;
                $modParams->loadString($moduleTwo->params, 'JSON');
                $this->pinterest = $modParams->get('display_pinterest');
            } else {
                return;
            }

            if ($this->pinterest) {
                $body = JResponse::getBody();
                $pos = JString::strpos($body, "//assets.pinterest.com/js/pinit.js");
                if (!$pos) {
                    $body = JString::str_ireplace('</body>', '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>' . "\n</body>", $body);
                    JResponse::setBody($body);
                } else {
                    return;
                }
            }
        }
    }

    function onBeforeRender() {
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        $loadMsg = $this->params->get('sys_msg_demo');

        // Only render for HTML output
        if ($doc->getType() == 'html' && $loadMsg) {
            $classes = JText::_('PLG_CWGEARS_SYSMSG_MSG');
            foreach (array('Message', 'Notice', 'Warning', 'Error') as $type) {
                $app->enqueueMessage($classes, $type);
            }
        }
    }

}
