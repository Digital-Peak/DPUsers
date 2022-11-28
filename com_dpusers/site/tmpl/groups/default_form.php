<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
?>
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm"
	class="com-dpusers-groups__form dp-form">
    <div class="dp-form__input btn-group">
        <input type="text" name="search" class="dp-input-search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
        class="inputbox" placeholder="<?php echo Text::_('COM_DPUSERS_GROUPS_VIEW_SEARCH_INPUT_LABEL'); ?>">
        <button type="submit" class="dp-button-submit btn btn-primary"><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button>
        <button type="reset" class="dp-button-clear btn btn-secondary"><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button>
    </div>

    <div class="dp-form__limit">
        <?php echo $this->pagination->getLimitBox(); ?>
    </div>
</form>
