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

If you want to highlight a part of the message during an exception, you can use `{` and `}`.

```php
use ModernPHPException\ModernPHPException;

$exc = new ModernPHPException();
$exc->start();

throw new CustomException("Highlighting {this part}");
```

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

**Enabling Log file**

```yaml
enable_logs: false

# Default: sys_get_temp_dir() . "/ModernPHPExceptionLogs/ModernPHPExceptionLogs.log"
dir_logs: C:\wamp64\www\modern-php-exception\
```

## Enable occurrences

If you want to have a history of all exceptions and errors that your application displays, you can enable the occurrences using the `enableOccurrences` method:

```php
$config = __DIR__ . '/config.example.yaml';

$exc = new ModernPHPException($config);
$exc->enableOccurrences(); // <- Before `start` method
$exc->start();
```

Don't forget to configure the database in the `config.example.yaml` file.

```yaml
# Database for Occurrences
db_drive: mysql
db_host: localhost
db_name: database_name
db_user: root
db_pass: pass
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

- `createSolution:` Name of solution to fix exception
- `setDescription:` Detailed description of exception solution
- `setDocs:` If a documentation exists, this method will display a button for a documentation. By default, the name of the button will be `Read More`, but you can change the name by changing the second parameter of the method

You can test using a new class:

```php
public static function staticCall()
{
    throw new CustomException("Error Processing Request");
}
```

## Functions

Modern PHP Exceptions has some functions to help you debug your code. The available functions are:

- An easy function to pull all details of the debug backtrace.

```php
get_debug_backtrace();
```

- Function to returns the value of `var_dump()` instead of outputting it.

```php
echo var_dump_buffer();
```

- PHP function to replace var_dump(), print_r() based on the XDebug style.

```php
var_dump_debug();
```

In terminal, you can simple hide or show some object attribute using a Doc block flag:

|                               |                                                   |
|-------------------------------|---------------------------------------------------|
| `@dumpignore-inheritance`     | Hides inherited class properties.                 |
| `@dumpignore-inherited-class` | Hides the class name from inherited properties.   |
| `@dumpignore-private`         | Show all properties except the **private** ones.  |
| `@dumpignore-protected`       | Show all properties except the **protected** ones.|
| `@dumpignore-public`          | Show all properties except the **public** ones.   |
| `@dumpignore`                 | Hide the property the Doc comment belongs to.     |

```php
/**
* @dumpignore-inheritance
* @dumpignore-inherited-class
* @dumpignore-private
* @dumpignore-public
* @dumpignore-public
*/
Class Foo extends Bar {
    /** @dumpignore */
    private ?BigObject $foo = null;
}
```

- Dump PHP value and die script.

```php
dump_die();
```

- View a PHP Closure's Source

```php
echo closure_dump();
```

## Logger

If you want to record a log to a file, you can use the `Debug` class. To record a log, use the `log` method.

```php
use ModernPHPException\Debug;

Debug::log($message, $log_file);
```

You can register the file and line on which this method is being called.

```php
use ModernPHPException\Debug;

Debug::log($message, $log_file, __FILE, __LINE__);
```

And to retrieve the logs that were recorded in a file, use the `get` method.

```php
use ModernPHPException\Debug;

Debug::get($log_file);
```

## Test

If you want to test the component, use the code below in your `index.php`.

```php
<?php

require 'vendor/autoload.php';

use ModernPHPException\ModernPHPException;

$exc = new ModernPHPException();
$exc->start();

throw new Exception("Error Test", 1);

$a = new FakeClass();
```

## License

MIT
