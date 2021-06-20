<?php
namespace controllers;
 use PHPMV\ajax\Http;
 use PHPMV\fw\ubiquity\UVueManager;
 use PHPMV\VueJSComponent;
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

	#[Route('compoLocal',name:'vue.compoLocal')]
	public function compoLocalTester(){
		$vue=$this->vueManager->createVue('#components-demo');
		$compo=new VueJSComponent('button-counter');
		$compo->addTemplate("<button v-on:click='count++'>Vous m\'avez cliqué \${ count } fois.</button>");
		$compo->addData('count',0);
		$vue->addComponent($compo);
		$this->vueManager->importComponentObject($compo);
		$this->vueManager->renderDefaultView();
	}

	#[Route('compoGlobal',name:'vue.compoGlobal')]
	public function compoGlobalTester(){
		$this->vueManager->createVue('#components-demo');
		$compo=$this->vueManager->createComponent('button-counter');
		$compo->addTemplate("<button v-on:click='count++'>Vous m\'avez cliqué $\{ count } fois.</button>");
		$compo->addData('count',0);
		$this->vueManager->renderDefaultView();
	}

	#[Route('compoGlobalVue',name:'vue.compoGlobalVue')]
	public function compoGlobalWithVueTester(){
		$vue=$this->vueManager->createVue('v-app',null,true);
		$compo=new VueJSComponent('button-counter');
		$compo->addData('count',0);
		$this->vueManager->addTemplateFileComponent('button-counter.html',$compo,['type'=>'primary']);
		$vue->addComponent($compo);
		$this->vueManager->importComponentObject($compo);
		$this->vueManager->renderView('VueTestController/compoGlobalTester.html');
	}

	#[Get('get','vue.get')]
	public function get(){
		UResponse::asJSON();
		echo \json_encode(['Programming','Design','Vue']);
	}
}
