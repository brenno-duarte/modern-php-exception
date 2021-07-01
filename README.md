# Modern PHP Exception

PHP errors in a modern way

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1620047557/exception_uzifw3.png">

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

## Return in JSON

To return an exception in JSON, use the `setFromJson()` method.

```php
$exc = new ModernPHPException();
$exc->setFromJson();
$exc->start();
```

## Changing the title

You can change the page title using `setTitle`.

```php
# ...
$exc->setTitle("My title");
# ...
```

## Dark mode

### Dark mode only in code

To change only the code theme, use `useCodeDark`.

```php
#...
$exc->useCodeDark();
#...
```

### Dark mode in every exception

To change the whole theme, use `useDarkTheme`.

```php
#...
$exc->useDarkTheme();
#...
```

# Production mode

When a project made in PHP is in production, it's not good to have technical errors. Therefore, you can display a screen for these cases.

```php
#...
$exc->productionMode();
#...
```

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1625058687/error_screen_k09avd.png">

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
```

## License

MIT
