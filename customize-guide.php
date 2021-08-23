<?php
/*
Plugin Name: Customize Guide
Plugin URI: https://github.com/Automattic/customize-guide
Description: Guides for customizer
Author: Automattic
Author URI: http://automattic.com/
Version: 1.0.0
*/

/**
 * Copyright (c) 2021 Automattic. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

class WPCOM_Customize_Guide {

	private static $instance;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function init() {
		if ( ! is_customize_preview() ) {
			return;
		}
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	private function should_show_guide() {
		if ( isset( $_GET['guide'] ) ) {
			return true;
		}

		// Only to newer users
		$this_user_id = (int) get_current_user_id();
		$minimum_user_id = 99855465;
		if ( $this_user_id < $minimum_user_id ) {
			return false;
		}

		// check the attribute set when shown
		if ( get_user_attribute( $this_user_id, 'customizer-guide-shown' ) ) {
			return false;
		}

		// we can show it, but just this once
		update_user_attribute( $this_user_id, 'customizer-guide-shown', 1 );
		return true;
	}

	public function enqueue_assets() {
		wp_enqueue_script( 'customize-guide', plugins_url( 'js/customize-guide.js', __FILE__ ), array( 'customize-controls' ), '20210820', true );
		wp_enqueue_style( 'customize-guide', plugins_url( 'css/customize-guide.css', __FILE__ ) );

		$steps = array(
			array(
				'content' => __( 'Here you can control the design of your site. Change your site title, update the colors and fonts, and even add a header image. Explore widgets to find new features and content to add to your website.' ),
				'smallContent' => __( 'Click the <strong>Preview</strong> icon to preview your site appearance before saving.' ),
				'button' => __( 'Thanks, got it!' )
			),
		);

		$steps = apply_filters( 'customize_guide_steps', $steps );

		$showGuide = $this->should_show_guide();
		wp_localize_script( 'customize-guide', '_Customize_Guide', compact( 'steps', 'showGuide' ) );
	}
}

add_action( 'init', array( WPCOM_Customize_Guide::get_instance(), 'init' ) );
