<?php
namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Application\UI\Form;
use Nette\Utils\DateTime;

class StudentPresenter extends BasePresenter {
	private $database;

	public function __construct(Nette\Database\Context $database) {
		$this->database = $database;
	}

  protected function startup() {
    parent::startup();
    if(!$this->getUser()->isAllowed('Student')) {
      $this->redirect('Homepage:');
    }
  }

  public function renderDefault() {
    $this->template->activity = $this->database
                                ->table('activity')
                                ->where('userId = ?', $this->user->getIdentity()->id);
  }

  protected function createComponentActivityForm() {
    $form = new Form;
    //box activity | text | Must be filled | required
    $form->addText('activity', 'Activity:')
          ->addRule(Form::FILLED)
          ->setRequired();
    //box timespent | type number | must be int | required
    $form->addText('timeSpent', 'Time spent:')
          ->setType('number')
          ->addRule(Form::INTEGER, 'Please fill in a number.')
          ->setRequired();
    //box difficulty | type number | must be int | must be between 1-10 | required
    $form->addText('difficulty', 'Difficulty:')
          ->setType('number')
          ->addRule(Form::INTEGER, 'Please fill in a number.')
          ->addRule(Form::RANGE, 'Fill in a number between % and %', [1, 10])
          ->setRequired();
    //box satisfaction | type number | must be int | must be between 1-10 | required
    $form->addText('satisfaction', 'Satisfaction:')
          ->setType('number')
          ->addRule(Form::INTEGER, 'Please fill in a number.')
          ->addRule(Form::RANGE, 'Fill in a number between % and %', [1, 10])
          ->setRequired();
    //box notes textarea | text | max length 255
    $form->addTextarea('notes', 'Notes:')
          ->addRule(Form::MAX_LENGTH, 'Please add a smaller note', 255)
          ->setRequired(FALSE);

    $form->addSubmit('send', 'Add Activity');

    $form->onSuccess[] = [$this, 'activityFormSucceeded'];

    return $form;
  }

  public function activityFormSucceeded($form, $values) {
    $userId = $this->user->getIdentity()->id;
    $activityId = $this->getParameter('activityId');
    $startDate = date("Y-m-d H:i:s");

    if ($activityId) {
      $activity = $this->database->table('activity')->get($activityId);
      $activity->update($values);
      $this->flashMessage('You succesflly edited the activity.');
    } else {
      $this->database->table('activity')->insert([
          'userId' => $userId,
          'activity' => $values->activity,
          'startDate' => $startDate,
          'timeSpent' => $values->timeSpent,
          'difficulty' => $values->difficulty,
          'satisfaction' => $values->satisfaction,
          'notes' => $values->notes,
        ]);
        $this->flashMessage('You succesfully added a activity.', 'success');
      }
    $this->redirect('Student:');
  }

  public function actionEditActivity($activityId) {
    $activity = $this->database->table('activity')->get($activityId);
    if (!$activity) {
      $this->error('Activity not found.');
    }
    $this['activityForm']->setDefaults($activity->toArray());
  }

  public function actionFinishActivity($activityId) {
    $activity = $this->database->table('activity')->get($activityId);

    $date = date("Y-m-d H:i:s");

    if (!$activity) {
      $this->error('Activity not found.');
    }
    $activity->update(['endDate' => $date]);
    $this->redirect('Student:');
  }
}
