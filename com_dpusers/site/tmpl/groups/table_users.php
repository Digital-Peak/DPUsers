<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$arguments = 'groups=' . implode(',', $this->params->get('groups_ids', [-1])) . '&return=' . base64_encode(Uri::getInstance());
?>
<table class="com-dpusers-groups__users com-dpusers-groups__users-table table table-stripped table-responsive">
    <thead>
        <tr>
            <?php foreach ($this->headers as $header) { ?>
                <th><?php echo $header['header']; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->users as $user) { ?>
            <tr>
                <?php foreach ($this->headers as $header) { ?>
                    <td>
                        <?php if ($header['field'] === 'name') {?>
                            <a href="<?php echo Route::_('index.php?option=com_dpusers&view=user&id=' . (int)$user->id); ?>">
                                <?php echo $user->name; ?>
                            </a>
                        <?php } elseif ($header['field'] === 'email') {?>
                            <a href="mailto:<?php echo $user->email; ?>">
                                <?php echo $user->email; ?>
                            </a>
                        <?php } else { ?>
							<?php $this->currentUser  = $user; ?>
							<?php $this->currentField = $header['field']; ?>
							<?php echo $this->loadTemplate('users_field'); ?>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
