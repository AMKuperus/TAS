<?php

namespace App\Presenters;

use Nette;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Nette\Application\Responses\JsonResponse;

class JsonPresenter extends BasePresenter {
  private $database;

  public function __construct(Nette\Database\Context $database) {
    $this->database = $database;
  }

  public function actionJson() {
    $info = ['www' => '/TAS/www/sign/in',
            'about_TAS' => 'TAS is a Student Activity Tracker',
            'ITVitae' => 'Anders denken!'];
    try {
      Json::encode($info);
      $this->sendResponse(new JsonResponse($info));
    } catch (JsonException $e) {
      $this->flashMessage($e->getMessage());
    }
  }
}
?>
