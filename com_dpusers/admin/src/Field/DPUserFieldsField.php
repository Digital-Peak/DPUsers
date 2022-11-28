<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Administrator\Field;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

class DPUserFieldsField extends ListField
{
	protected $type = 'DPUserFields';

	protected function getOptions()
	{
		$options = parent::getOptions();

		if (empty($this->element['only_fields']) || (string)$this->element['only_fields'] !== 'true') {
			$options[] = HTMLHelper::_('select.option', 'name', Text::_('COM_DPUSERS_USER_FIELD_NAME'));
			$options[] = HTMLHelper::_('select.option', 'email', Text::_('COM_DPUSERS_USER_FIELD_EMAIL'));
		}

		foreach (FieldsHelper::getFields('com_users.user') as $field) {
			$options[] = HTMLHelper::_('select.option', $field->id, $field->title);
		}

		return $options;
	}
}
