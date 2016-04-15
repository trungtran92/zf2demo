<?php
namespace Trung\Controller\Navigation;
use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
class MemberNavigationFactory extends DefaultNavigationFactory{
	 protected function getName(){
        return 'member';
        }
	protected function getPages(ServiceLocatorInterface $sm){
		if(null === $this->pages){
		 $auth=$sm->get('AuthService');
		 $userData=$auth->getStorage()->read(); //thong tin user
		 $config=$sm->get('config');
		 if(!empty($userData)){
		 	$label="Logout (".$userData['username'].")";
		 }else{
		 	$label="Logout";
		 }
		 $config['navigation'][$this->getName()][]=array(
		 		'label' => $label,
		 		'route' => 'training/verify',
		 		'action' => 'logout'
		 	);
		 $app= $sm->get('Application');
		 $routeMatch=$app->getMvcEvent()->getRouteMatch();
		 $router=$app->getMvcEvent()->getRouter();
		 $pages=$this->getPagesFromConfig($config['navigation'][$this->getName()]);
		 $this->pages=$this->injectComponents($pages,$routeMatch,$router);
          
          
		}
		return $this->pages;
	}
        
}


//mau
//namespace ZendSkeletonModule\Navigation;
// 
//use Zend\ServiceManager\ServiceLocatorInterface;
//use Zend\Navigation\Service\DefaultNavigationFactory;
// 
//class MyNavigation extends DefaultNavigationFactory
//{
//    protected function getPages(ServiceLocatorInterface $serviceLocator)
//    {
//        if (null === $this->pages) {
//            //FETCH data from table menu :
//            $fetchMenu = $serviceLocator->get('menu')->fetchAll();
// 
//            foreach($fetchMenu as $key=>$row)
//            {
//                $configuration['navigation'][$this->getName()][$row['name']] = array(
//                    'label' => $row['label'],
//                    'route' => $row['route'],
//                );
//            }
//             
//            if (!isset($configuration['navigation'])) {
//                throw new Exception\InvalidArgumentException('Could not find navigation configuration key');
//            }
//            if (!isset($configuration['navigation'][$this->getName()])) {
//                throw new Exception\InvalidArgumentException(sprintf(
//                    'Failed to find a navigation container by the name "%s"',
//                    $this->getName()
//                ));
//            }
// 
//            $application = $serviceLocator->get('Application');
//            $routeMatch  = $application->getMvcEvent()->getRouteMatch();
//            $router      = $application->getMvcEvent()->getRouter();
//            $pages       = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
// 
//            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
//        }
//        return $this->pages;
//    }
//https://samsonasik.wordpress.com/2012/11/18/zend-framework-2-dynamic-navigation-using-zend-navigation/