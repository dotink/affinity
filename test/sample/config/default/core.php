<?php

return Affinity\Config::create(['test'], [
	'foo'   => 'bar',
	'@test' => [
		'foo' => 'bar'
	]
]);
