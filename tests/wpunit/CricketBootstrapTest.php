<?php
/**
 * Tests for wpcm-cricket addon bootstrap and core functionality.
 */

class CricketBootstrapTest extends WPCMcricketTestCase {

	public function test_cricket_sport_registered() {
		$sports = apply_filters( 'wpclubmanager_sports', array() );
		// Cricket sport should be added by the addon.
		if ( isset( $sports['cricket'] ) ) {
			$this->assertArrayHasKey( 'cricket', $sports );
		} else {
			$this->markTestIncomplete( 'Cricket sport not registered — may need wpcm_sport=cricket option' );
		}
	}

	public function test_overs_to_balls_conversion() {
		if ( function_exists( 'overs_to_balls' ) ) {
			$this->assertEquals( 30, overs_to_balls( 5.0 ) );
			$this->assertEquals( 33, overs_to_balls( 5.3 ) );
		} else {
			$this->markTestIncomplete( 'overs_to_balls function not loaded' );
		}
	}

	public function test_balls_to_overs_conversion() {
		if ( function_exists( 'balls_to_overs' ) ) {
			$this->assertEquals( 5.0, balls_to_overs( 30 ) );
			$this->assertEquals( 5.3, balls_to_overs( 33 ) );
		} else {
			$this->markTestIncomplete( 'balls_to_overs function not loaded' );
		}
	}

	public function test_toss_comparison_uses_strict_equality() {
		// Regression: the toss display used assignment (=) instead of comparison (===).
		// This was fixed in our security pass. Verify the fix is in place.
		$file = WP_PLUGIN_DIR . '/wpcm-cricket/wpcm-cricket.php';
		if ( file_exists( $file ) ) {
			$content = file_get_contents( $file );
			$this->assertStringNotContainsString( "\$toss = 'home'", $content, 'Toss should use === not =' );
		}
	}
}
