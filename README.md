# Modern PHP Exception

Display PHP errors and exceptions in a modern and intuitive way!

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1704731088/index_yknhye.png">

## Requirements

* PHP >= 8.3
* ext-mbstring
* ext-pdo

## Installing via Composer

Use the command below:

```
composer require brenno-duarte/modern-php-exception
```

## How to use

You only need to call a single method as shown below.

```php
use ModernPHPException\ModernPHPException;

$exc = new ModernPHPException();
$exc->start();
```

From there, all errors and exceptions that are triggered will be displayed through the ModernPHPException component.

You can change the return, title and theme settings in the class constructor as shown in the items below.

## YAML configuration

You can customize the exception title, enable dark mode and also enable production mode. Use the example file `config.example.yaml` or create a new one.

```php
$config = __DIR__ . '/config.example.yaml';

$exc = new ModernPHPException($config);
$exc->start();
```

**Changing the page title**

```yaml
title: My title
```

**Enabling dark mode**

```yaml
# Default: false
dark_mode: true
```

**Enabling production mode**

```yaml
# Default: false
production_mode: true
```

To change the message, change the `error_message` variable:

```yaml
production_mode: true
error_message: Something wrong!
```

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1651412180/production-mode_zajewg.png">

**Load CSS files if there is no internet connection**

```yaml
# Use `false` only if you have no internet connection
enable_cdn_assets: false
```

## Enable occurrences

If you want to have a history of all exceptions and errors that your application displays, you can enable the occurrences using the `enableOccurrences` method:

```php
$config = __DIR__ . '/config.example.yaml';

$exc = new ModernPHPException($config);
$exc->enableOccurrences(); // <- Before `start` method
$exc->start();
```

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1704730870/occurrences_nvdmbe.png">

# Creating a solution for an exception

If you are creating a custom exception class, you can add a solution to resolve this exception.

For that, use the static `getSolution` method implementing the `SolutionInterface` interface:

```php
<?php

namespace Test;

use ModernPHPException\Solution;
use ModernPHPException\Interface\SolutionInterface;

class CustomException extends \Exception implements SolutionInterface
{
    public function getSolution(): Solution
    {
        return Solution::createSolution('My Solution')
            ->setDescription('description')
            ->setDocs('https://google.com');
    }

    #...
```

``createSolution:`` Name of solution to fix exception

``setDescription:`` Detailed description of exception solution

``setDocs:`` If a documentation exists, this method will display a button for a documentation. By default, the name of the button will be `Read More`, but you can change the name by changing the second parameter of the method

You can test using a new class:

```php
public static function staticCall()
{
    throw new CustomException("Error Processing Request");
}
```

## Test

If you want to test the component, use the `UserTest` class inside the `test/` folder or use the code below in your `index.php`.

```php
<?php

require 'vendor/autoload.php';

use ModernPHPException\ModernPHPException;
use Test\UserTest;

$exc = new ModernPHPException();
$exc->start();

#throw new Exception("Error Test", 1);

$user = new UserTest();
$user->secondCall();

$a = new FakeClass();
```

## License

MIT
