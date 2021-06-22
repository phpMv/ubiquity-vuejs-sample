<?php
namespace controllers;
 use models\User;
 use PHPMV\fw\ubiquity\UVueManager;
 use Ubiquity\contents\transformation\TransformersManager;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\models\UArrayModels;

 /**
  * Controller CrudUsers
  */
class CrudUsers extends ControllerBase{
	private ?UVueManager $vueManager;

	public function initialize() {
		$this->vueManager=UVueManager::getInstance($this);
	}
	protected function getfields(): array{
		return ['id','firstname','lastname','suspended'];
	}

	protected function getCaptions(): array{
		return ['Id','Nom','Prénom','Suspendu'];
	}

	protected function getHeaders(){
		$res=[];
		$captions=$this->getCaptions();
		foreach ($this->getfields() as $index=>$field){
			$res[]=['text'=>$captions[$index]??\ucfirst($field),'value'=>$field];
		}
		return $res;
	}

	protected function getItemKey(){
		return 'id';
	}

	public function index(){
		DAO::$useTransformers=true;
		DAO::$transformerOp='toView';
		$users=DAO::getAll(User::class);
		$vue=$this->vueManager->createVue('v-app','app',true);
		$vue->addData('users',UArrayModels::asArrayProperties($users,$this->getfields()));
		$vue->addData('headers',$this->getHeaders());
		$this->vueManager->renderView("CrudUsers/index.html",['item-key'=>$this->getItemKey()]);
	}
}
