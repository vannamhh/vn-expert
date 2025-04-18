<?php
/**
 * VN Expert Builder
 *
 * This file defines and registers the VN Expert UX Builder component.
 *
 * @package vn-expert
 * @since 1.0.0
 */

/**
 * Exit if accessed directly.
 */
function vn_builder_expert() {
	if ( ! function_exists( 'add_ux_builder_shortcode' ) ) {
		return;
	}

	add_ux_builder_shortcode(
		'vn_expert',
		array(
			'type'       => 'container',
			'name'       => __( 'VN Expert', 'ux-builder' ),
			'category'   => __( 'Content' ),
			'thumbnail'  => get_template_directory_uri() . '/inc/builder/shortcodes/thumbnails/team_member.svg',
			'template'   => vn_expert_builder_template( 'vn-expert.html' ),
			'info'       => '{{ text }}',
			'wrap'       => true,
			'directives' => array( 'ux-text-editor' ),
			'allow'      => array( 'text' ),
			'options'    => array(
				'speaker'    => array(
					'type'    => 'textfield',
					'heading' => 'Speaker',
					'default' => 'Giảng viên chính',
				),
				'name'       => array(
					'type'       => 'textfield',
					'heading'    => 'Name',
					'default'    => '',
					'auto_focus' => true,
				),
				'jobtitle'   => array(
					'type'    => 'textfield',
					'heading' => 'Job title',
					'default' => '',
				),
				'image'      => array(
					'type'    => 'image',
					'heading' => 'Ảnh',
				),
				'padding'    => array(
					'type'        => 'margins',
					'heading'     => 'Padding',
					'full_width'  => true,
					'min'         => 0,
					'max'         => 200,
					'step'        => 1,
					'default'     => '6rem 0px 2rem 0px',
					'default__md' => '2rem 0px 1rem 0px',
					'responsive'  => true,
					'unit'        => 'px',
				),
				// Advanced options.
				'class'      => array(
					'type'    => 'textfield',
					'heading' => 'CSS class',
					'default' => 'is-large',
				),
				'visibility' => array(
					'type'    => 'select',
					'heading' => __( 'Visibility' ),
					'default' => '',
					'options' => array(
						''                => 'Visible',
						'hidden'          => 'Hidden',
						'hide-for-medium' => 'Hide for Medium/Mobile',
						'show-for-medium' => 'Show for Medium/Mobile only',
						'show-for-small'  => 'Show for Mobile only',
						'hide-for-small'  => 'Hide for Mobile',
					),
				),
			),
		)
	);
}

add_action( 'ux_builder_setup', 'vn_builder_expert' );

/**
 * Loads and returns a template file from the plugin's templates directory.
 *
 * @param string $path The path to the template file within the templates directory.
 * @return string The template content.
 * @since 1.0.0
 */
function vn_expert_builder_template( $path ) {
	ob_start();
	include VN_EXPERT_PATH . 'inc/templates/' . $path;
	return ob_get_clean();
}
