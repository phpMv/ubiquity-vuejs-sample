<?php
namespace controllers;
 use PHPMV\ajax\Http;
 use PHPMV\php\ubiquity\UVueManager;
 use PHPMV\VueJS;
 use PHPMV\VueManager;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\controllers\Controller;
 use Ubiquity\controllers\Router;
 use Ubiquity\utils\http\UResponse;

 /**
  * Controller VueTestController
  */
class VueTestController extends Controller {
	private ?UVueManager $vueManager;

	public function initialize() {
		$this->vueManager=UVueManager::getInstance($this);
	}

	#[Route('_default',name:'vue.home')]
	public function index(){
		$vue=$this->vueManager->createVue('v-app',useVuetify: true);
		$vue->addData('data','Hello world!');
		$vue->addData('items',['Programming','Design','Vue']);
		$vue->addData('select',[]);
		$vue->addData('checkbox',true);
		$this->vueManager->renderView("VueTestController/index.html");
	}

	#[Route('axios',name:'vue.axios')]
	public function axiosTester(){
		Http::init();
		$vue=$this->vueManager->createVue('v-app',useVuetify: true);
		$this->vueManager->setAxios(true);
		$vue->addData('data','Hello world!');
		$vue->addData('items',[]);
		$vue->addData('select',[]);
		$vue->addMethod('get',Http::get(Router::path('vue.get'),null,'self.items=response.data;'));
		$this->vueManager->renderDefaultView();
	}

	#[Get('get','vue.get')]
	public function get(){
		UResponse::asJSON();
		echo \json_encode(['Programming','Design','Vue']);
	}
}
