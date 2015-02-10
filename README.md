Affinity - A Bootstrapper for PHP Projects
======

Affinity is a bootstrapper for PHP projects which allows you to create modular
configurations and actions that can be dropped into place for added
functionality without additional work.

It provides mechanisms for running bootstrap operations and logic as well as
creating and accessing well organized configuration data.

Affinity is a key component of the inKWell framework, you can read more
about the integration of it at:

http://inkwell.dotink.org/docs/basics/02-nano-core#Bootstrapping

Or... continue reading below for standalone use.

## Basic Usage

```php
$engine = new Affinity\Engine(
	new Affinity\NativeDriver('/path/to/configs'),
	new Affinity\NativeDriver('/path/to/actions')
);

$engine->start('production', ['app' => $app, 'di' => $di]);
```

This example shows the most basic setup of affinity.  Using the native driver
we can scan directories recursively for configurations or actions to load
then call `start()` in order to execute bootstrapping.

## Configuration / Action Directory Structure

The native driver assumes that your configuration and action directory
structure looks like the following:

--- config_root [this is what you pass to the __construct() call]
 |
 |- default
 |
 |- environment1
 |
 |- environment2
 |
 |- ...


All configs and actions from `default` will be included no matter what and
will be extended based on the environment provided to the `start()` call.

You can extend by multiple environments by passing a comma separated list:

```php
$engine->start('production, europe', $context);
```

This allows you to only override the necessary config data or logic for
the specific environment requirements whether they be the execution mode,
deployment stability, location, whatever.

The directory structure inside each environment folder is up to you,
although it is suggested you use additional sub directories for namespacing
purposes.

The relative path to a given config file or action is used by affinity as
a means to identify the configuration or action.  So, for example
`config/default/core.php` is identified by the simple string `'core'` while
a file such as `include/default/routes/main.php` is identified by
`'routes/main'`.

## Configurations

You can create a configuring by returning it from any PHP file located in
an environment directory.  For example, let's imagine adding the following
to `config/default/test.php`:

```php
return Affinity\Config::create([

	'key' => 'value',

	'parent' => [
		'child' => 'value'
	]
]);
```

### Accessing Configuration Data

Once a config is created, you can access configuration data by using the
`fetch()` method on the affinity engine.

```php
$engine->fetch('test', 'key', 'default');
```

The parameters for the `fetch()` method are the configuration id, the
parameter within that configuration, and the default value if it's not
found, respectively.  You can access deeply nested data using a javascript
style object notation for the second parameter:

```php
$engine->fetch('test', 'parent.child', 'default');
```

### Aggregate IDs

In addition to identifying a specific configuration to fetch data from, it
is also possible to specify types of information which may be provided by
multiple configurations using an aggregate ID.  All aggregate IDs must
begin with `@`:

```php
$engine->fetch('@providers', 'mapping', array());
```

In order to provide information for aggregate ID fetches, you need to pass
an optional first parameter to the `Affinity\Config::create()` method
containing a list of aggregates you provide.  The data is then keyed
initially under the aggregate ID within the config itself.

```php
return Affinity\Config::create(['providers'], [
	'@providers' => [
		'mapping' => [
			'Dotink\Package\UsefulInterface' => 'My\Concrete\ProviderClass'
		]
	]
]);
```

When fetching information from an aggregate ID, the returned array consists
of one entry for every configuration file which provides that aggregate data
keyed by the specific configuration id.  In the case of the above mappings,
this means we have to first loop over the individual configuration data,
and *then* over the mapping themselves.

You can fetch a list of specific IDs which provide aggregate data by fetching
the aggregate ID alone, without specifying a parameter:

```php
foreach ($engine->fetch('@providers') as $id) {
	$provider_mapping = $engine->fetch($id, '@providers.mapping', []);
	$provider_params  = $engine->fetch($id, '@providers.params',  []);

	foreach ($provider_mapping as $interface => $provider) {
		$injector->alias($interface, $provider);
	}

	foreach ($provider_params as $provider => $params) {
		$injector->define($provider, $params);
	}
}
```

## Actions

Actions are pieces of modularized and pluggable logic which use the
configuration data in order to prepare your application for running.
Some of their main functions include:

- Setting up dependency wiring
- Running static class methods for config or setting static class properties
  for config
- Registering providers in the application container

Unlike configs which are just arrays of information, actions represent callable
logic.

#### Creating an Action

Add a file to the appropriate environment and return
`Affinity\Action::create()`:

```php
return Affinity\Action::create(function($app, $di) {
	//
	// Your bootstrap logic here
	//
});
```

## Context

In our first example you may have noted the addition of an array which was
passed to the `start()` method on the engine:

```php
$engine->start('production', ['app' => $app, 'di' => $di]);
```

This is the context.  If you didn't pick up on it before, it is provided
to the action operations and is also available in the configuration as
normal variables.  The context can be whatever you want, but is usually
used to provide your application instance and dependency injector for
use in configs and actions respectively.
