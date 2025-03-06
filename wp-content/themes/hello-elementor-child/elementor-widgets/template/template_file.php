<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Custom_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Custom_Widget';
    }

    public function get_title()
    {
        return __('Custom Widget', 'child_theme');
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
        // Thêm trường nhập liệu text
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // 1. Trường nhập liệu Text
        $this->add_control(
            'text_input',
            [
                'label' => __('Text Input', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Default text', 'child_theme'),
            ]
        );

        // 2. Trường Textarea
        $this->add_control(
            'textarea_input',
            [
                'label' => __('Textarea', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Default textarea content', 'child_theme'),
            ]
        );

        // 3. Trường Number
        $this->add_control(
            'number_input',
            [
                'label' => __('Number', 'child_theme'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );

        // 4. Trường Email
        $this->add_control(
            'email_input',
            [
                'label' => __('Email Address', 'child_theme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'email', // Chỉ định loại input là email (HTML5)
                'placeholder' => __('Enter your email', 'child_theme'),
                'default' => '',
            ]
        );

        // 5. Trường URL
        $this->add_control(
            'url_input',
            [
                'label' => __('URL', 'child_theme'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => 'https://example.com',
                    'is_external' => true,
                ],
            ]
        );

        // 6. Trường Checkbox
        $this->add_control(
            'checkbox_input',
            [
                'label' => __('Enable Option', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'child_theme'),
                'label_off' => __('No', 'child_theme'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // 7. Trường Select
        $this->add_control(
            'select_input',
            [
                'label' => __('Select', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'option_1' => __('Option 1', 'child_theme'),
                    'option_2' => __('Option 2', 'child_theme'),
                    'option_3' => __('Option 3', 'child_theme'),
                ],
                'default' => 'option_1',
            ]
        );

        // 8. Trường Color
        $this->add_control(
            'color_input',
            [
                'label' => __('Color', 'child_theme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        // 9. Trường Media
        $this->add_control(
            'media_input',
            [
                'label' => __('Media', 'child_theme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://example.com/image.jpg',
                ],
            ]
        );

        // 10. Trường Slider
        $this->add_control(
            'slider_input',
            [
                'label' => __('Slider', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 50,
                ],
            ]
        );

        // 11. Trường Repeater
        $this->add_control(
            'repeater_input',
            [
                'label' => __('Repeater', 'child_theme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'repeater_item',
                        'label' => __('Item', 'child_theme'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Repeater Item', 'child_theme'),
                    ],
                ],
                'title_field' => '{{{ repeater_item }}}',
            ]
        );

        // 12. Trường WYSIWYG Editor
        $this->add_control(
            'editor_input',
            [
                'label' => __('Editor Input', 'child_theme'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __('Default content', 'child_theme'),
            ]
        );

        // 13. Trường Toggle
        $this->add_control(
            'toggle_input',
            [
                'label' => __('Toggle', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'child_theme'),
                'label_off' => __('No', 'child_theme'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // 14. Trường Range
        $this->add_control(
            'range_input',
            [
                'label' => __('Range', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
            ]
        );

        // lựa chọn post type
        $this->add_control(
            'post_type_select',
            [
                'label' => __('Select Post Type', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post' => __('Post', 'child_theme'),
                    'page' => __('Page', 'child_theme'),
                    'your_custom_post_type' => __('Your Custom Post Type', 'child_theme'), // Add any custom post types here
                ],
                'default' => 'post',
            ]
        );

        // lựa chọn danh sách bài viết
        $this->add_control(
            'post_select',
            [
                'label' => __('Select Post', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT2, // Kiểu chọn SELECT2 giúp dễ dàng tìm kiếm
                'options' => $this->get_post_options(),
                'multiple' => true,
                'label_block' => true,
                'default' => '',
            ]
        );

        // Kiểu control là GALLERY
        $this->add_control(
            'image_gallery',
            [
                'label' => __('Select Images', 'child_theme'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        // Sử dụng control MEDIA để upload file PDF
        $this->add_control(
            'pdf_file',
            [
                'label' => __('Upload PDF File', 'child_theme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['application/pdf'], // Giới hạn loại tệp là PDF
                'default' => [],
            ]
        );

        $this->end_controls_section();
    }

    protected function get_post_options()
    {
        $args = [
            'post_type' => 'post',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $posts = get_posts($args); // Truy vấn bài viết
        $options = [];

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $options[$post->ID] = $post->post_title; // Trả về ID và tiêu đề của bài viết
            }
        }

        return $options; // Trả về danh sách bài viết
    }

    protected function render()
    {
        // Lấy giá trị từ các trường nhập liệu
        $text_input = $this->get_settings_for_display('text_input');
        $textarea_input = $this->get_settings_for_display('textarea_input');
        $number_input = $this->get_settings_for_display('number_input');
        $email_input = $this->get_settings_for_display('email_input');
        $url_input = $this->get_settings_for_display('url_input');
        $checkbox_input = $this->get_settings_for_display('checkbox_input');
        $select_input = $this->get_settings_for_display('select_input');
        $color_input = $this->get_settings_for_display('color_input');
        $media_input = $this->get_settings_for_display('media_input');
        $slider_input = $this->get_settings_for_display('slider_input');
        $repeater_items = $this->get_settings_for_display('repeater_input');
        $editor_input = $this->get_settings_for_display('editor_input');
        $toggle_input = $this->get_settings_for_display('toggle_input');
        $range_input = $this->get_settings_for_display('range_input');
        $selected_post_id = $this->get_settings_for_display('post_select');  // Lấy ID bài viết đã chọn
        $gallery = $this->get_settings_for_display('image_gallery');
        $pdf_file = $this->get_settings_for_display('pdf_file');

        // Bắt đầu render HTML
?>
        <div class="my-custom-widget-1">
            <!-- Hiển thị Text Input -->
            <h2><?php echo esc_html($text_input); ?></h2>

            <!-- Hiển thị Textarea -->
            <p><?php echo esc_html($textarea_input); ?></p>

            <!-- Hiển thị Number Input -->
            <p>Number Input: <?php echo esc_html($number_input); ?></p>

            <!-- Hiển thị Email Input -->
            <p>Email: <?php echo esc_html($email_input); ?></p>

            <!-- Hiển thị URL -->
            <p>URL: <a href="<?php echo esc_url($url_input['url']); ?>" target="_blank"><?php echo esc_html($url_input['url']); ?></a></p>

            <!-- Hiển thị Checkbox -->
            <p>Checkbox: <?php echo ($checkbox_input === 'yes') ? 'Checked' : 'Unchecked'; ?></p>

            <!-- Hiển thị Select -->
            <p>Selected Option: <?php echo esc_html($select_input); ?></p>

            <!-- Hiển thị Color Input -->
            <div style="background-color: <?php echo esc_attr($color_input); ?>; padding: 10px;">
                Selected Color: <?php echo esc_attr($color_input); ?>
            </div>

            <!-- Hiển thị Media -->
            <?php if (!empty($media_input['url'])) : ?>
                <div>
                    <img src="<?php echo esc_url($media_input['url']); ?>" alt="Selected Media" style="max-width:100%;">
                </div>
            <?php endif; ?>

            <!-- Hiển thị Slider -->
            <p>Slider Value: <?php echo esc_html($slider_input['size']); ?>px</p>

            <!-- Hiển thị Repeater Items -->
            <?php if (!empty($repeater_items)) : ?>
                <ul>
                    <?php foreach ($repeater_items as $item) : ?>
                        <li><?php echo esc_html($item['repeater_item']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- Hiển thị Editor Input -->
            <div class="editor-content">
                <?php echo wp_kses_post($editor_input); ?>
            </div>

            <!-- Hiển thị Toggle -->
            <p>Toggle: <?php echo ($toggle_input === 'yes') ? 'ON' : 'OFF'; ?></p>

            <!-- Hiển thị Range -->
            <p>Range Value: <?php echo esc_html($range_input['size']); ?>px</p>

            <?php
            // Nếu người dùng đã chọn bài viết
            if ($selected_post_id) {
                $post = get_post($selected_post_id); // Lấy đối tượng bài viết

                // Hiển thị tiêu đề và nội dung của bài viết
                if ($post) {
                    echo '<h3>' . esc_html($post->post_title) . '</h3>';
                    echo '<p>' . esc_html(get_the_excerpt($post)) . '</p>'; // Hiển thị excerpt của bài viết
                }
            } else {
                echo '<p>No post selected.</p>';
            }

            // render gallery
            if (!empty($gallery)) {
                echo '<div class="custom-widget-gallery">';
                foreach ($gallery as $image) {
                    $image_url = wp_get_attachment_image_url($image['id'], 'full');
                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image['alt']) . '" style="max-width: 100%; margin-bottom: 10px;" />';
                }
                echo '</div>';
            } else {
                echo '<p>No images selected.</p>';
            }

            // render pdf
            if (!empty($pdf_file['url'])) {
                echo '<div class="custom-widget-pdf">';
                echo '<a href="' . esc_url($pdf_file['url']) . '" target="_blank">' . __('Download PDF', 'child_theme') . '</a>';
                echo '</div>';
            } else {
                echo '<p>No PDF file selected.</p>';
            }
            ?>
        </div>
<?php
    }
}
