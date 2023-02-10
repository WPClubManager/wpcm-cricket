<?php
/**
 * Plugin Name: WPCM Cricket
 * Version: 1.1.3
 * Plugin URI: https://wpclubmanager.com
 * Description: An extension for the WP Club Manager sports club plugin which adds extra features for cricket clubs.
 * Author: WP Club Manager
 * Author URI: https://wpclubmanager.com
 * Requires at least: 4.6
 *
 * Text Domain: wpcm-cricket
 * Domain Path: /languages/
 *
 * @package   WPClubManager
 * @category  Core
 * @author    WP Club Manager <hello@wpclubmanager.com>
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if WP Club Manager is active
 **/
if ( in_array( 'wp-club-manager/wpclubmanager.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	include_once( 'admin/admin-player-cricket.php' );
	include_once( 'admin/admin-match-lineup.php' );

	remove_action( 'wpclubmanager_single_match_details', 'wpclubmanager_template_single_match_lineup', 5 );

  add_action( 'wpclubmanager_single_player_info', 'wpcm_cricket_player_styles_display', 15 );
	add_action( 'wpclubmanager_single_match_details', 'wpcm_cricket_scoreboard', 5 );
	add_action( 'wpclubmanager_single_match_meta', 'wpcm_cricket_toss_display', 30 );

	add_filter( 'wpclubmanager_locate_template', 'wpcm_cricket_wpclubmanager_locate_template', 10, 3 );
	add_filter( 'wpcm_sports', 'custom_add_new_sport', 10, 1 );

	function custom_add_new_sport( $sport ) {
		$sport['cricket'] = array(
			'name' => __( 'Cricket', 'wpcm-cricket' ),
			'terms' => array(
				'wpcm_position' => array(
					array(
						'name' => 'Batsman',
						'slug' => 'batsman',
					),
					array(
						'name' => 'Bowler',
						'slug' => 'bowler',
					),
					array(
						'name' => 'Wicket-keeper',
						'slug' => 'wicket-keeper',
					),
					array(
						'name' => 'Fielder',
						'slug' => 'fielder',
					),
					array(
						'name' => 'All-rounder',
						'slug' => 'all-rounder',
					),

				),
			),
			'stat_sections' => array(
				'batting'	=> __( 'Batting &amp; Fielding', 'wpcm-cricket' ),
				'bowling'	=> __( 'Bowling', 'wpcm-cricket' ),
			),
			'stats_labels' => array(
				'innings' => array(
					'name' 		=> __( 'Innings', 'wpcm-cricket' ),
					'label' 	=> _x( 'I', 'Innings', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'runs' => array(
					'name' 		=> __( 'Runs', 'wpcm-cricket' ),
					'label' 	=> _x( 'R', 'Runs', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'balls' => array(
					'name' 		=> __( 'Balls', 'wpcm-cricket' ),
					'label' 	=> _x( 'B', 'Balls', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'fours' => array(
					'name' 		=> __( 'Fours', 'wpcm-cricket' ),
					'label' 	=> _x( '4s', 'Fours', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'sixes' => array(
					'name' 		=> __( 'Sixes', 'wpcm-cricket' ),
					'label' 	=> _x( '6s', 'Sixes', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'catches' => array(
					'name' 		=> __( 'Catches', 'wpcm-cricket' ),
					'label' 	=> _x( 'CT', 'Catches', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'stumpings' => array(
					'name' 		=> __( 'Stumpings', 'wpcm-cricket' ),
					'label' 	=> _x( 'ST', 'Stumpings', 'wpcm-cricket' ),
					'section'	=> 'batting',
				),
				'balls_bowled' => array(
					'name' 		=> __( 'Balls Bowled', 'wpcm-cricket' ),
					'label' 	=> _x( 'BB', 'Balls bowled', 'wpcm-cricket' ),
					'section'	=> 'bowling',
				),
				'maidens' => array(
					'name'		=> __( 'Maidens', 'wpcm-cricket' ),
					'label' 	=> _x( 'M', 'Maidens', 'wpcm-cricket' ),
					'section'	=> 'bowling',
					),
				'runs_against' => array(
					'name' 		=> __( 'Runs', 'wpcm-cricket' ),
					'label' 	=> _x( 'R', 'Runs Against', 'wpcm-cricket' ),
					'section'	=> 'bowling',
				),
				'wickets' => array(
					'name' 		=> __( 'Wickets', 'wpcm-cricket' ),
					'label' 	=> _x( 'W', 'Wickets', 'wpcm-cricket' ),
					'section'	=> 'bowling',
				),
				'mvp' => array(
					'name' 		=> __( 'Player of Match', 'wpcm-cricket' ),
					'label' 	=> _x( 'POM', 'Player of Match', 'wpcm-cricket' ),
					'section'	=> 'none',
				),
			),
			'standings_columns' => array(
				'p' => array(
					'name' 	=> __( 'Played', 'wpcm-cricket' ),
					'label' => _x( 'P', 'Played', 'wpcm-cricket' ),
				),
				'w' => array(
					'name' 	=> __( 'Won', 'wpcm-cricket' ),
					'label' => _x( 'W', 'Won', 'wpcm-cricket' ),
				),
				'd' => array(
					'name' 	=> __( 'Draw', 'wpcm-cricket' ),
					'label' => _x( 'D', 'Draw', 'wpcm-cricket' ),
				),
				'l' => array(
					'name' 	=> __( 'Lost', 'wpcm-cricket' ),
					'label' => _x( 'L', 'Lost', 'wpcm-cricket' ),
				),
				'pts' => array(
					'name' 	=> __( 'Points', 'wpcm-cricket' ),
					'label' => _x( 'Pts', 'Points', 'wpcm-cricket' ),
				),
				'f' => array(
					'name' 	=> __( 'Runs For', 'wpcm-cricket' ),
					'label' => _x( 'RF', 'Runs For', 'wpcm-cricket' ),
				),
				'a' => array(
					'name' 	=> __( 'Runs Against', 'wpcm-cricket' ),
					'label' => _x( 'RA', 'Runs Against', 'wpcm-cricket' ),
				),
			),
		);
		return $sport;
	}

	function wpcm_cricket_outs() {

		$outs = array(
			'0' => __( 'Did Not Bat', 'wpcm-cricket'),
			'1' => __( 'Bowled', 'wpcm-cricket'),
			'2' => __( 'Caught', 'wpcm-cricket'),
			'3' => __( 'Stumped', 'wpcm-cricket'),
			'4' => __( 'Lbw', 'wpcm-cricket'),
			'6' => __( 'Run Out', 'wpcm-cricket'),
			'5' => __( 'Not Out', 'wpcm-cricket'),
		);

		return $outs;
	}

    function wpcm_cricket_player_styles_display() {

		global $post;

		$batting = get_post_meta( $post->ID, '_wpcm_cricket_batting', true );
		$bowling = get_post_meta( $post->ID, '_wpcm_cricket_bowling', true );?>

		<table>
			<tr>
				<th>
					<?php _e( 'Batting Style', 'wpcm-cricket' ); ?>
				</th>
				<td>
					<?php echo $batting; ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php _e( 'Bowling Style', 'wpcm-cricket' ); ?>
				</th>
				<td>
					<?php echo $bowling; ?>
				</td>
			</tr>
		</table>
    <?php
	}

	function wpcm_cricket_toss_display() {

		global $post;

		$toss = get_post_meta( $post->ID, '_wpcm_cricket_match_toss', true ); ?>

		<div class="wpcm-match-referee">
			<?php if( $toss = 'home' ) {
				echo __( 'Home team win toss', 'wpcm-cricket' );
			} else {
				echo __( 'Away team win toss', 'wpcm-cricket' );
			} ?>
		</div>
	<?php
	}

	function wpcm_cricket_plugin_path() {

		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	function wpcm_cricket_wpclubmanager_locate_template( $template, $template_name, $template_path ) {

		$_template = $template;

		if ( ! $template_path ) {
			$template_path = WPCM_TEMPLATE_PATH;
		}

		$plugin_path  = wpcm_cricket_plugin_path() . '/templates/';

		$template = locate_template( array( trailingslashit( $template_path ) . $template_name, $template_name ) );

		if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		if ( ! $template ) {
			$template = $_template;
		}

		return $template;
	}

	function wpcm_cricket_scoreboard() {

		wpclubmanager_get_template( 'single-match/scorecard.php' );
	}

	function overs_to_balls( $overs ) {

    	return 10 * $overs -4 * (int)$overs;
	}

	function balls_to_overs( $balls ) {

    	return (int)($balls / 6) + .1 * ( $balls % 6);
	}

	function wpcm_cricket_head_to_head_count( $outcome, $matches ) {

		$club = get_default_club();
		$wins = 0;
		$losses = 0;
		$draws = 0;
		$count = 0;
		foreach( $matches as $match ) {

			$count ++;
			$home_club = get_post_meta( $match->ID, 'wpcm_home_club', true );
			$runs = unserialize( get_post_meta( $match->ID, '_wpcm_match_runs', true ) );
			$extras = unserialize( get_post_meta( $match->ID, '_wpcm_match_extras', true ) );
			$home_goals = $runs['home'] + $extras['home'];
			$away_goals = $runs['away'] + $extras['away'];

			if ( $home_goals == $away_goals ) {
				$draws ++;
			}

			if ( $club == $home_club ) {
				if ( $home_goals > $away_goals ) {
					$wins ++;
				}
				if ( $home_goals < $away_goals ) {
					$losses ++;
				}
			} else {
				if ( $home_goals > $away_goals ) {
					$losses ++;
				}
				if ( $home_goals < $away_goals ) {
					$wins ++;
				}
			}

		}
		$outcome = array();
		$outcome['total'] = $count;
		$outcome['wins'] = $wins;
		$outcome['draws'] = $draws;
		$outcome['losses'] = $losses;

		return $outcome;
	}
	add_filter( 'wpcm_head_to_head_count', 'wpcm_cricket_head_to_head_count', 10, 2 );
}
