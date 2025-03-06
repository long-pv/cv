<?php

/**
 * Breadcrumbs
 */
function wp_breadcrumbs()
{
    $delimiter = '
	<span class="icon">
		<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M6.6665 11.3333L9.72861 8.58922C10.0902 8.26515 10.0902 7.73485 9.72861 7.41077L6.6665 4.66666" stroke="#818181" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</span>
	';

    $home = __('Home', 'basetheme');
    $before = '<span class="current">';
    $after = '</span>';
    if (!is_admin() && !is_home() && (!is_front_page() || is_paged())) {

        global $post;

        echo '<nav>';
        echo '<div id="breadcrumbs_custom" class="breadcrumbs_custom" typeof="BreadcrumbList" vocab="https://schema.org/">';

        $homeLink = home_url();
        echo '<a href="' . $homeLink . '">' . $home . '</a>' . $delimiter . ' ';

        switch (true) {
            case is_category() || is_archive():
                $cat_obj = get_queried_object();
                echo $before . $cat_obj->name . $after;
                break;

            case is_single() && !is_attachment():
                $post_type = $post->post_type;

                if ($post_type == 'post') {
                    $categories = get_the_category($post->ID);

                    if (!empty($categories)) {
                        $first_category = $categories[0];
                        echo '<a aria-label="' . $first_category->name . '" href="' . get_category_link($first_category->term_id) . '">' . $first_category->name . '</a>' . $delimiter . ' ';
                    }
                }

                if ($post_type == 'product') {
                    $categories = get_the_terms($post->ID, 'product_cat');

                    if (!empty($categories)) {
                        $first_category = $categories[0];
                        echo '<a aria-label="' . $first_category->name . '" href="' . get_term_link($first_category->term_id, 'product_cat') . '">' . $first_category->name . '</a>' . $delimiter . ' ';
                    }
                }

                echo $before . $post->post_title . $after;
                break;

            case is_page():
                if ($post->post_parent) {
                    $parent_id = $post->ID;
                    echo generate_page_parent($parent_id, $delimiter);
                }

                echo $before . get_the_title() . $after;
                break;

            case is_search():
                echo $before . 'Search' . $after;
                break;

            case is_404():
                echo $before . 'Error 404' . $after;
                break;
        }

        echo '</div>';
        echo '</nav>';
    }
} // end wp_breadcrumbs()

// Generate breadcrumbs ancestor page
function generate_page_parent($parent_id, $delimiter)
{
    $breadcrumbs = [];
    $output = '';

    while ($parent_id) {
        $page = get_post($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id = $page->post_parent;
    }


    $breadcrumbs = array_reverse($breadcrumbs);
    array_pop($breadcrumbs);

    foreach ($breadcrumbs as $crumb) {
        $output .= $crumb . $delimiter;
    }

    return rtrim($output);
}
