<?php
define('CHILD_URI', get_stylesheet_directory_uri());
define('CHILD_PATH', get_stylesheet_directory());
define('TEMPLATE_PATH', CHILD_PATH . '/elementor-widgets/template/');
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

// turn off auto update core wp
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);

/**
 * Enqueue scripts and styles.
 */
function child_theme_scripts()
{
    wp_enqueue_style('child_theme-style', CHILD_URI, array(), _S_VERSION);

    // normalize
    wp_enqueue_style('child_theme-style-normalize', CHILD_URI . '/assets/inc/normalize/normalize.css', array(), _S_VERSION);

    // bootstrap grid
    wp_enqueue_style('child_theme-style-grid', CHILD_URI . '/assets/inc/bootstrap/grid.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-bootstrap', CHILD_URI . '/assets/inc/bootstrap/bootstrap.min.js', array('jquery'), _S_VERSION, true);

    // jquery ui
    // wp_enqueue_style('child_theme-style-jquery-ui', CHILD_URI . '/assets/inc/jquery-ui/jquery-ui.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-jquery-ui', CHILD_URI . '/assets/inc/jquery-ui/jquery-ui.js', array('jquery'), _S_VERSION, true);

    // slick
    // wp_enqueue_style('child_theme-style-slick-theme', CHILD_URI . '/assets/inc/slick/slick-theme.css', array(), _S_VERSION);
    // wp_enqueue_style('child_theme-style-slick', CHILD_URI . '/assets/inc/slick/slick.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-slick', CHILD_URI . '/assets/inc/slick/slick.min.js', array('jquery'), _S_VERSION, true);

    // flatpickr
    // wp_enqueue_style('child_theme-style-flatpickr', CHILD_URI . '/assets/inc/flatpickr/flatpickr.min.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-flatpickr', CHILD_URI . '/assets/inc/flatpickr/flatpickr.js', array('jquery'), _S_VERSION, true);

    // validate
    // wp_enqueue_script('child_theme-script-validate', CHILD_URI . '/assets/inc/validate/jquery.validate.min.js', array('jquery'), _S_VERSION, true);

    // matchHeight
    wp_enqueue_script('child_theme-script-matchHeight', CHILD_URI . '/assets/inc/matchHeight/jquery.matchHeight.js', array('jquery'), _S_VERSION, true);

    // intlTelInput
    // wp_enqueue_style('child_theme-style-intlTelInput', CHILD_URI . '/assets/inc/intlTelInput/intlTelInput.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-intlTelInput', CHILD_URI . '/assets/inc/intlTelInput/intlTelInput.js', array('jquery'), _S_VERSION, true);

    // select2
    // wp_enqueue_style('child_theme-style-select2', CHILD_URI . '/assets/inc/select2/select2.css', array(), _S_VERSION);
    // wp_enqueue_script('child_theme-script-select2', CHILD_URI . '/assets/inc/select2/select2.js', array('jquery'), _S_VERSION, true);

    // add custom main css/js
    wp_enqueue_style('child_theme-style-main', CHILD_URI . '/assets/css/main.css', array(), _S_VERSION);
    wp_enqueue_script('child_theme-script-main', CHILD_URI . '/assets/js/main.js', array('jquery'), _S_VERSION, true);

    // ajax admin
    wp_localize_script('hello-child-ajax_url', 'custom_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'child_theme_scripts');

// Setup theme setting page
if (function_exists('acf_add_options_page')) {
    $name_option = 'Theme Settings';
    acf_add_options_page(
        array(
            'page_title' => $name_option,
            'menu_title' => $name_option,
            'menu_slug' => 'theme-settings',
            'capability' => 'edit_posts',
            'redirect' => false,
            'position' => 80
        )
    );
}

// auto active plugins
function activate_my_plugins()
{
    $plugins = [
        'advanced-custom-fields-pro\acf.php',
        'elementor\elementor.php',
    ];

    foreach ($plugins as $plugin) {
        $plugin_path = WP_PLUGIN_DIR . '/' . $plugin;

        if (file_exists($plugin_path) && !is_plugin_active($plugin)) {
            activate_plugin($plugin);
        }
    }
}
add_action('admin_init', 'activate_my_plugins');

// stop upgrading wp cerber plugin
add_filter('site_transient_update_plugins', 'disable_plugins_update');
function disable_plugins_update($value)
{
    // disable acf pro
    if (isset($value->response['advanced-custom-fields-pro/acf.php'])) {
        unset($value->response['advanced-custom-fields-pro/acf.php']);
    }
    return $value;
}

// include file function
require CHILD_PATH . '/inc/security.php';
require CHILD_PATH . '/inc/ajax.php';
require CHILD_PATH . '/inc/custom_theme.php';

// load widgets library
function load_custom_widgets()
{
    require CHILD_PATH . '/elementor-widgets/index.php';
}
add_action('elementor/init', 'load_custom_widgets');
