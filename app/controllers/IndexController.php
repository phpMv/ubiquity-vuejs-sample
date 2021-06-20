<?php
namespace controllers;
use Ajax\php\ubiquity\JsUtils;
use Ajax\semantic\html\elements\html5\HtmlLink;
use Ubiquity\attributes\items\router\Route;

use Ubiquity\core\postinstall\Display;
use Ubiquity\log\Logger;
use Ubiquity\themes\ThemesManager;

/**
 * Controller IndexController
 * @property JsUtils $jquery
 */
class IndexController extends ControllerBase {

	public function index() {
		$defaultPage = Display::getDefaultPage();
		$links = Display::getLinks();
		$infos = Display::getPageInfos();

		$activeTheme = ThemesManager::getActiveTheme();
		$themes = Display::getThemes();
		if (\count($themes) > 0) {
			$this->loadView('@activeTheme/main/vMenu.html', \compact('themes', 'activeTheme'));
		}
		$this->loadView($defaultPage, \compact('defaultPage', 'links', 'infos', 'activeTheme'));
	}

	public function ct($theme) {
		$themes = Display::getThemes();
		if ($theme != null && \array_search($theme, $themes) !== false) {
			$config = ThemesManager::saveActiveTheme($theme);
			\header('Location: ' . $config['siteUrl']);
		} else {
			Logger::warn('Themes', \sprintf('The theme %s does not exists!', $theme), 'changeTheme(ct)');
			$this->forward(IndexController::class);
		}
	}

	

	#[Route(path: "Index/test",name: "index.test")]
	public function test(){
		$bc=$this->jquery->semantic()->htmlBreadcrumb('bc',['a'=>'aa','b'=>'bb','c'=>'cc']);
		$bc->addItem(['bla','test']);
		$bc->addItem('e');
		$this->jquery->renderView('IndexController/test.html');
	}

}
