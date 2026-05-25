<?php
if ( ! class_exists( 'WPCM_Widget' ) ) {
	class WPCM_Widget extends WP_Widget {}
}
if ( ! function_exists( 'WPCM' ) ) {
	function WPCM() {
		return new stdClass(); }
}
