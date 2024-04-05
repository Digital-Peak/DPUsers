<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\View\UserForm;

use Joomla\CMS\Form\Form;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

class HtmlView extends BaseHtmlView
{
	/** @var array */
	public $grouplist;

	/** @var array */
	public $groups;

	/** @var Registry */
	protected $params;

	/** @var Form */
	protected $form;

	/** @var string */
	protected $returnPage;

	public function display($tpl = null): void
	{
		PluginHelper::importPlugin('content');

		$this->params     = $this->get('State')->get('parameters.menu', new Registry());
		$this->form       = $this->get('Form');
		$this->returnPage = $this->get('ReturnPage');

		$this->grouplist = [];
		$this->groups    = [];
		$user            = $this->getCurrentUser();
		if ((int) $user->id !== (int) $this->form->getValue('id') || $user->authorise('core.admin')) {
			$this->grouplist = $this->get('Groups');
			$this->groups    = $this->get('AssignedGroups');
		}

		$this->form->setValue('password', null);
		$this->form->setValue('password2', null);

		parent::display($tpl);
	}
}
