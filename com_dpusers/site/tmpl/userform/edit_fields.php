<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
?>
<div class="com-dpusers-userform">
    <?php foreach ($fieldsets = $this->form->getFieldsets() as $fieldset) { ?>
        <fieldset>
            <legend><?php echo Text::_($fieldset->label); ?></legend>
            <?php echo $this->form->renderFieldset($fieldset->name); ?>
        </fieldset>
    <?php } ?>
    <fieldset>
        <legend><?php echo Text::_('COM_DPUSERS_USER_VIEW_FORM_FIELDSET_GROUPS'); ?></legend>
        <?php echo HTMLHelper::_('access.usergroups', 'jform[groups]', $this->groups, true); ?>
    </fieldset>
</div>
