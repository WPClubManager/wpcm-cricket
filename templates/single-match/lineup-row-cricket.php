<?php
/**
 * Single Match - Lineup Row
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post; ?>

<tr>
	<th class="name">
		<div>
			<?php if( get_option('wpcm_player_profile_show_number') == 'yes' && get_post_meta( $key, 'wpcm_number', true ) == true) {
				echo get_post_meta( $key, 'wpcm_number', true );
			}
			if( get_option('wpcm_results_show_image') == 'yes' ) {
				echo wpcm_get_player_thumbnail( $key, 'player_thumbnail', array( 'class' => 'lineup-thumb' ) );
			} ?>
			<a href="<?php echo get_permalink( $key ); ?>"><?php echo get_the_title( $key ); ?></a>
			<?php echo ( get_post_meta( $post->ID, '_wpcm_match_captain', true ) == $key ? ' (c) ' : '' );
			if ( isset( $value['mvp'] ) ) { ?>
				<span class="mvp" title="<?php _e( 'Player of Match', 'wp-club-manager' ); ?>">&#9733;</span>
			<?php }

			if ( array_key_exists( 'sub', $value ) && $value['sub'] > 0 ) { ?>
				<span class="sub">&larr; <?php echo get_the_title( $value['sub'] ); ?></span>
			<?php } ?>
		</div>
	</th>

	<?php if( $format == 'batting' ) { ?>

		<td class="out">

			<?php if ( array_key_exists( 'out', $value ) && $value['out'] !== '0' ) { 
				$outs = wpcm_cricket_outs(); ?>
				<span class="out"><?php echo $outs[$value['out']]; ?></span>
			<?php } ?>

		</td>

	<?php }

	foreach( $value as $key => $stat ) {
		
		if( $stat == '0' || $stat == null ) {
			$stat = '0';
		}
		if( array_key_exists( $key, $section_stats ) ) {
			if( ! in_array( $key, wpcm_exclude_keys() ) && get_option( 'wpcm_show_stats_' . $key ) == 'yes' && get_option( 'wpcm_match_show_stats_' . $key ) == 'yes' ) { 
			
				if( $key == 'balls_bowled' ) { ?>

					<td class="stats <?php echo $key; ?>"><?php echo balls_to_overs($stat); ?></td>
				
				<?php } else { ?>

					<td class="stats <?php echo $key; ?>"><?php echo $stat; ?></td>
				
				<?php
				}
			}
		}
	}
	if( $format == 'batting' ) { ?>
		<td><?php echo ( $value['runs'] > 0 ? round( $value['runs'] * 100 / $value['balls'], 1 ) : '0.0' ); ?></td>
	<?php
	} else { ?>
		<td><?php echo ( $value['runs_against'] > 0 ? round( $value['runs_against'] / balls_to_overs($value['balls_bowled']), 1 ) : '0.0' ); ?></td>
	<?php
	} ?> 
</tr>