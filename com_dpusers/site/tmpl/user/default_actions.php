<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

$return = '&return=' . base64_encode(Uri::getInstance());
?>
<div class="com-dpusers-user__actions">
    <?php if ($this->permissions->get('can_edit')) {?>
        <a href="<?php echo Route::_('index.php?option=com_dpusers&task=user.edit&id=' . (int)$this->user->id . $return); ?>"
            class="dp-link dp-action-edit">
            <?php echo Text::_('JACTION_EDIT'); ?>
        </a>
    <?php } ?>
</div>
