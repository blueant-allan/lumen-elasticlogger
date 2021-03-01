# ElasticLogger a Lumen custom logger package for Cloudstaff

A package for creating custom logs in Lumen microframework

## Installation

You can install this plugin into your Lumen application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require blueant-allan/ElasticLogger
```

## Configuration

1. After installing the package in your project. You need to load the plugin, 
in your src/Application.php inside your bootstrap method add the following code 
to load the plugin.

```php
public function bootstrap()
{
    // you loaded plugins here

    $this->addPlugin('ElasticLogger');
}
```

2. To start using the plugin, load the component in your controller initialize()
method as such:

```php
public function initialize(): void
{
    parent::initialize();

    // more of your controller initialize code here


    $this->loadComponent('ElasticLogger.Logcentral');
}
```

## Usage

The library will expect the following parameters:

* EventType Can be use to describe the type of event being written to logs
* Message content message of your logs
* **(Optional)** this third parameter is optional. In case you need to pass a 
object or array, you may use this third parameter to add that object or array 
to your logs


Create an activity information log:

```php
$log = new BaseLogger();
```


```php
$log->activityInfo('EventType', 'your message');
```

Create an activity debug log:

```php
$log->activityDebug('EventType', 'your message');
```

Create an activity Error log:

```php
$log->activityError('EventType', 'your message');
```

Create an activity Notice log:

```php
$log->activityNotice('EventType', 'your message');
```

Create an activity Warning log:

```php
$log->activityWarning('EventType', 'your message');
```

Pass an array to your logs. Example below:

```php
$data = [
    'id' => 42,
    'name' => 'Mark Tune',
    'roles' => ['Admin', 'Support']
];

$log->activityInfo('Login', 'User successfully logged in', $data);
```