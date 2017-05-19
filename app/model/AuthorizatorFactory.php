<?php
namespace App\Model;
use Nette;
use Nette\Security\Permission;

class AuthorizatorFactory {
  /**
  * @return \Nette\Security\IAuthorizator
  */
  public static function create() {
    $permission = new Permission;
    $permission->addRole('ADMIN');
    $permission->addRole('MONITOR');
    $permission->addRole('STUDENT');
    $permission->addRole('USER');
    $permission->addRole('guest');

    $permission->addResource('Admin');
    $permission->addResource('Monitor');
    $permission->addResource('Student');

    $permission->allow('ADMIN', 'Admin');
    $permission->allow('MONITOR', 'Monitor');
    $permission->allow('STUDENT', 'Student');

    $permission->deny('MONITOR', 'Admin');
    $permission->deny('STUDENT', 'Admin');
    $permission->deny('USER', 'Admin');

    $permission->deny('ADMIN', 'Monitor');
    $permission->deny('STUDENT', 'Monitor');
    $permission->deny('USER', 'Monitor');

    $permission->deny('ADMIN', 'Student');
    $permission->deny('MONITOR', 'Student');
    $permission->deny('USER', 'Student');

    return $permission;
  }
}
