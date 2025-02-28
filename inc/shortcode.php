<?php

function vn_expert_shortcode($atts, $content = null)
{
  extract(shortcode_atts(array(
    '_id' => 'expert-' . rand(),
    'speaker' => 'Giảng viên chính',
    'name' => '',
    'jobtitle' => '',
    'image' => '',
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

  $text_content = '';
  if ($content) {
    $text_content = do_shortcode(wp_kses_post($content));
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

        [/row]',
    esc_attr($classes),
    esc_attr($padding),
    esc_attr($padding__md),
    esc_attr($padding__sm),
    $speaker_html,
    $name_html,
    $job_title_html,
    $text_content,
    $image
  );

  return do_shortcode($shortcode);
}

add_shortcode('vn_expert', 'vn_expert_shortcode');