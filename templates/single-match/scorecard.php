<?php
/**
 * Single Match - Lineup
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$club = get_default_club();
$home_club = get_post_meta( $post->ID, 'wpcm_home_club', true );
$played = get_post_meta( $post->ID, 'wpcm_played', true );
$players = unserialize( get_post_meta( $post->ID, 'wpcm_players', true ) );
$batting_stats = wpcm_get_section_stats('batting');
$bowling_stats = wpcm_get_section_stats('bowling');
$subs_not_used = get_post_meta( $post->ID, '_wpcm_match_subs_not_used', true );
$runs = unserialize( get_post_meta( $post->ID, '_wpcm_match_runs', true ) );
$extras = unserialize( get_post_meta( $post->ID, '_wpcm_match_extras', true ) );
$wickets = unserialize( get_post_meta( $post->ID, '_wpcm_match_wickets', true ) );
$overs = unserialize( get_post_meta( $post->ID, '_wpcm_match_overs', true ) );
if( $club == $home_club ) {
	$runs = $runs['home'];
	$extras = $extras['home'];
	$wickets = $wickets['home'];
	$overs = $overs['home'];
} else {
	$runs = $runs['away'];
	$extras = $extras['away'];
	$wickets = $wickets['away'];
	$overs = $overs['away'];
}
$total_runs = $runs + $extras;

if ( $played && $players ) {

	if ( array_key_exists( 'lineup', $players ) && is_array( $players['lineup'] ) ) { ?>
					
		<div class="wpcm-match-stats-start">

			<h3><?php echo _e( 'Batting &amp; Fielding','wpcm-cricket' ); ?></h3>

			<table class="wpcm-lineup-table">
				<thead>
					<tr>

						<?php if( get_option( 'wpcm_lineup_show_shirt_numbers' ) == 'yes' ) { ?>

							<th class="shirt-number"></th>

						<?php } ?>

						<th class="name"><?php _e('Name','wpcm-cricket') ?></th>

						<th></th>

						<?php foreach( $batting_stats as $key => $val ) {
							if( ! in_array( $key, wpcm_exclude_keys() ) && get_option( 'wpcm_show_stats_' . $key ) == 'yes' && get_option( 'wpcm_match_show_stats_' . $key ) == 'yes' ) { ?>

								<th class="<?php echo $key; ?>"><?php echo $val; ?></th>
							
							<?php }
						} ?>
						<th><?php _e( 'SR', 'wpcm-cricket' ); ?></th>
					</tr>
				</thead>
				<tbody>
										
					<?php $count = 0;
					foreach( $players['lineup'] as $key => $value) {
						$count ++;

						wpclubmanager_get_template( 'single-match/lineup-row-cricket.php', array( 
							'key' => $key, 
							'value' => $value, 
                            'section_stats' => $batting_stats,
							'format' => 'batting'
						) );
					} ?>
								
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" style="text-align:right">
							<?php _e( 'Extras:', 'wpcm_cricket' ); ?>
						</td>
						<td colspan="6">&nbsp;</td>
						<td colspan="1">
							<?php echo $extras; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right">
							<?php _e( 'Total:', 'wpcm_cricket' ); ?>
						</td>
						<td colspan="6" style="font-weight:normal">
							<?php printf( __( 'for %s wickets', 'wpcm_cricket' ), $wickets ); ?> 
							<?php printf( __( '%s overs', 'wpcm_cricket' ), $overs ); ?>
						<td colspan="1">
							<?php echo $total_runs; ?>
						</td>
					</tr>
				</tfoot>
			</table>

            <h3><?php echo _e( 'Bowling','wpcm-cricket' ); ?></h3>

			<table class="wpcm-lineup-table">
				<thead>
					<tr>

						<?php if( get_option( 'wpcm_lineup_show_shirt_numbers' ) == 'yes' ) { ?>

							<th class="shirt-number"></th>

						<?php } ?>

						<th class="name"><?php _e('Name','wpcm-cricket') ?></th>

						<?php foreach( $bowling_stats as $key => $val ) {
							if( ! in_array( $key, wpcm_exclude_keys() ) && get_option( 'wpcm_show_stats_' . $key ) == 'yes' && get_option( 'wpcm_match_show_stats_' . $key ) == 'yes' ) {
								
								if( $key == 'balls_bowled' ) { ?>

									<th class="stats <?php echo $key; ?>"><?php _e( 'O', 'wpcm-cricket' ); ?></td>
				
								<?php } else { ?>

									<th class="<?php echo $key; ?>"><?php echo $val; ?></th>
							
								<?php }
							}
						} ?>
						<th><?php _e( 'Econ', 'wpcm-cricket' ); ?></th>
					</tr>
				</thead>
				<tbody>
										
					<?php $count = 0;
					foreach( $players['lineup'] as $key => $value) {
						$count ++;

						if( $value['balls_bowled'] >= '1' ) {

							wpclubmanager_get_template( 'single-match/lineup-row-cricket.php', array( 
								'key' => $key, 
								'value' => $value, 
								'section_stats' => $bowling_stats,
								'format' => 'bowling'
							) );
						}
					} ?>
								
				</tbody>
			</table>
		</div>

	<?php }
}