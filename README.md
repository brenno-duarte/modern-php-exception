# Modern PHP Exception

PHP errors in a modern way

<img src="https://res.cloudinary.com/bdlsltfmk/image/upload/v1619660763/exception-2_rqjirs.png">

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
