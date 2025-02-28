<?php

function vn_expert_shortcode($atts, $content = null)
{
  extract(shortcode_atts(array(
    '_id' => 'expert-' . rand(),
    'speaker' => 'Giảng viên chính',
    'name' => '',
    'jobtitle' => '',
    'image' => '',
    'wordLimit' => 150,
    'padding'     => '6rem 0px 2rem 0px',
    'padding__md' => '2rem 0px 1rem 0px',
    'padding__sm'  => '',
    'class' => 'is-large',
    'visibility' => '',
  ), $atts));


  $classes = array();
  if ($class) $classes[] = $class;
  if ($visibility) $classes[] = $visibility;

  $classes = implode(' ', $classes);

  $detail_btn = '<a href="#' . $_id . '">Xem thêm chi tiết</a>';

  $text_content = '';
  $maxword = absint($wordLimit);
  if ($content) {
    $content_full = do_shortcode(wp_kses_post($content));
    
    // Get total word count first
    $total_words = str_word_count(strip_tags($content_full), 0, 'àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹ');
    
    if ($total_words > $maxword) {
        // Get paragraphs as array and fix missing tags
        $paragraphs = array_filter(array_map('trim', explode('</p>', $content_full)));
        $word_count = 0;
        $truncated_content = '';
        
        foreach ($paragraphs as $p) {
            // Ensure paragraph has opening tag
            if (strpos($p, '<p') === false) {
                $p = '<p>' . $p;
            }
            
            // Clean paragraph and count words
            $clean_p = strip_tags($p);
            $p_words = str_word_count($clean_p, 1, 'àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹ');
            $current_count = count($p_words);
            
            if ($word_count + $current_count <= $maxword) {
                // Add full paragraph
                $truncated_content .= $p . '</p>';
                $word_count += $current_count;
            } else {
                // Get remaining words
                $words_remaining = $maxword - $word_count;
                if ($words_remaining > 0) {
                    // Extract HTML tags and their positions
                    preg_match_all('/<[^>]+>/', $p, $tags, PREG_OFFSET_CAPTURE);
                    $opening_tags = array();
                    $closing_tags = array();
                    
                    // Separate opening and closing tags
                    foreach ($tags[0] as $tag) {
                        if (strpos($tag[0], '</') === false) {
                            $opening_tags[] = $tag[0];
                        } else {
                            $closing_tags[] = $tag[0];
                        }
                    }
                    
                    // Get limited words while preserving HTML
                    $words = array_slice($p_words, 0, $words_remaining);
                    $truncated_p = implode(' ', $words);
                    
                    // Add opening tags at start and closing tags at end
                    $truncated_p = implode('', $opening_tags) . $truncated_p . implode('', array_reverse($closing_tags));
                    
                    // Add ellipsis and ensure paragraph is properly closed
                    $truncated_content .= $truncated_p . '...</p>';
                }
                break;
            }
        }
        
        // Add "View More" button
        $text_content = sprintf(
            '<div class="expert-content">%s %s</div>',
            $truncated_content,
            $detail_btn
        );
    } else {
        $text_content = $content_full;
    }
  }

  $speaker_html = '';
  if ($speaker) $speaker_html = '<p>' . wp_kses_post($speaker) . '</p>';

  $name_html = '';
  if ($name) $name_html = sprintf('<p>%s</p>', wp_kses_post($name));

  $job_title_html = '';
  if ($jobtitle) $job_title_html = '<p>' . wp_kses_post($jobtitle) . '</p>';


  $shortcode = sprintf(
    '
        [row style="collapse" v_align="bottom" class="%s"]

          [col span="7" span__sm="12" padding="%s" padding__md="%s" padding__sm="%s"]

            [ux_text class="is-xxxlarge strong"]
              %s
            [/ux_text]

            [ux_text text_color="rgb(255, 222, 89)" class="is-larger strong mb-0"]
              %s
            [/ux_text]

            [ux_text class="is-larger is-italic"]
              %s
            [/ux_text]
            %s

          [/col]
          [col span="5" span__sm="12" class="pb-0"]

            [ux_image id="%s" width__sm="100" width__md="100"]

          [/col]

        [/row]
        
        ',
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

  return do_shortcode($shortcode);
}

add_shortcode('vn_expert', 'vn_expert_shortcode');

/*
[lightbox id="%s" width="600px" padding="20px"]
  %s
[/lightbox]
 */

