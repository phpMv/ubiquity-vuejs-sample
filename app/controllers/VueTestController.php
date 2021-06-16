<?php
namespace controllers;
 use PHPMV\php\ubiquity\UVueManager;
 use PHPMV\VueJS;
 use PHPMV\VueManager;
 use Ubiquity\controllers\Controller;

 /**
  * Controller VueTestController
  */
class VueTestController extends Controller {
	private ?UVueManager $vueManager;

	public function initialize() {
		$this->vueManager=UVueManager::getInstance($this);
	}

	public function index(){
		$vue=$this->vueManager->createVue('v-app',useVuetify: true);
		$vue->addData('data','Hello world!');
		$vue->addData('items',['Programming','Design','Vue']);
		$vue->addData('select',[]);
		$vue->addData('checkbox',true);
		$this->vueManager->renderView("VueTestController/index.html");
	}
}
