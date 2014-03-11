
$config = new Dotink\Affinity\Config();
$action = new Dotink\Affinity\Action();
$driver = new Dotink\Affinity\NativeDriver();
$engine = new Dotink\Affinity\Engine($config, $action, $driver);


return Affinity\Action::create([], function($engine, $app) {


});

return Affinity\Config::create([], [


]);

$engine = new Affinity\Engine($config_path, $action_path, $driver);
$engine->run('test', $app);

$engine->addConfig('init', $config);
$engine->getConfig('init')->fetch($key);

$engine->addAction('init', $action);
$engine->getAction('init')->exec($context);
