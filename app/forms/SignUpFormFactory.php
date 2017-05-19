<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model;


class SignUpFormFactory
{
	use Nette\SmartObject;

	const PASSWORD_MIN_LENGTH = 7;

	/** @var FormFactory */
	private $factory;

	/** @var Model\UserManager */
	private $userManager;


	public function __construct(FormFactory $factory, Model\UserManager $userManager)
	{
		$this->factory = $factory;
		$this->userManager = $userManager;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('username', 'Username:')
			->setRequired('Please pick a username.');

		$form->addEmail('email', 'E-mail:')
			->setRequired('Please enter your e-mail.');

		$form->addPassword('password', 'Password:')
			->setOption('description', sprintf('at least %d characters', self::PASSWORD_MIN_LENGTH))
			->setRequired('Please create a password.')
			->addRule($form::MIN_LENGTH, NULL, self::PASSWORD_MIN_LENGTH);

		//$form->addText('firstName', 'First name:')->setRequired('Please type your first name');
		//$form->addText('lastNamePrefix', 'Prefix lastname');
		//$form->addText('lastName', 'Last name:')->setRequired('Please type your last name');

		$form->addSubmit('send', 'Sign up');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->userManager->add($values->username,
																$values->email,
																$values->password);
			} catch (Model\DuplicateNameException $e) {
				$form['username']->addError('Username is already taken.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}

}
