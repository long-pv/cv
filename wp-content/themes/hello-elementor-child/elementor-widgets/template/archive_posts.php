<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Archive_Posts_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Archive_Posts_Widget';
    }

    public function get_title()
    {
        return __('Archive Posts', 'child_theme');
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

        // Thêm ô select để chọn post type
        $this->add_control(
            'post_type',
            [
                'label' => __('Select Post Type', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_post_types()
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Number of Posts', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    10 => '10',
                    15 => '15',
                    20 => '20',
                    25 => '25',
                    30 => '30',
                    35 => '35',
                    40 => '40',
                    45 => '45',
                    50 => '50',
                ],
                'default' => '10',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Number of Columns', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [
                    1 => __('1 Columns', 'child_theme'),
                    2 => __('2 Columns', 'child_theme'),
                    3 => __('3 Columns', 'child_theme'),
                    4 => __('4 Columns', 'child_theme'),
                    6 => __('6 Columns', 'child_theme'),
                    12 => __('12 Columns', 'child_theme'),
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'device_default' => [
                    'desktop' => 3,
                    'tablet' => 2,
                    'mobile' => 1,
                ],
            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label' => __('Enable Pagination', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'child_theme'),
                'label_off' => __('No', 'child_theme'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    private function get_post_types()
    {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }
        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $columns_desktop = $settings['columns'] ?? 1;
        $columns_tablet = $settings['columns_tablet'] ?? 1;
        $columns_mobile = $settings['columns_mobile'] ?? 1;
        $enable_pagination = $settings['enable_pagination'] === 'yes' ? true : false;
        $post_type = $settings['post_type'] ?? 'post';
        $posts_per_page = $settings['posts_per_page'] ?? 10;
        $paging = !empty($_GET['paging']) ? intval($_GET['paging']) : 1;

        $query_args = [
            'post_type' => $post_type,
            'posts_per_page' => $posts_per_page,
            'paged' => $paging,
        ];

        // category
        if (is_category()) {
            $category = get_queried_object();
            $query_args['cat'] = $category->term_id;
        }

        // tag
        if (is_tag()) {
            $tag = get_queried_object();
            $query_args['tag_id'] = $tag->term_id;
        }

        $query_post = new WP_Query($query_args);

        if ($query_post->have_posts()) {
            echo '<div class="archive_post_list">';
            echo '<div class="row archive_post_row">';
            $col_class = 'col-' . (12 / (int) $columns_mobile) . ' col-md-' . (12 / (int) $columns_tablet) . ' col-lg-' . (12 / (int) $columns_desktop);

            while ($query_post->have_posts()):
                $query_post->the_post();
?>
                <div class="<?php echo esc_attr($col_class); ?>">
                    <div class="archive_post_item">
                        <?php if (has_post_thumbnail()): ?>
                            <a class="d-block" href="<?php the_permalink(); ?>">
                                <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
                            </a>
                        <?php endif; ?>
                        <h3><?php echo get_the_title(); ?></h3>
                        <p><?php echo get_the_excerpt(); ?></p>
                    </div>
                </div>
<?php
            endwhile;
            echo '</div>'; // Close .row
            echo '</div>';

            if ($enable_pagination) {
                echo '<div class="pagination">';
                echo paginate_links(
                    array(
                        'total' => $query_post->max_num_pages,
                        'current' => max(1, $paging),
                        'format' => '?paging=%#%',
                        'end_size' => 2,
                        'mid_size' => 1,
                        'prev_text' => __('Prev', 'child_theme'),
                        'next_text' => __('Next', 'child_theme'),
                    )
                );
                echo '</div>';
            }
        } else {
            echo '<p>' . __('There are no articles.', 'child_theme') . '</p>';
        }
        wp_reset_postdata();
    }
}
