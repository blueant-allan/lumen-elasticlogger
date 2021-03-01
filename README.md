# ElasticLogger a Lumen custom logger package for Cloudstaff

A package for creating custom logs in Lumen microframework

## Installation

You can install this package into your Lumen application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require blueant-allan/lumen-elasticlogger
```

## Configuration

1. After installing the package in your project. You can now instantiate the class 
by including the library as such.

```php
use blueantallan\Lumen\ElasticLogger\Logger\BaseLogger;

public function yourMethod()
{    
    $log = new BaseLogger();
    $log->activityInfo('Event Type', 'Write my test log now.');
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