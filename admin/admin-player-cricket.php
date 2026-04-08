<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'add_meta_boxes', 'add_player_cricket_metaboxes' );
add_action( 'wpclubmanager_after_admin_player_save', 'wpcm_cricket_save_player' );

function add_player_cricket_metaboxes() {

	add_meta_box( 'wpclubmanager-player-cricket', __( 'Player Styles', 'wpcm-cricket' ), 'wpcm_cricket_player', 'wpcm_player', 'normal', 'low' );
}

function wpcm_cricket_player( $post ) {

	$bowling = get_post_meta( $post->ID, '_wpcm_cricket_bowling', true );
	$batting = get_post_meta( $post->ID, '_wpcm_cricket_batting', true );

	wpclubmanager_wp_select( array(
		'id'      => '_wpcm_cricket_batting',
		'label'   => __( 'Batting Style', 'wpcm-cricket' ),
		'options' => array(
			'right-hand' => __( 'Right-handed', 'wpcm-cricket' ),
			'left-hand'  => __( 'Left-handed', 'wpcm-cricket' ),
		),
	) );

	wpclubmanager_wp_select( array(
		'id'      => '_wpcm_cricket_bowling',
		'label'   => __( 'Bowling Style', 'wpcm-cricket' ),
		'options' => array(
			'none' => __( 'None', 'wpcm-cricket' ),
			'rf'   => __( 'Right-arm fast', 'wpcm-cricket' ),
			'rfm'  => __( 'Right-arm fast medium', 'wpcm-cricket' ),
			'rmf'  => __( 'Right-arm medium fast', 'wpcm-cricket' ),
			'rm'   => __( 'Right-arm medium', 'wpcm-cricket' ),
			'lf'   => __( 'Left-arm fast', 'wpcm-cricket' ),
			'lfm'  => __( 'Left-arm fast medium', 'wpcm-cricket' ),
			'lmf'  => __( 'Left-arm medium fast', 'wpcm-cricket' ),
			'lm'   => __( 'Left-arm medium', 'wpcm-cricket' ),
			'ob'   => __( 'Off break', 'wpcm-cricket' ),
			'lb'   => __( 'Leg break', 'wpcm-cricket' ),
			'sla'  => __( 'Slow left-arm orthodox', 'wpcm-cricket' ),
			'slc'  => __( 'Slow left-arm chinaman', 'wpcm-cricket' ),
		),
	) );
}

function wpcm_cricket_save_player( $post_id ) {
	$batting_styles = array( 'right-hand', 'left-hand' );
	$bowling_styles = array( 'none', 'rf', 'rfm', 'rm', 'lf', 'lfm', 'lm', 'lb', 'ob', 'sla', 'slc' );

	if ( isset( $_POST['_wpcm_cricket_bowling'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$bowling = sanitize_key( wp_unslash( $_POST['_wpcm_cricket_bowling'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( in_array( $bowling, $bowling_styles, true ) ) {
			update_post_meta( $post_id, '_wpcm_cricket_bowling', $bowling );
		}
	}

	if ( isset( $_POST['_wpcm_cricket_batting'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$batting = sanitize_key( wp_unslash( $_POST['_wpcm_cricket_batting'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( in_array( $batting, $batting_styles, true ) ) {
			update_post_meta( $post_id, '_wpcm_cricket_batting', $batting );
		}
	}
}

function wpcm_match_details_toss( $post ) {

	wpclubmanager_wp_select( array(
		'id'      => '_wpcm_cricket_match_toss',
		'label'   => __( 'Toss', 'wpcm-cricket' ),
		'options' => array(
			'home' => __( 'Home team win toss', 'wpcm-cricket' ),
			'away' => __( 'Away team win toss', 'wpcm-cricket' ),
		),
	) );
}
add_action( 'wpclubmanager_admin_match_details', 'wpcm_match_details_toss' );

function wpcm_match_details_toss_save( $post_id ) {
	if ( isset( $_POST['_wpcm_cricket_match_toss'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$toss = sanitize_key( wp_unslash( $_POST['_wpcm_cricket_match_toss'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( in_array( $toss, array( 'home', 'away' ), true ) ) {
			update_post_meta( $post_id, '_wpcm_cricket_match_toss', $toss );
		}
	}
}
add_action( 'wpclubmanager_after_admin_match_save', 'wpcm_match_details_toss_save' );
