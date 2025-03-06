<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Latest_Posts_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'latest_posts_widget';
    }

    public function get_title()
    {
        return __('Latest Posts Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
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
        $query_args = [
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'order'          => 'DESC',
            'orderby'        => 'date',
        ];

        $query_post = new WP_Query($query_args);
        if ($query_post->have_posts()) {
            echo '<div class="archive_post_list">';
            echo '<div class="row archive_post_row">';

            while ($query_post->have_posts()) {
                $query_post->the_post();
?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="archive_post_item">
                        <a class="archive_post_item_link" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="archive_post_item_img">
                                    <?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
                                </div>
                            <?php endif; ?>
                            <h3 class="archive_post_item_title"><?php echo get_the_title(); ?></h3>
                        </a>
                    </div>
                </div>
<?php
            }
            echo '</div>'; // Close .row
            echo '</div>'; // Close .archive_post_list
        }
        wp_reset_postdata();
    }
}
