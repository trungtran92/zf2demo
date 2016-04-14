<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Backend;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //set layout for module
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e){ //attach định nghĩa 1 sự kiện nào đó
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass,0, strpos($controllerClass, '\\'));
            
            $config = $e->getApplication()->getServiceManager()->get('config');
            if(isset($config['module_layouts'][$moduleNamespace])){
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        },100);
    }
    public function getServiceConfig(){
        // return array(
        //     'factories' => array(
        //         'UserTableGateway' => function($sm){
        //             $db=$sm->get('Zend\Db\Adapter\Adapter');
        //             $result=new \Zend\Db\ResultSet\ResultSet;
        //             $result->setArrayObjectPrototype(new \Training\Model\User);
        //             return new \Zend\Db\TableGateway\TableGateway('users',$db,null,$result);
        //         },
        //         'UserTable' => function($sm){
        //             $tableGateway=$sm->get('UserTableGateway');
        //             $userTable=new \Training\Model\UserTable($tableGateway);
        //             return $userTable;
        //         }
        //         ),
        //     );
    }
}
