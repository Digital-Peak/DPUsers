<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Model;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;

class GroupsModel extends ListModel
{
	protected function getListQuery()
	{
		// Create a new query object
		$db    = $this->getDatabase();
		$query = $db->getQuery(true);

		// Select the required fields from the table
		$query->select('DISTINCT a.*');
		$query->from('#__users AS a');

		// If the model is set to check item state, add to the query.
		$state = $this->getState('filter.state');
		if (is_numeric($state)) {
			$query->where('a.block = :state')->bind(':state', $state, ParameterType::INTEGER);
		}

		// If the model is set to check the activated state, add to the query.
		if ($active = $this->getState('filter.active')) {
			if ($active == '0') {
				$query->whereIn('a.activation', ['', '0']);
			} elseif ($active == '1') {
				$query->where($query->length('a.activation') . ' > 1');
			}
		}

		// Filter the items over the group id if set
		if ($groups = $this->getState('filter.groups', $this->getState('parameters.menu', new Registry())->get('groups_ids', [-1]))) {
			$query->join('LEFT', '#__user_usergroup_map AS map2 ON map2.user_id = a.id')
				->group(
					[
						'a.id',
						'a.name',
						'a.username',
						'a.password',
						'a.block',
						'a.sendEmail',
						'a.registerDate',
						'a.lastvisitDate',
						'a.activation',
						'a.params',
						'a.email',
						'a.lastResetTime',
						'a.resetCount',
						'a.otpKey',
						'a.otep',
						'a.requireReset'
					]
				);

			$query->whereIn('map2.group_id', $groups);
		}

		// Filter the items over the search string if set
		if ($search = $this->getState('filter.search')) {
			if (stripos((string) $search, 'id:') === 0) {
				$ids = (int) substr((string) $search, 3);
				$query->where('a.id = :id');
				$query->bind(':id', $ids, ParameterType::INTEGER);
			} elseif (stripos((string) $search, 'username:') === 0) {
				$search = '%' . substr((string) $search, 9) . '%';
				$query->where('a.username LIKE :username');
				$query->bind(':username', $search);
			} else {
				$search = '%' . trim((string) $search) . '%';

				// Join to fields
				$query->join(
					'LEFT',
					"#__fields_values AS f ON f.item_id = a.id and f.field_id IN (SELECT id FROM #__fields WHERE context = 'com_users.user')"
				);

				// Add the clauses to the query
				$query->where('(a.name LIKE :name OR a.username LIKE :username OR a.email LIKE :email OR f.value LIKE :search)')
					->bind(':name', $search)
					->bind(':username', $search)
					->bind(':email', $search)
					->bind(':search', $search);
			}
		}

		// Filter for custom field
		if ($customFields = $this->getState('filter.fields', $this->getState('parameters.menu', new Registry())->get('groups_custom_field_filters'))) {
			// Join to fields
			$query->join('RIGHT', '#__fields_values AS ff ON ff.item_id = a.id');

			foreach ($customFields as $search) {
				$search->operator = in_array($search->operator, ['=', '<', '>', 'like']) ? $search->operator : '=';

				// Add the clauses to the query
				$query->where(
					'(ff.value ' . $search->operator . ' ' . $db->quote($search->value) .
					' AND ff.field_id = ' . (int)$search->field . ')'
				);
			}
		}

		// Add the list ordering clause.
		$query->order(
			$db->escape($this->getState('list.ordering', 'a.name')) . ' ' . $db->escape($this->getState('list.direction', 'ASC'))
		);

		return $query;
	}

	protected function getStoreId($id = '')
	{
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.groups');

		return parent::getStoreId($id);
	}
}
