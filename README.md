Statistics (Laravel4 Package)
========

Statistics package provides a simple way to custom any statistics to **Laravel4**.

## Quick start

### Required setup

In the `require` key of `composer.json` file add the following

    "davin-bao/statistics": "dev-master"

Run the Composer update comand

    $ composer update

In your `config/app.php` add `'DavinBao\Statistics\StatisticsServiceProvider','` to the end of the `$providers` array

```php
'providers' => array(

    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    ...
    'DavinBao\Statistics\StatisticsServiceProvider',

),
```

At the end of `config/app.php` add `'Statistics'       => 'DavinBao\Statistics\StatisticsFacade'` to the `$aliases` array

```php
'aliases' => array(

    'App'        => 'Illuminate\Support\Facades\App',
    'Artisan'    => 'Illuminate\Support\Facades\Artisan',
    ...
    'Statistics'       => 'DavinBao\Statistics\StatisticsFacade',

),
```

### Configuration

### Create Table

Now generate the statistics migration

    $ php artisan statistics:migration

It will generate the `<timestamp>_statistics_setup_tables.php` migration. You may now run it with the artisan migrate command:

    $ php artisan migrate

After the migration, statistics tables will be present.

### Create Controllers & Views

    $ php artisan statistics:views

### Create Routes

    $ php artisan statistics:routes

### Using

Go to /admin/statistics, you can change the style or add others functions

