<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Controller;

use DigitalPeak\Component\DPUsers\Site\View\User\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

class DisplayController extends BaseController
{
	public function display($cachable = false, $urlparams = [])
	{
		if ($this->app->getUserState('com_dpusers.user.data') === null) {
			$cachable = true;
		}

		// Set the default view name and format from the Request.
		$vName = $this->input->get('view', 'groups');
		$this->input->set('view', $vName);

		if ($this->app->getIdentity()->get('id')) {
			$cachable = false;
		}

		$id = $this->input->getInt('id');
		if ($vName === 'form' && !$this->checkEditId('com_dpusers.edit.user', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			throw new \Exception(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 403);
		}

		$this->app->getLanguage()->load('com_users', JPATH_ADMINISTRATOR);

		parent::display($cachable, []);

		return $this;
	}

	public function getView($name = '', $type = '', $prefix = '', $config = ['ignore_request' => true])
	{
		/** @var HtmlView $view */
		$view = parent::getView($name, $type, $prefix, $config);

		$groupsLayout = $this->app->getMenu()->getActive()->getParams()->get('groups_details_layout', 'default');
		if ($view instanceof HtmlView && $groupsLayout !== 'default') {
			$view->setLayout($groupsLayout);
		}

		return $view;
	}

	public function getModel($name = '', $prefix = '', $config = ['ignore_request' => true])
	{
		if (!array_key_exists('ignore_request', $config)) {
			$config['ignore_request'] = true;
		}

		$model = parent::getModel($name, $prefix, $config);
		$model->setState('user.current', $this->app->getIdentity());
		$model->setState('menu.current', $this->app->getMenu()->getActive());

		if ($id = $this->input->get('id')) {
			$model->setState('user.id', $id);
		}

		if ($groups = $this->input->getString('groups', [])) {
			$model->setState('filter.groups', is_string($groups) ? explode(',', $groups) : $groups);
		}

		if ($return = $this->input->get('return', '', 'base64')) {
			$model->setState('return_page', base64_decode($return));
		}

		if ($search = $this->app->getUserStateFromRequest('com_dpusers.filter.search', 'search')) {
			$model->setState('filter.search', $search);
		}

		if ($search !== null) {
			$this->app->setUserState('com_dpusers.filter.search', $search);
		}

		$model->setState('list.start', $this->app->input->get('start', 0, 'uint'));
		$model->setState('list.limit', $this->app->getUserStateFromRequest('global.list.limit', 'limit', $this->app->get('list_limit'), 'uint'));

		return $model;
	}
}
