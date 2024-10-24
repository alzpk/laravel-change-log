# Laravel Change Log
Package that makes it easy to log any changes for your models. The package uses Laravel's [Model Events](https://laravel.com/docs/eloquent) to log the changes. It will log the changes to the `changes` relation of the model, when ever a model is created, updated, or deleted.

The package will allow you to revert the latest changes, or revert changes by id, depending on the action.

## Setup
1. Start of by installing the package:
```bash
composer require alzpk/laravel-change-log
```

2. Publish the package service provider
```bash
php artisan vendor:publish --provider="Alzpk\LaravelChangeLog\ChangeLogServiceProvider"
```

3. Run the migrations
```bash
php artisan migrate
```

## Usage
To use the package, add the trait to the models you want to log:
```php
use Alzpk\LaravelChangeLog\Models\Traits\HasChangeLog;
```

## Examples
Here are some examples of how to use the package.

### Use the package
Bellow is an example of how to use the package inside your model.
```php
namespace App\Models;

use Alzpk\LaravelChangeLog\Models\Traits\HasChangeLog;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasChangeLog;
}
```

### Show changes for a model
Bellow is an example of how to use the show changes method.
```php
$product = Product::first();

$product->changes->each(function ($change) {
    dump($change);
});
```

### Revert latest changes
Bellow is an example of how to use the revert latest changes method.
```php
$product = Product::first();

$product->revertLatestChanges();
```        

### Revert changes by id
Bellow is an example of how to use the revert changes by id method.
```php
$product = Product::first();

$change = $product->changes->first();

$product->revertChangesById($change->id);
```
