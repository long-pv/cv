<?php
if (! defined('ABSPATH')) exit; // Bảo vệ không cho truy cập trực tiếp

class Custom_Table_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'custom_table_widget';
    }

    public function get_title()
    {
        return __('Custom Table Widget', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-table';
    }

    public function get_categories()
    {
        return ['custom_widgets_theme'];
    }

    protected function register_controls()
    {
        // Phần tiêu đề cột
        $this->start_controls_section(
            'table_columns_section',
            [
                'label' => __('Table Columns', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'table_columns',
            [
                'label' => __('Columns', 'child_theme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'column_title',
                        'label' => __('Column Title', 'child_theme'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Column Title', 'child_theme'),
                    ],
                ],
                'default' => [],
                'title_field' => '{{{ column_title }}}',
            ]
        );

        $this->end_controls_section();

        // Phần nội dung theo hàng
        $this->start_controls_section(
            'table_rows_section',
            [
                'label' => __('Table Rows', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'table_rows',
            [
                'label' => __('Rows', 'child_theme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'row_content',
                        'label' => __('Row Content', 'child_theme'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => __('Content 1|Content 2|Content 3', 'child_theme'),
                        'description' => __('Separate column content with a pipe (|). Example: Content 1|Content 2|Content 3|..v..v..', 'child_theme'),
                    ],
                ],
                'default' => [],
                'title_field' => '{{{ row_content }}}',
            ]
        );

        $this->end_controls_section();

        // Phần style của bảng
        $this->start_controls_section(
            'table_style_section',
            [
                'label' => __('Table Style', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Chỉnh sửa màu chữ tiêu đề
        $this->add_control(
            'header_text_color',
            [
                'label' => __('Header Text Color', 'child_theme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .custom_table_widget th' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Chỉnh sửa typography tiêu đề
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'label' => __('Header Typography', 'child_theme'),
                'selector' => '{{WRAPPER}} .custom_table_widget th',
            ]
        );

        // Chỉnh sửa màu nền tiêu đề
        $this->add_control(
            'header_background_color',
            [
                'label' => __('Header Background Color', 'child_theme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom_table_widget th' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Chỉnh sửa màu chữ nội dung
        $this->add_control(
            'content_text_color',
            [
                'label' => __('Content Text Color', 'child_theme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .custom_table_widget td' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Chỉnh sửa typography nội dung
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __('Content Typography', 'child_theme'),
                'selector' => '{{WRAPPER}} .custom_table_widget td',
            ]
        );

        // Chỉnh sửa border của bảng và ô
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'table_border',
                'label' => __('Table Border', 'child_theme'),
                'selector' => '{{WRAPPER}} .custom_table_widget, {{WRAPPER}} .custom_table_widget td, {{WRAPPER}} .custom_table_widget th', // Thêm th vào đây
            ]
        );

        // Màu so le từng hàng
        $this->add_control(
            'alternate_row_color',
            [
                'label' => __('Alternate Row Background', 'child_theme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom_table_widget tr:nth-child(odd)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Thêm trường chỉnh sửa padding cho cả td và th
        $this->add_control(
            'table_padding',
            [
                'label' => __('Table Padding',  'child_theme'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom_table_widget td, {{WRAPPER}} .custom_table_widget th' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Lấy số lượng cột trong bảng
        $columns_count = count($settings['table_columns']);

        echo '<table class="custom_table_widget" style="margin: 0px;padding: 0px;">';

        // Hiển thị tiêu đề cột
        echo '<thead><tr>';
        foreach ($settings['table_columns'] as $column) {
            echo '<th>' . esc_html($column['column_title']) . '</th>';
        }
        echo '</tr></thead>';

        // Hiển thị nội dung theo hàng
        echo '<tbody>';
        foreach ($settings['table_rows'] as $row) {
            echo '<tr>';
            $contents = explode('|', $row['row_content']);

            // Lọc số cột cho mỗi hàng (sử dụng chỉ số cột tối đa là $columns_count)
            $contents = array_slice($contents, 0, $columns_count);

            // Hiển thị nội dung cho từng cột, nếu số lượng cột ít hơn thì bổ sung ô trống
            foreach ($contents as $content) {
                echo '<td>' . esc_html($content) . '</td>';
            }

            // Nếu số lượng cột ít hơn số cột của tiêu đề, ta thêm ô trống
            for ($i = count($contents); $i < $columns_count; $i++) {
                echo '<td></td>';
            }

            echo '</tr>';
        }
        echo '</tbody>';

        echo '</table>';
    }
}
