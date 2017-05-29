<?php

namespace App\Presenters;

use Nette;
use App\Model;

use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class HomepagePresenter extends BasePresenter
{
	private $database;

	private $mailer;

	public function __construct(Nette\Database\Context $database, Nette\Mail\IMailer $mailer) {
		$this->database = $database;
		$this->mailer = $mailer;
	}

	public function renderUsername() {
		$this->template->username = $this->database->table('users')->where('id = ?', $user->getUserId());
	}

	public function renderDefault()
	{
		#$this->template->anyVariable = 'any value';
		$this->redirect('Sign:in');
	}



	public function renderSendEmail() {
		$mail = new Message;
		$mail->setFrom('Someone <test@amkuperus.nl>')
					->addTo('jezeewolde@gmail.com')
					->setSubject('Testemail')
					->setBody('Testing123, de mailfunctie blijkt te werken!');

		try {
			$this->mailer->send($mail);
			$this->flashMessage('Mail send succesfull.');
		} catch (SmtpException $e) {
			$this->flashMessage($e->getMessage());
		}
		$this->redirect('Homepage:');
	}

}
