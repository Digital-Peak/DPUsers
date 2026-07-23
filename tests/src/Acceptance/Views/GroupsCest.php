<?php
/**
 * @package    DPUsers
 * @copyright  Copyright (C) 2026 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Tests\Acceptance\Views;

use Tests\Support\BasicDPUsersCestClass;
use Tests\Support\Step\Menu;

class GroupsCest extends BasicDPUsersCestClass
{
	public function canSeeGroups(Menu $I): void
	{
		$I->wantToTest('that a group of users is shown.');

		$I->amOnPage('index.php?Itemid=' . $I->createMenuItem(
			'index.php?option=com_dpusers&view=groups&layout=table',
			'Test',
			[
				'groups_ids'           => $I->grabColumnFromDatabase('user_usergroup_map', 'group_id', ['user_id' => 42]),
				'groups_header_fields' => ['groups_header_fields0' => ['field' => 'name']]
			]
		)['id']);

		$I->see('Admin', 'a');
	}
}
