<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Service\Router;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\Rules\MenuRules;

class DPUsersMenuRules extends MenuRules
{
	protected function buildLookup($language = '*')
	{
		parent::buildLookup($language);

		// Getting the required variables to match the parent lookup
		$component = ComponentHelper::getComponent('com_' . $this->router->getName());

		$attributes = ['component_id'];
		$values     = [(int)$component->id];

		$attributes[] = 'language';
		$values[]     = [$language, '*'];

		$menuItems = $this->router->menu->getItems($attributes, $values);
		if (!\is_array($menuItems)) {
			$menuItems = [$menuItems];
		}

		// As the ids of the groups are in the params we need to assign them as group ids to the lookup
		foreach ($menuItems as $menuItem) {
			// Get the group ids form the menu item
			$ids = $menuItem->getParams()->get('groups_ids');
			if (!$ids) {
				continue;
			}

			// Assign the menu item to the lookup
			foreach ($ids as $id) {
				$this->lookup[$language][$menuItem->query['view']][$id] = $menuItem->id;
			}
		}
	}
}
