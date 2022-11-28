<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\View\User;

use Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;
use stdClass;

class HtmlView extends BaseHtmlView
{
	protected $state;
	protected $params;

	/** @var User $user */
	protected $user;

	/** @var User $currentUser */
	protected $currentUser;
	protected $permissions;

	public function display($tpl = null)
	{
		$this->state         = $this->get('State');
		$this->params        = $this->state->get('parameters.menu', new Registry());
		$this->user          = $this->get('Item');
		$this->currentUser   = $this->state->get('user.current');
		$this->permissions   = new Registry(['can_edit' => false, 'can_delete' => false]);
		$this->groupedFields = [];

		$menuItem = $this->state->get('menu.current');
		if (!$menuItem || (!array_intersect($this->user->groups, $this->params->get('groups_ids', [])) && empty($menuItem->query['id']))) {
			throw new Exception(Text::_('COM_DPUSERS_USER_VIEW_USER_NOT_FOUND'));
		}

		PluginHelper::importPlugin('content');
		$app = Factory::getApplication();

		$this->user->text = '';
		$app->triggerEvent('onContentPrepare', ['com_users.user', $this->user, $this->user->params, 0]);

		$this->user->displayEvent = new stdClass();
		$results                  = $app->triggerEvent(
			'onContentAfterTitle',
			['com_users.user', &$this->user, &$this->user->params, 0]
		);
		$this->user->displayEvent->afterDisplayTitle = trim(implode("\n", $results));

		$results = $app->triggerEvent(
			'onContentBeforeDisplay',
			['com_users.user', &$this->user, &$this->user->params, 0]
		);
		$this->user->displayEvent->beforeDisplayContent = trim(implode("\n", $results));

		$results = $app->triggerEvent(
			'onContentAfterDisplay',
			['com_users.user', &$this->user, &$this->user->params, 0]
		);
		$this->user->displayEvent->afterDisplayContent = trim(implode("\n", $results));

		if ($this->currentUser) {
			$this->permissions->set('can_edit', $this->currentUser->authorise('core.edit', 'com_users'));
			$this->permissions->set('can_delete', $this->currentUser->authorise('core.delete', 'com_users'));
		}

		if (!empty($this->user->jcfields)) {
			$selectedFields = [];
			foreach ($this->params->get('user_grouped_fields', []) as $fieldsConfig) {
				if (!array_intersect($this->currentUser->groups, $fieldsConfig->group_ids)) {
					continue;
				}
				$selectedFields = $fieldsConfig->fields;
			}

			foreach ($this->user->jcfields as $field) {
				if ($selectedFields && !in_array($field->id, $selectedFields)) {
					continue;
				}

				if (!array_key_exists($field->group_id, $this->groupedFields)) {
					$this->groupedFields[$field->group_id] = [];
				}
				$this->groupedFields[$field->group_id][] = $field;
			}
		}

		parent::display($tpl);
	}
}
