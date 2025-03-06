<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Breadcrumbs_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Breadcrumbs_Widget';
    }

    public function get_title()
    {
        return __('Breadcrumbs Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-code-bold'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories()
    {
        return ['custom_builder_theme'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="Breadcrumbs_widget">
            <?php wp_breadcrumbs(); ?>
        </div>
<?php
    }
}
