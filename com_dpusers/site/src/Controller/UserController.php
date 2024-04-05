<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Controller;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

class UserController extends FormController
{
	protected $view_item = 'userform';
	protected $view_list = 'groups';

	public function getModel($name = 'userform', $prefix = '', $config = ['ignore_request' => true])
	{
		if (!array_key_exists('ignore_request', $config)) {
			$config['ignore_request'] = true;
		}

		return parent::getModel($name, $prefix, $config);
	}

	protected function allowAdd($data = [])
	{
		return $this->app->getIdentity()->authorise('core.create', 'com_users');
	}

	protected function allowEdit($data = [], $key = 'id')
	{
		return $this->app->getIdentity()->authorise('core.edit', 'com_users');
	}

	public function cancel($key = null)
	{
		$result = parent::cancel($key);

		$this->setRedirect(Route::_($this->getReturnPage(), false));

		return $result;
	}

	protected function getRedirectToItemAppend($recordId = 0, $urlVar = 'id'): string
	{
		$tmpl = $this->input->get('tmpl');

		$append = $tmpl ? '&tmpl=' . $tmpl : '';
		$append .= '&layout=edit&' . $urlVar . '=' . (int) $recordId;

		if ($itemId = $this->input->getInt('Itemid')) {
			$append .= '&Itemid=' . $itemId;
		}

		if ($groups = $this->input->getString('groups')) {
			$append .= '&groups=' . $groups;
		}

		if ($return = $this->getReturnPage()) {
			$append .= '&return=' . base64_encode((string) $return);
		}

		return $append;
	}

	protected function getReturnPage()
	{
		$return = $this->input->get('return', null, 'base64');

		if (empty($return) || !Uri::isInternal(base64_decode((string) $return))) {
			return Uri::base();
		}

		return base64_decode((string) $return);
	}
}
