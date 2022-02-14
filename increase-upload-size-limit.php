<?php

/**
 * Plugin Name: Increase Upload Limit
 * Description: Easiest way to increase WordPress Upload File Size Limit
 * Plugin URI: https://wpadminify.com
 * Author: Jewel Theme
 * Version: 2.0.2
 * Author URI: https://wpadminify.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: iusl
 * Domain Path: /languages
 * 
*/


$jltiusl_plugin_data     = get_file_data(__FILE__,  array(
    'Version'       => 'Version',
    'Plugin Name'   => 'Plugin Name',
    'Author'        => 'Author',
    'Description'   => 'Description',
    'Plugin URI'    => 'Plugin URI',
), false);

if (!defined('IUSL')) define('IUSL', $jltiusl_plugin_data['Plugin Name']);
if (!defined('IUSL_VER')) define('IUSL_VER', $jltiusl_plugin_data['Version']);
if (!defined('IUSL_TD')) define('IUSL_TD', 'wp-adminify');


if (!class_exists('IUSL\\JLT_IUSL')) {

    // Instantiate Increase Upload Size Limit Class
    require_once dirname(__FILE__) . '/class-iusl.php';
}
