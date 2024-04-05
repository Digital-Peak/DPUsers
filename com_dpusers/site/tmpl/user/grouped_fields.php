<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;
?>
<div class="com-dpusers-user__fields">
    <?php foreach ($this->groups as $group) { ?>
		<?php if (!array_key_exists($group->id, $this->groupedFields) || !$this->groupedFields[$group->id]) {
	continue;
} ?>
        <div class="dp-fieldgroup-title"><?php echo $group->title; ?></div>
        <?php foreach ($this->groupedFields[$group->id] as $field) { ?>
			<?php if ($field->params->get('display', '1') == '0') {
	continue;
} ?>
            <div class="dp-description dp-description-<?php echo $field->name; ?>">
                <?php if ($field->params->get('showlabel', 1)) { ?>
                    <div class="dp-description__label"><?php echo $field->label; ?>:</div>
                <?php } ?>
                <div class="dp-description__content"><?php echo $field->value; ?></div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
