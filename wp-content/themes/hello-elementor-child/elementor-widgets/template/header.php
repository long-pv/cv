<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Header_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Header_Widget';
    }

    public function get_title()
    {
        return __('Header', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-code-bold'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories()
    {
        return ['custom_widgets_theme'];
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

        $this->add_control(
            'logo_image',
            [
                'label' => __('Logo Image', 'child_theme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'select_menu',
            [
                'label' => __('Select Menu', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_available_menus(),
                'default' => '',
                'description' => sprintf(
                    __('Manage your menus <a href="%s" target="_blank">here</a>.', 'child_theme'),
                    esc_url(admin_url('nav-menus.php'))
                ),
            ]
        );

        $this->end_controls_section();
    }

    protected function get_available_menus()
    {
        $menus = wp_get_nav_menus();
        $menu_options = [];

        if (!empty($menus)) {
            foreach ($menus as $menu) {
                $menu_options[$menu->slug] = $menu->name;
            }
        } else {
            $menu_options[''] = __('No menus available', 'child_theme');
        }

        return $menu_options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $logo_image = $settings['logo_image'] ?? '';
        $select_menu = $settings['select_menu'] ?? '';
?>
        <header class="header">
            <div class="header__inner">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <?php if ($logo_image['id']) : ?>
                            <a href="<?php echo home_url(); ?>" class="header__logo">
                                <?php echo wp_get_attachment_image($logo_image['id'], 'large'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="col-6 col-lg-9">
                        <div class="header__navInner">
                            <!-- menu PC -->
                            <?php
                            if (!empty($select_menu)) {
                                $menu_exists = wp_get_nav_menu_object($select_menu);
                                if ($menu_exists) {
                                    wp_nav_menu(
                                        array(
                                            'menu' => $select_menu,
                                            'container' => 'nav',
                                            'container_class' => 'header__menupc',
                                            'depth' => 2,
                                        )
                                    );
                                } else {
                                    echo 'Menu not found.';
                                }
                            }
                            ?>
                            <!-- end -->

                            <!-- button toggle menu mobile -->
                            <div class="header__toggle">
                                <span class="header__toggleItem header__toggleItem--open"></span>
                                <span class="header__toggleItem header__toggleItem--close"></span>
                            </div>
                            <!-- end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- menu Mobile -->
        <div class="header__menusp">
            <?php
            if (!empty($select_menu)) {
                $menu_exists = wp_get_nav_menu_object($select_menu);
                if ($menu_exists) {
                    wp_nav_menu(
                        array(
                            'menu' => $select_menu,
                            'container' => 'nav',
                            'container_class' => 'header__menuspInner',
                            'depth' => 2,
                        )
                    );
                } else {
                    echo 'Menu not found.';
                }
            }
            ?>
        </div>
<?php
    }
}
