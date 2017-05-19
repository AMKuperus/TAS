<?php
namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Application\UI\Form;

class AdminPresenter extends BasePresenter {
  private $database;

  public function __construct(Nette\Database\Context $database) {
    $this->database = $database;
  }

  protected function startup() {
    parent::startup();
    if(!$this->getUser()->isAllowed('Admin')) {
      $this->redirect('Homepage:');
    }
  }

  public function renderDefault() {
    $this->template->users = $this->database->table('users');
  }

  public function renderUser() {
    $this->template->users = $this->database->table('users')->where('role = ?', 'USER');
  }

  public function renderStudent() {
    $this->template->users = $this->database->table('users')->where('role = ?', 'STUDENT');
  }

  public function renderMonitor() {
    $this->template->users = $this->database->table('users')->where('role = ?', 'MONITOR');
  }

  public function renderAdmin() {
    $this->template->users = $this->database->table('users')->where('role = ?', 'ADMIN');
  }

  public function renderChangeRole($userId) {
    $this->template->userUser = $this->database->table('users')->where('userId = ?', $userId);
    $this->template->userId = $userId;
  }

  protected function createComponentEditRoleForm() {
    $form = new Form;
    $roles = ['STUDENT' => 'Student',
              'MONITOR' => 'Monitor',
              'ADMIN'   => 'Administrator'];

    $form->addSelect('role', 'New role:', $roles)->setPrompt('Pick a role');
    $form->addSubmit('submit', 'Update');
    $form->onSuccess[] = [$this, 'editRoleFormSucceeded'];

    return $form;
  }

  public function editRoleFormSucceeded($form, $values) {
    $id = $this->getParameter('userId');
    $update = $this->database->table('users')->get($id);
    $update->update($values);
    $this->flashMessage('Succesfully updated user with id ' . $id . '.');
    $this->redirect('Admin:');
  }
}
