<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\View\UserForm;

use DigitalPeak\Component\DPUsers\Site\Model\UserformModel;
use Joomla\CMS\Form\Form;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

class HtmlView extends BaseHtmlView
{
	public array $grouplist;

	public array $groups;

	protected Registry $params;

	protected Form $form;

	protected string $returnPage;

	public function display($tpl = null): void
	{
		PluginHelper::importPlugin('content');

		/** @var UserformModel $model */
		$model = $this->getModel();

		$state            = $model->getState();
		$this->params     = $state->get('parameters.menu', new Registry());
		$this->returnPage = $model->getReturnPage();
		$this->form       = $model->getForm();

		$this->grouplist = [];
		$this->groups    = [];
		$user            = $this->getCurrentUser();
		if ($user->id !== (int)$this->form->getValue('id') || $user->authorise('core.admin')) {
			$this->grouplist = $model->getGroups();
			$this->groups    = $model->getAssignedGroups();
		}

		$this->form->setValue('password');
		$this->form->setValue('password2');

		parent::display($tpl);
	}
}
