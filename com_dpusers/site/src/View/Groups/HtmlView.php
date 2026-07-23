<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\View\Groups;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Pagination\Pagination;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\Registry\Registry;

class HtmlView extends BaseHtmlView
{
	public Pagination $pagination;

	public array $headers;

	protected Registry $state;

	protected Registry $params;

	protected array $users;

	protected bool $canAddUser;

	public function display($tpl = null): void
	{
		$model = $this->getModel();

		$this->state      = $model->getState();
		$this->params     = $this->state->get('parameters.menu', new Registry());
		$this->users      = $model->getItems();
		$this->pagination = $model->getPagination();
		$this->canAddUser = false;
		$this->headers    = [];
		$this->canAddUser = $this->getCurrentUser()->authorise('core.create', 'com_users');

		foreach ($this->users as $index => $user) {
			$user->text = '';
			Factory::getApplication()->triggerEvent('onContentPrepare', ['com_users.user', $user, $user->params, $index]);
		}

		$fields = FieldsHelper::getFields('com_users.user');
		foreach ($this->params->get('groups_header_fields', []) as $header) {
			$label = Text::_('COM_DPUSERS_USER_FIELD_' . $header->field);

			$found = true;
			if (is_numeric($header->field)) {
				$found = false;
				foreach ($fields as $field) {
					if ($field->id == $header->field) {
						$label = $field->title;
						$found = true;
					}
				}
			}

			if (!$found) {
				continue;
			}

			$this->headers[] = ['field' => $header->field, 'header' => $label];
		}

		$this->_prepareDocument();

		parent::display($tpl);
	}

	private function _prepareDocument(): void
	{
		$app = Factory::getApplication();

		if ($app instanceof CMSWebApplicationInterface && $app->getMenu() !== null && $menu = $app->getMenu()->getActive()) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}

		$this->setDocumentTitle($this->params->get('page_title', ''));

		if ($this->params->get('menu-meta_description')) {
			$this->getDocument()->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('robots')) {
			$this->getDocument()->setMetaData('robots', $this->params->get('robots'));
		}
	}
}
