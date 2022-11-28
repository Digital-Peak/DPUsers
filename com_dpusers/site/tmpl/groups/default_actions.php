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

$arguments = 'groups=' . implode(',', $this->params->get('groups_ids', [-1])) . '&return=' . base64_encode(Uri::getInstance());
?>
<div class="com-dpusers-groups__actions">
    <?php if ($this->canAddUser) {?>
        <a href="<?php echo Route::_('index.php?option=com_dpusers&task=user.add&'  . $arguments); ?>" class="dp-link dp-action-edit">
            <?php echo Text::_('JACTION_CREATE'); ?>
        </a>
    <?php } ?>
</div>
