# NatsBundle

## About ##

This bundle integrates [Nats](https://nats.io) into your Symfony2 application.

## Installation ##

Add the `octante/nats-bundle` package to your `require` section in the `composer.json` file.

``` bash
$ composer require octante/nats-bundle
```

Add the NatsBundle to your application's kernel:

``` php
<?php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Octante\NatsBundle\OctanteNatsBundle(),
        // ...
    );
    ...
}
```

## Usage ##

Configure the `nats` client(s) in your `config.yml`:

``` yaml
octante_nats:
    host: localhost
    port: 4222
    user: user
    password: password
    verbose: false
    reconnect: true
    version: 0.0.5
    pedantic: false
    lang: php
```

You can now access nats client. In case of a publisher:

``` php
<?php
$connection = $this->getContainer()->get('octante_nats.connection');
$connection->publish("foo", "bar");
```

In case of a subscriber:
``` php
<?php
$connection = $this->getContainer()->get('octante_nats.connection');

$callback = function ($payload) {
    var_dump($payload);
};

$sid = $connection->subscribe("foo", $callback);
$connection->wait(2);
$connection->unsubscribe($sid);
```