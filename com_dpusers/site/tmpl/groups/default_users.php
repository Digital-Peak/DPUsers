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
<div class="com-dpusers-groups__users com-dpusers-groups__users-default">
	<?php foreach ($this->users as $user) { ?>
		<div class="dp-user">
			<h2>
				<a href="<?php echo Route::_('index.php?option=com_dpusers&view=user&id=' . (int)$user->id); ?>" title="<?php echo htmlspecialchars((string)$user->name); ?>">
					<?php echo $user->name; ?>
				</a>
			</h2>
			<?php foreach ($this->headers as $header) { ?>
				<?php if ($header['field'] === 'name') { continue; } ?>
				<div class="dp-field<?php echo is_numeric($header['field']) ? ' dp-field_custom dp-field-' . $header['field'] : ''; ?>">
					<div class="dp-field__label"><?php echo $header['header']; ?></div>
					<div class="dp-field__content">
						<?php if ($header['field'] === 'email') {?>
							<a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
						<?php } else { ?>
							<?php $this->currentUser  = $user; ?>
							<?php $this->currentField = $header['field']; ?>
							<?php echo $this->loadTemplate('users_field'); ?>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>
