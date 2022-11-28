<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
?>
<div class="com-dpusers-userform__actions mb-2">
    <button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('user.save')">
        <span class="icon-check" aria-hidden="true"></span>
        <?php echo Text::_('JSAVE'); ?>
    </button>
    <button type="button" class="btn btn-danger" onclick="Joomla.submitbutton('user.cancel')">
        <span class="icon-times" aria-hidden="true"></span>
        <?php echo Text::_('JCANCEL'); ?>
    </button>
</div>
