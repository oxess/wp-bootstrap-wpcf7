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
- Init in wordpress theme :
```php
# functions.php
Ox_Bootstrap_WPCF7::init( [] );
```

## Examples:

- Simple use:
```php
# functions.php
Ox_Bootstrap_WPCF7::init( [] );
```

- With change submit css class
```php
# functions.php
Ox_Bootstrap_WPCF7::init( [
    'class__for' => array(
        'submit' => 'btn btn-default'
    )
] );
```

## Configuration:

```php
$cfg = array(
    'delimiter'     => ';',
    'priority'      => 99,
    'class__for'    => array(
        'input'    => 'form-control',
        'select'   => 'form-control',
        'textarea' => 'form-control',
        'submit'   => 'btn btn-primary',
    ),
)
```
