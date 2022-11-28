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
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table
		$query->select('DISTINCT a.*');
		$query->from($db->quoteName('#__users') . ' AS a');

		// If the model is set to check item state, add to the query.
		$state = $this->getState('filter.state');
		if (is_numeric($state)) {
			$query->where($db->quoteName('a.block') . ' = :state')->bind(':state', $state, ParameterType::INTEGER);
		}

		// If the model is set to check the activated state, add to the query.
		if ($active = $this->getState('filter.active')) {
			if ($active == '0') {
				$query->whereIn($db->quoteName('a.activation'), ['', '0']);
			} elseif ($active == '1') {
				$query->where($query->length($db->quoteName('a.activation')) . ' > 1');
			}
		}

		// Filter the items over the group id if set
		if ($groups = $this->getState('filter.groups', $this->getState('parameters.menu', new Registry())->get('groups_ids', [-1]))) {
			$query->join('LEFT', '#__user_usergroup_map AS map2 ON map2.user_id = a.id')
				->group(
					$db->quoteName(
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
					)
				);

			$query->whereIn($db->quoteName('map2.group_id'), $groups);
		}

		// Filter the items over the search string if set
		if ($search = $this->getState('filter.search')) {
			if (stripos($search, 'id:') === 0) {
				$ids = (int) substr($search, 3);
				$query->where($db->quoteName('a.id') . ' = :id');
				$query->bind(':id', $ids, ParameterType::INTEGER);
			} elseif (stripos($search, 'username:') === 0) {
				$search = '%' . substr($search, 9) . '%';
				$query->where($db->quoteName('a.username') . ' LIKE :username');
				$query->bind(':username', $search);
			} else {
				$search = '%' . trim($search) . '%';

				// Join to fields
				$query->join(
                    'LEFT',
                    '#__fields_values AS f ON f.item_id = a.id and f.field_id IN (SELECT id FROM #__fields WHERE context = \'com_users.user\')'
                );

				// Add the clauses to the query
				$query->where(
					'(' . $db->quoteName('a.name') . ' LIKE :name'
					. ' OR ' . $db->quoteName('a.username') . ' LIKE :username'
					. ' OR ' . $db->quoteName('a.email') . ' LIKE :email'
					. ' OR ' . $db->quoteName('f.value') . ' LIKE :search)'
				)
					->bind(':name', $search)
					->bind(':username', $search)
					->bind(':email', $search)
					->bind(':search', $search);
			}
		}

		// Add the list ordering clause.
		$query->order(
			$db->quoteName($db->escape($this->getState('list.ordering', 'a.name'))) . ' ' . $db->escape($this->getState('list.direction', 'ASC'))
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
