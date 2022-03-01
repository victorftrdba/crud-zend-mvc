<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\AbstractModel;
use Zend\Db\Adapter\AdapterInterface;
use Application\Controller\IndexController;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.1.3';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                    AbstractModel::class => function ($container) {
                        $dbAdapter = $container->get(AdapterInterface::class);
                        return new AbstractModel($dbAdapter);
                    }
                ]
            ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                IndexController::class => function ($container) {
                    return new IndexController($container->get(AdapterInterface::class));
                }
            ]
        ];
    }
}