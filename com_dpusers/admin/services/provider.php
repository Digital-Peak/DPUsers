<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
	public function register(Container $container): void
	{
		$container->registerServiceProvider(new MVCFactory('\\DigitalPeak\\Component\\DPUsers'));
		$container->registerServiceProvider(new ComponentDispatcherFactory('\\DigitalPeak\\Component\\DPUsers'));
		$container->registerServiceProvider(new RouterFactory('\\DigitalPeak\\Component\\DPUsers'));

		$container->set(
			ComponentInterface::class,
			static function (Container $container): MVCComponent {
				$component = new class ($container) extends MVCComponent implements RouterServiceInterface {
					use RouterServiceTrait;

					public function __construct(Container $container)
					{
						parent::__construct($container->get(ComponentDispatcherFactoryInterface::class));
					}
				};

				$component->setMVCFactory($container->get(MVCFactoryInterface::class));
				$component->setRouterFactory($container->get(RouterFactoryInterface::class));

				return $component;
			}
		);
	}
};
