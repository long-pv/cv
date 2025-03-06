<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Slider_Slick_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Slider_Slick_Widget';
    }

    public function get_title()
    {
        return 'Slider Slick';
    }

    public function get_icon()
    {
        return 'eicon-code-bold';
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
            'slides',
            [
                'label' => __('Slides', 'child_theme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => __('Image', 'child_theme'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'quantity',
            [
                'label' => __('Quantity', 'child_theme'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 3,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'device_default' => [
                    'desktop' => 3,
                    'tablet' => 2,
                    'mobile' => 1,
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows',
            [
                'label' => __('Arrows', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'child_theme'),
                'label_off' => __('Hide', 'child_theme'),
                'return_value' => 'yes',
                'default' => 'yes',
                'devices' => ['desktop', 'tablet', 'mobile'],
                'device_default' => [
                    'desktop' => 'yes',
                    'tablet' => 'yes',
                    'mobile' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots',
            [
                'label' => __('Dots', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'child_theme'),
                'label_off' => __('Hide', 'child_theme'),
                'return_value' => 'yes',
                'default' => 'yes',
                'devices' => ['desktop', 'tablet', 'mobile'],
                'device_default' => [
                    'desktop' => 'yes',
                    'tablet' => 'yes',
                    'mobile' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['slides'])) {
            echo '<p>' . __('No slides added.', 'plugin-name') . '</p>';
            return;
        }

        // quantity
        $quantity = isset($settings['quantity']) ? $settings['quantity'] : 3;
        $quantity_tablet = isset($settings['quantity_tablet']) ? $settings['quantity_tablet'] : $quantity;
        $quantity_mobile = isset($settings['quantity_mobile']) ? $settings['quantity_mobile'] : $quantity_tablet;

        // Arrows
        $arrows = isset($settings['arrows']) && $settings['arrows'] == 'yes' ? true : false;
        $arrows_tablet = isset($settings['arrows_tablet']) && $settings['arrows_tablet'] == 'yes' ? true : false;
        $arrows_mobile = isset($settings['arrows_mobile']) && $settings['arrows_mobile'] == 'yes' ? true : false;

        // Dots
        $dots = isset($settings['dots']) && $settings['dots'] == 'yes' ? true : false;
        $dots_tablet = isset($settings['dots_tablet']) && $settings['dots_tablet'] == 'yes' ? true : false;
        $dots_mobile = isset($settings['dots_mobile']) && $settings['dots_mobile'] == 'yes' ? true : false;


        $data_slider = [
            'slide_show' => [
                'desktop' => $quantity,
                'tablet' => $quantity_tablet,
                'mobile' => $quantity_mobile,
            ],
            'arrows' => [
                'desktop' => $arrows,
                'tablet' => $arrows_tablet,
                'mobile' => $arrows_mobile,
            ],
            'dots' => [
                'desktop' => $dots,
                'tablet' => $dots_tablet,
                'mobile' => $dots_mobile,
            ],
        ];
?>
        <div class="image-slider-widget">
            <div class="slider-wrapper"
                data-slider="<?php echo htmlspecialchars(json_encode($data_slider), ENT_QUOTES, 'UTF-8'); ?>">
                <?php foreach ($settings['slides'] as $slide) : ?>
                    <div class="slider-item">
                        <img src="<?php echo esc_url($slide['image']['url']); ?>" alt="Slide Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        (function($) {
            var Slider_Slick_Widget = function($scope, $) {
                var data_slider = $scope.find('.slider-wrapper').data('slider');

                // quantity
                var slide_show_desktop = data_slider.slide_show.desktop || 3;
                var slide_show_tablet = data_slider.slide_show.tablet || slide_show_desktop;
                var slide_show_mobile = data_slider.slide_show.mobile || slide_show_tablet;

                // arrows
                var arrows_desktop = data_slider.arrows.desktop || false;
                var arrows_tablet = data_slider.arrows.tablet || false;
                var arrows_mobile = data_slider.arrows.mobile || false;

                // dots
                var dots_desktop = data_slider.dots.desktop || false;
                var dots_tablet = data_slider.dots.tablet || false;
                var dots_mobile = data_slider.dots.mobile || false;

                $scope.find('.slider-wrapper').slick({
                    slidesToShow: slide_show_desktop,
                    slidesToScroll: slide_show_desktop,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    arrows: arrows_desktop,
                    dots: dots_desktop,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: slide_show_tablet,
                                slidesToScroll: slide_show_tablet,
                                arrows: arrows_tablet,
                                dots: dots_tablet,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: slide_show_mobile,
                                slidesToScroll: slide_show_mobile,
                                arrows: arrows_mobile,
                                dots: dots_mobile,
                            }
                        },
                    ]
                });
            };

            $(window).on('elementor/frontend/init', function() {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/Slider_Slick_Widget.default',
                    Slider_Slick_Widget
                );
            });
        })(jQuery);
    </script>
<?php
});
