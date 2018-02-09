Nette menu content
==================

Installation
------------
```sh
$ composer require geniv/nette-menu-content
```
or
```json
"geniv/nette-menu-content": ">=1.0.0"
```

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0",
"geniv/nette-locale": ">=1.0.0"
```

Include in application
----------------------
neon configure:
```neon
services:
    - MenuContent(%tablePrefix%rule_)
```

usage:
```php
protected function createComponentMenuContent(MenuContent $menuContent)
{
    // $menuContent->setTemplatePath(__DIR__ . '/templates/MenuContent.latte');
    return $menuContent;
}
```

usage:
```latte
{control menuContent}
```
