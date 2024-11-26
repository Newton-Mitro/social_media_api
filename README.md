# Tafaling API

Prepared By: Newton Mitro

### Code Formatting, Fixing & Others Commands

```
// Laravel/Print (Code format fix)
./vendor/bin/pint

./vendor/bin/pint --repair

// Rector Fix Command (Code Formatting and Fixing)
composer run rector-fix

// Create .env from .evn.example
composer run post-root-package-install

// Generate App Key, mysql db, and migrate command
composer run post-create-project-cmd

// Clear Storage Log
truncate -s 0 storage/logs/laravel.log

composer dump-autoload
php artisan optimize:clear
```

```php
// To run all test
php artisan test

// To run specific test
php artisan test --filter LoginTest

sudo apt install ffmpeg
sudo apt install php-gd
sudo apt install php-imagick
```
