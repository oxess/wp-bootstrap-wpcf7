# wp-bootstrap-wpcf7

## How it's works?
This is easy, contact form 7 use a wordpress filters as every good wrote plugin in wordpress.
This script create a filter & looking for inputs, in render html, and add class
`form-control` to find inputs.
It's all.

## install:

- Add as composer dependences:
```bash
composer require oxess/wp-bootstrap-wpcf7
```
- Import in wordpress theme :
```php
# functions.php
require_once __DIR__ . '/vendor/oxess/wp-bootstrap-wpcf7/wp-bootstrap-wpcf7.php';
```
