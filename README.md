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
//TODO udelat vykreslovani na instance

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0",
"dibi/dibi": ">=3.0.0",
"geniv/nette-locale": ">=1.0.0",
"geniv/nette-general-form": ">=1.0.0"
```

Include in application
----------------------
neon configure:
```neon
services:
    - MenuContent(%tablePrefix%)
```

usage:
```php
protected function createComponentMenuContent(MenuContent $menuContent): MenuContent
{
    // $menuContent->setTemplatePath(__DIR__ . '/templates/MenuContent.latte');
    // $menuContent->setTemplatePathByIdent('ident1', 'path1');
    // $menuContent->setTemplatePathByIdent('ident2', 'path2');
    // $menuContent->setIdLocale(null);
    return $menuContent;
}
```

usage:
```latte
{control menuContent}
or
{control menuContent 'ident1'}
{control menuContent 'ident2'}
```
