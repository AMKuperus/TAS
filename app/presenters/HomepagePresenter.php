<?php

namespace App\Presenters;

use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter
{
	private $database;

	public function __construct(Nette\Database\Context $database) {
		$this->database = $database;
	}

	public function renderUsername() {
		$this->template->username = $this->database->table('users')->where('id = ?', $user->getUserId());
	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
