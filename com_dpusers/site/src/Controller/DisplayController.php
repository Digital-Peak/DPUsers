<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Controller;

use DigitalPeak\Component\DPUsers\Site\View\User\HtmlView;
use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\User\CurrentUserInterface;
use Joomla\CMS\User\CurrentUserTrait;

class DisplayController extends BaseController implements CurrentUserInterface
{
	use CurrentUserTrait;

	public function display($cachable = false, $urlparams = []): static
	{
		$app = $this->app;
		if ($app instanceof CMSWebApplicationInterface && $app->getUserState('com_dpusers.user.data') === null) {
			$cachable = true;
		}

		// Set the default view name and format from the Request.
		$vName = $this->input->get('view', 'groups');
		$this->input->set('view', $vName);

		if ($this->getCurrentUser()->id) {
			$cachable = false;
		}

		$id = $this->input->getInt('id');
		if ($vName === 'form' && !$this->checkEditId('com_dpusers.edit.user', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			throw new \Exception(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 403);
		}

		$this->app->getLanguage()->load('com_users', JPATH_ADMINISTRATOR);

		parent::display($cachable);

		return $this;
	}

	public function getView($name = '', $type = '', $prefix = '', $config = ['ignore_request' => true])
	{
		/** @var HtmlView $view */
		$view = parent::getView($name, $type, $prefix, $config);

		$app = $this->app;
		if (!$app instanceof CMSWebApplicationInterface) {
			return $view;
		}

		$menu = $app->getMenu();
		if ($menu === null) {
			return $view;
		}

		$active = $menu->getActive();
		if ($active === null) {
			return $view;
		}

		$groupsLayout = $active->getParams()->get('groups_details_layout', 'default');
		if ($groupsLayout !== 'default') {
			$view->setLayout($groupsLayout);
		}

		return $view;
	}

	public function getModel($name = '', $prefix = '', $config = ['ignore_request' => true])
	{
		if (!\array_key_exists('ignore_request', $config)) {
			$config['ignore_request'] = true;
		}

		$model = parent::getModel($name, $prefix, $config);
		if (!$model instanceof BaseDatabaseModel) {
			return $model;
		}

		$app = $this->app;
		if (!$app instanceof CMSWebApplicationInterface) {
			return $model;
		}

		if ($app->getMenu() !== null) {
			$model->setState('menu.current', $app->getMenu()->getActive());
		}

		if ($id = $this->input->get('id')) {
			$model->setState('user.id', $id);
		}

		if ($groups = $this->input->getString('groups', [])) {
			$model->setState('filter.groups', explode(',', $groups));
		}

		if ($return = $this->input->get('return', '', 'base64')) {
			$model->setState('return_page', base64_decode((string)$return));
		}

		if ($search = $app->getUserStateFromRequest('com_dpusers.filter.search', 'search')) {
			$model->setState('filter.search', $search);
		}

		if ($search !== null) {
			$app->setUserState('com_dpusers.filter.search', $search);
		}

		$model->setState('list.start', $app->input->get('start', 0, 'uint'));
		$model->setState('list.limit', $app->getUserStateFromRequest('global.list.limit', 'limit', $app->get('list_limit'), 'uint'));

		return $model;
	}
}
