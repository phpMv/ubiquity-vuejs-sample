<?php
use Ubiquity\controllers\Router;

\Ubiquity\cache\CacheManager::startProd($config);
\Ubiquity\orm\DAO::start();
Router::start();
Router::addRoute("_default", "controllers\\VueTestController");
\Ubiquity\assets\AssetsManager::start($config);
\PHPMV\fw\ubiquity\UVueManager::start($config);
