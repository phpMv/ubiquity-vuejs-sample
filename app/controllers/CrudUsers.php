<?php

namespace controllers;

use models\User;
use Ubiquity\controllers\vuejs\VuetifyJSController;
use Ubiquity\orm\DAO;
use Ubiquity\utils\models\UArrayModels;

/**
 * Controller CrudUsers
 */
class CrudUsers extends VuetifyJSController {

	protected function getfields(): array {
		return ['id', 'firstname', 'lastname', 'suspended'];
	}

	protected function getCaptions(): array {
		return [];
	}

	protected function getHeaders(): array {
		$res = [];
		$captions = $this->getCaptions();
		foreach ($this->getfields() as $index => $field) {
			$res[] = ['text' => $captions[$index] ?? \ucfirst($field), 'value' => $field];
		}
		return $res;
	}

	protected function getItemKey(): string {
		return 'id';
	}

	public function index() {
		DAO::$useTransformers = true;
		DAO::$transformerOp = 'toView';
		$users = DAO::getAll(User::class);
		$this->vue->addData('users', UArrayModels::asArrayProperties($users, $this->getfields()));
		$this->vue->addData('headers', $this->getHeaders());
		$this->loadView('CrudUsers/index.html', ['item-key' => $this->getItemKey()]);
	}
}
