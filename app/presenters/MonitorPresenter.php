<?php
namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Application\UI\Form;

class MonitorPresenter extends BasePresenter {
  private $database;

  public function __construct(Nette\Database\Context $database) {
    $this->database = $database;
  }

  protected function startup() {
    parent::startup();
    if(!$this->getUser()->isAllowed('Monitor')) {
      //throw new Nette\ApplicationForbiddenRequestException;
      $this->redirect('Homepage:');
    }
  }

  public function renderAllActivity() {
    $this->template->activity = $this->database->table('activity');
  }

  public function renderStudentActivity($userId) {
    $this->template->student = $this->database->table('users')
                                    ->where('userId = ?', $userId);
    $this->template->activity = $this->database->table('activity')
                                    ->where('userId = ?', $userId);
  }

  public function renderAllStudents() {
    $this->template->users = $this->database->table('users')
                              ->where('role = ?', 'STUDENT');
    $this->template->group = $this->database->table('group');
  }

  public function renderChangeRole() {
    $this->template->users = $this->database->table('users')
                                ->where('role = ?', 'USER');
  }

  public function renderAddGroup() {
    $this->template->groups = $this->database->table('group');
  }

  public function renderPerGroup($group) {
    $this->template->users = $this->database->table('users')->where('group = ?', $group);
  }

  public function actionEditRole($userId) {
    $u = $this->database->table('users')->get($userId);
    $u->update(['role' => 'STUDENT']);
    $this->flashMessage('You succesfully updated user ' . $userId . ' to Student.');
    $this->redirect('Monitor:changeRole');
  }

  public function createComponentAddGroupForm() {
    $form = new Form;
    $form->addText('group', 'Group to add:')
          ->addCondition(Form::MIN_LENGTH, 3)
          //->setAttribute('placeholder', 'group')
          ->setRequired();
    $form->addSubmit('submit', 'Add group');
    $form->onSuccess[] = [$this, 'addGroupFormSucceeded'];
    return $form;
  }

  public function addGroupFormSucceeded($form, $values) {
    $update = $this->database->table('group');
    $update->insert($values);
    $this->flashMessage('Added group.');
    $this->redirect('Monitor:addGroup');
  }

  public function createComponentAssignGroupForm() {
    $group = $this->database->table('group');
    $groupvalues = [];
    foreach($group as $gr) {
      $groupvalues += [$gr->group => $gr->group];
    }
    $form = new Form;
    $form->addHidden('userId');
    $form->addSelect('group', 'Group:', $groupvalues)->setPrompt('Select a group');
    $form->addSubmit('assign');
    $form->onSuccess[] = [$this, 'assignGroupFormSucceeded'];
    return $form;
  }

  public function assignGroupFormSucceeded($form, $values) {
    $update = $this->database->table('users')->get($values->userId);
    $update->update(['group' => $values->group]);
    $this->flashMessage('Succesfully changed group');
    $this->redirect('Monitor:allStudents');
  }

}
