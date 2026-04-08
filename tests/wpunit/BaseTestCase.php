<?php
class WPCMcricketTestCase extends \Codeception\TestCase\WPTestCase {

	public function _setUp() {
		parent::_setUp();
	}

	public function _tearDown() {
		parent::_tearDown();
	}

	public function assertPostConditions(): void {
		$caught = $this->caught_doing_it_wrong;
		unset( $caught['WP_Block_Bindings_Registry::register'] );
		$this->caught_doing_it_wrong = $caught;
		parent::assertPostConditions();
	}
}
