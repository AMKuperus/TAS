<?php

namespace App\Presenters;

use Nette;
use App\Model;

class InfoPresenter extends BasePresenter {
  private $database;

  public function __construct(Nette\Database\Context $database) {
    $this->database = $database;
  }

  public function renderAbout() {
    $this->template->anyVariable = 'any value';
  }
}
