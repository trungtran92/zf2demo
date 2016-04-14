<?php
namespace Trung\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource;
class AclPlugin extends AbstractPlugin{
    protected $role;
    public function getAuthService() {
        $sm=$this->getController()->getServiceLocator();
        $authService=$sm->get('AuthService');
        if($authService->hasIdentity()){ //kiem tra dang nhap thanh cong
            $user=$authService->getStorage()->read();
            if($user['level']==1){
                $this->role="member";
            }else{
                $this->role="admin";
            }
        }else{
         $this->role="guest";  
        }
        return $this->role;
    }
    public function configAcl(){
         $acl=new Acl;
        $acl->deny();//chan het tat ca nhom quyen
        $acl->addRole(new Role('guest'));
        $acl->addRole(new Role('member'), array('guest'));//member kee thua quyen tu guest
        $acl->addRole(new Role('admin'), array('member'));
//        $acl->addRole(new GenericRole('member'));
//                    $acl->addRole(new GenericRole('admin'));
//                    $acl->addResource(new GenericResource('mvc:admin'));
//                    $acl->addResource(new GenericResource('mvc:community.account'));
                 
        
        $acl->addResource('training')
                ->addResource('training:user','training')
                ->addResource('training:verify','training');
        
         $acl->allow('guest','training:verify',array('index','login','denied'));
         $acl->allow('member','training:verify');
         $acl->allow('member','training:user',array('index','edit','del','access'));
         $acl->allow('admin');

         $role=$this->getAuthService();
         return $acl;
    }
    public function RoleAccess($e) {
        $role=$this->getAuthService();
        $acl=$this->configAcl();
          $route=$e->getRouteMatch();
        $controller=$route->getParam('controller');
        $moduleName= strtolower(substr($controller, 0,  strpos($controller, '\\')));
        $arr =  explode('\\', $controller);
        $controllerName= strtolower(array_pop($arr));
        $actionName=$route->getParam('action');
        	if(!$acl->isAllowed($role,$moduleName.":".$controllerName,$actionName)){
			$response=$e->getResponse();
			$response->setStatusCode(302)->setContent('Access Denied');
			$response->sendHeaders();
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
				$e->stopPropagation();
			}
		}
    }
}