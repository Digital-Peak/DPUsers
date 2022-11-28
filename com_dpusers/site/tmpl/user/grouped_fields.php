<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;
?>
<div class="com-dpusers-user__fields">
    <?php foreach ($this->groupedFields as $groupId => $fields) { ?>
        <?php if ($groupId && $fields) { ?>
            <div class="dp-fieldgroup-title">
                <?php echo $fields[0]->group_title; ?>
            </div>
        <?php } ?>
        <?php foreach ($fields as $field) { ?>
            <div class="dp-description dp-description-<?php echo $field->name; ?>">
                <?php if ($field->params->get('showlabel', 1)) { ?>
                    <div class="dp-description__label">
                        <?php echo $field->label; ?>:
                    </div>
                <?php } ?>
                <div class="dp-description__content">
                    <?php echo $field->value; ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
