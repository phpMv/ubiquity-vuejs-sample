<?php
namespace controllers;
 use PHPMV\VueJS;
 use PHPMV\VueManager;
 use Ubiquity\controllers\Controller;

 /**
  * Controller VueTestController
  */
class VueTestController extends Controller {
	private ?VueManager $vueManager;

	public function initialize() {
		$this->vueManager=VueManager::getInstance();
	}

	public function index(){
		$vue=new VueJS(['el'=>'v-app','delimiters'=>['<%','%>']],useVuetify:true);
		$vue->addData('data','Hello world!');
		$this->vueManager->addVue($vue);
		$this->loadView("VueTestController/index.html",['script_foot'=>$this->vueManager]);
	}
}
