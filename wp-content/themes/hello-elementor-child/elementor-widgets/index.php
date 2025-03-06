<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function register_custom_widgets($widgets_manager)
{
    // include file
    require_once TEMPLATE_PATH . 'header.php';
    require_once TEMPLATE_PATH . 'duplicate_widget.php';
    require_once TEMPLATE_PATH . 'archive_posts.php';
    require_once TEMPLATE_PATH . 'slider_slick.php';
    require_once TEMPLATE_PATH . 'widget_table.php';
    require_once TEMPLATE_PATH . 'breadcrumbs.php';
    require_once TEMPLATE_PATH . 'Latest_Posts.php';

    // Register widgets
    $widgets_manager->register(new \Header_Widget());
    $widgets_manager->register(new \Duplicate_Widget());
    $widgets_manager->register(new \Archive_Posts_Widget());
    $widgets_manager->register(new \Slider_Slick_Widget());
    $widgets_manager->register(new \Custom_Table_Widget());
    $widgets_manager->register(new \Breadcrumbs_Widget());
    $widgets_manager->register(new \Latest_Posts_Widget());
}
add_action('elementor/widgets/register', 'register_custom_widgets');

function register_custom_widget_category($elements_manager)
{
    $elements_manager->add_category(
        'custom_widgets_theme',
        [
            'title' => __('Custom Widgets', 'child_theme'),
            'priority' => 0,
        ]
    );

    $elements_manager->add_category(
        'custom_builder_theme',
        [
            'title' => __('Custom Builder', 'child_theme'),
            'priority' => 1,
        ]
    );
}
add_action('elementor/elements/categories_registered', 'register_custom_widget_category');
