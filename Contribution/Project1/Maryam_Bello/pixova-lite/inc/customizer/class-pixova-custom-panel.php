<?php

if ( ! defined( 'ABSPATH' ) ) {
	die(); // no direct access
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

if ( ! class_exists( 'Pixova_Custom_Panel' ) ) {
	class Pixova_Custom_Panel extends WP_Customize_Panel {

		public $panel;
		public $type = 'pixova_panel';

		public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
			parent::__construct( $manager, $id, $args );
			$manager->register_panel_type( 'Pixova_Custom_Panel' );
		}

		public function json() {

			$array                   = wp_array_slice_assoc( (array) $this, array(
				'id',
				'description',
				'priority',
				'type',
				'panel',
			) );
			$array['title']          = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content']        = $this->get_content();
			$array['active']         = $this->active();
			$array['instanceNumber'] = $this->instance_number;

			return $array;

		}

	}
}
