# Installation
```bash
composer require sifon/laravel-usage-check-package
```

# Usage

## This will return plain array of pages that use Laravel

```php
<?php

use Sifon\LaravelUsageCheckPackage\LaravelUsageCheckPackage;

LaravelUsageCheckPackage::check($yourArrayWithSites);
```

## To get txt output use this

```php
<?php

use Sifon\LaravelUsageCheckPackage\LaravelUsageCheckPackage;

$result = LaravelUsageCheckPackage::check($yourArrayWithSites);
LaravelUsageCheckPackage::output($result);
```
