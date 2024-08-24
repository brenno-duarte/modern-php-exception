# Released Notes

## v3.3.3 - (2024-08-24)

### Fixed

- Fixed docs not render in Cli mode

--------------------------------------------------------------------------

## v3.3.2 - (2024-08-13)

### Fixed

- Fixed instance without construct in solution

--------------------------------------------------------------------------

## v3.3.1 - (2024-08-03)

### Fixed

- Fixed render solution in CLI mode

--------------------------------------------------------------------------

## v3.3.0 - (2024-07-17)

### Added

- Added `ignoreErrors` method

### Fixed

- Fixed error in occurrences

--------------------------------------------------------------------------

## v3.2.1 - (2024-06-01)

### Fixed

- Fixed numbers line colors
- Fixed when configuration file not exists
- Fixed functions if exists

--------------------------------------------------------------------------

## v3.2.0 - (2024-05-01)

### Added

- Added logs in `shutdown` method

### Changed

- Changed `var_dump_debug` and `dump_die` to accept multiple variables

### Fixed

- Fixed special chars in `errorHandler`

### Removed

- Removed `codedungeon/php-cli-colors` and `ghostff/dump7` packages
- Removed `MessageTrait` trait

--------------------------------------------------------------------------

## v3.1.2 - (2024-03-16)

### Fixed

- Fixed exception on JavaScript
- Fixed version on `composer.json`

--------------------------------------------------------------------------

## v3.1.1 - (2024-03-11)

### Fixed

- Fixed exception if request method isn't GET

--------------------------------------------------------------------------

## v3.1.0 - (2024-02-25)

### Added

- Added functions to debug PHP code
- Added debug class for logger

### Fixed

- Fixed select occurrences SQL

### Removed

- Removed `symfony/var-dumper` component

--------------------------------------------------------------------------

## v3.0.2 - (2024-02-24)

### Fixed

- Fixed scrollbar style
- Fixed view when output code on CLI mode

### Removed

- Removed `nunomaduro/termwind` and `nunomaduro/phpinsights` packages

--------------------------------------------------------------------------

## v3.0.1 - (2024-01-20)

### Fixed

- Fixed namespace class not found on `namespace_exception` key
- Fixed wrong exception trace with `filterTrace` method
- Fixed trace text not break line in `info-trace` view

--------------------------------------------------------------------------

## v3.0.0 - (2024-01-08)

### Added

- Added Occurrences in database
- Added CPU and Memory usage
- Added database support
- Added YAML config file
- Added Termwind component for CLI exception
- Added helper `getUri`
- Added HTML generator

### Fixed

- Fixed all style code with `phpinsights`
- Fixed dark mode

### Changed

- Changed CSS
- Changed trace of exception
- Changed server info
- Changed assets version
- Changed `getTitle`, `setTitle`, `getFile` and `setFile` to `protected` visibility

### Removed

- Removed methods `setFromJson`, `setFromText` and `productionModeMessage`
- Removed exception in Javascript console