<?php
/**
 * VN Expert Shortcode
 * 
 * @package VN_Expert
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class VN_Expert_Shortcode {
    
    /**
     * Initialize the shortcode
     */
    public function __construct() {
        add_shortcode('vn_expert', array($this, 'render_shortcode'));
        add_action('wp_head', array($this, 'add_styles'));
    }

    /**
     * Get default attributes
     */
    private function get_default_atts() {
        return array(
            '_id'         => 'expert-' . rand(),
            'speaker'     => 'Giảng viên chính',
            'name'        => '',
            'jobtitle'    => '',
            'image'       => '',
            'padding'     => '6rem 0px 2rem 0px',
            'padding__md' => '2rem 0px 1rem 0px',
            'padding__sm' => '',
            'class'       => 'is-large',
            'visibility'  => '',
        );
    }

    /**
     * Process content truncation
     */
    private function process_content($content, $wordLimit, $_id) {
        if (!$content) return '';

        $content_full = do_shortcode(wp_kses_post($content));
        $detail_btn = sprintf('<a href="#%s">%s</a>', $_id, esc_html__('Xem thêm chi tiết', 'vn-expert'));
        
        // Get total word count
        $total_words = str_word_count(strip_tags($content_full), 0, 
            'àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹ'
        );

        if ($total_words <= $wordLimit) {
            return sprintf('<div class="expert-content">%s</div>', $content_full);
        }

        return $this->truncate_content($content_full, $wordLimit, $detail_btn);
    }

    /**
     * Truncate content to word limit
     */
    private function truncate_content($content_full, $wordLimit, $detail_btn) {
        $paragraphs = array_filter(array_map('trim', explode('</p>', $content_full)));
        $word_count = 0;
        $truncated_content = '';

        foreach ($paragraphs as $p) {
            if (strpos($p, '<p') === false) {
                $p = '<p>' . $p;
            }

            $clean_p = strip_tags($p);
            $p_words = str_word_count($clean_p, 1, 
                'àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹ'
            );
            $current_count = count($p_words);

            if ($word_count + $current_count <= $wordLimit) {
                $truncated_content .= $p . '</p>';
                $word_count += $current_count;
                continue;
            }

            $words_remaining = $wordLimit - $word_count;
            if ($words_remaining > 0) {
                $truncated_content .= $this->truncate_paragraph($p, $p_words, $words_remaining, $detail_btn);
            }
            break;
        }

        return sprintf('<div class="expert-content">%s</div>', $truncated_content);
    }

    /**
     * Truncate single paragraph
     */
    private function truncate_paragraph($p, $p_words, $words_remaining, $detail_btn) {
        preg_match_all('/<[^>]+>/', $p, $tags, PREG_OFFSET_CAPTURE);
        $opening_tags = array();
        $closing_tags = array();

        foreach ($tags[0] as $tag) {
            if (strpos($tag[0], '</') === false) {
                $opening_tags[] = $tag[0];
            } else {
                $closing_tags[] = $tag[0];
            }
        }

        $words = array_slice($p_words, 0, $words_remaining);
        $truncated_p = implode(' ', $words);
        
        return implode('', $opening_tags) . 
               $truncated_p . 
               '... ' . 
               $detail_btn . 
               implode('', array_reverse($closing_tags)) . 
               '</p>';
    }

    /**
     * Render the shortcode
     */
    public function render_shortcode($atts, $content = null) {
        $atts = shortcode_atts($this->get_default_atts(), $atts);
        extract($atts);

        // Process classes
        $classes = array_filter([$class, $visibility]);
        $classes = implode(' ', $classes);

        // Store full content first
        $content_full = do_shortcode(wp_kses_post($content));
        
        // Process truncated content
        $text_content = $this->process_content($content, 120, $_id);

        // Generate HTML elements
        $speaker_html = $speaker ? '<p>' . wp_kses_post($speaker) . '</p>' : '';
        $name_html = $name ? sprintf('<p>%s</p>', wp_kses_post($name)) : '';
        $job_title_html = $jobtitle ? '<p>' . wp_kses_post($jobtitle) . '</p>' : '';

        // Return final shortcode
        return do_shortcode($this->get_template(
            $classes, $padding, $padding__md, $padding__sm,
            $speaker_html, $name_html, $job_title_html,
            $text_content, $image, $_id, $content_full
        ));
    }

    /**
     * Get shortcode template
     */
    private function get_template($classes, $padding, $padding__md, $padding__sm,
                                $speaker_html, $name_html, $job_title_html,
                                $text_content, $image, $_id, $content_full) {
        return sprintf(
            '[row v_align="bottom" class="%1$s"]
                [col span="7" span__sm="12" padding="%2$s" padding__md="%3$s" padding__sm="%4$s"]
                    [ux_text class="is-xxxlarge strong"]%5$s[/ux_text]
                    [ux_text text_color="rgb(255, 222, 89)" class="is-larger strong mb-0"]%6$s[/ux_text]
                    [ux_text class="is-larger is-italic"]%7$s[/ux_text]
                    %8$s
                [/col]
                [col span="5" span__sm="12" class="pb-0"]
                    [ux_image id="%9$s" width__sm="100" width__md="100"]
                [/col]
            [/row]
            [lightbox id="%10$s" width="800px" padding="20px"]
                [ux_text class="is-xxxlarge strong"]%5$s[/ux_text]
                [ux_text text_color="#04643c" class="is-larger strong mb-0"]%6$s[/ux_text]
                [ux_text class="is-larger is-italic"]%7$s[/ux_text]
                %11$s
            [/lightbox]',
            esc_attr($classes),
            esc_attr($padding),
            esc_attr($padding__md),
            esc_attr($padding__sm),
            $speaker_html,
            $name_html,
            $job_title_html,
            $text_content,
            $image,
            $_id,
            $content_full
        );
    }

    /**
     * Add custom styles
     */
    public function add_styles() {
        ?>
        <style>
            .expert-content a:hover {
                color: rgb(255, 222, 89);
            }
            @media screen and (max-width: 34.3125em) {
                .mfp-container {
                    padding: 0;
                }
            }
        </style>
        <?php
    }
}

// Initialize shortcode
new VN_Expert_Shortcode();