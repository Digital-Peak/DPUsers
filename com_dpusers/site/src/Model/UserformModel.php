<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Model;

use Joomla\CMS\Form\Form;
use Joomla\Component\Users\Administrator\Model\UserModel;
use Joomla\Utilities\ArrayHelper;

class UserformModel extends UserModel
{
	public function getForm($data = [], $loadData = true)
	{
		Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_users/forms');

		$form = parent::getForm($data, $loadData);
		if ($form instanceof Form) {
			$form->setValue('password', '');
			$form->setValue('groups', null, ArrayHelper::toInteger($this->getState('filter.groups', [])));
		}

		return $form;
	}

	public function getReturnPage(): string
	{
		return base64_encode((string)$this->getState('return_page', ''));
	}
}
