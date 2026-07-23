<?php
/**
 * @package    DPUsers
 * @copyright  Copyright (C) 2026 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Tests\Support;

class BasicDPUsersCestClass
{
	public function _before(AcceptanceTester $I): void
	{

	}

	public function _after(AcceptanceTester $I): void
	{
		$I->checkForPhpNoticesOrWarnings();
		$I->checkForJsErrors();
	}

	public function _failed(AcceptanceTester $I): void
	{
		$I->pause();
	}
}
