<?php
/**
 * @package    DPUsers
 * @copyright  Copyright (C) 2026 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Tests\Acceptance\Views;

use Tests\Support\BasicDPUsersCestClass;
use Tests\Support\Step\Menu;

class UserCest extends BasicDPUsersCestClass
{
	public function canSeeUser(Menu $I): void
	{
		$I->wantToTest('that details view for a user is shown.');

		$I->amOnPage('index.php?Itemid=' . $I->createMenuItem('index.php?option=com_dpusers&view=user&id=42', 'Test')['id']);

		$I->see('Admin', 'h1');
	}
}
