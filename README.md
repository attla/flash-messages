# Dynamic flash messages for laravel

<p align="center">
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-lightgrey.svg" alt="License"></a>
<a href="https://packagist.org/packages/attla/flash-messages"><img src="https://img.shields.io/packagist/v/attla/flash-messages" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/attla/flash-messages"><img src="https://img.shields.io/packagist/dt/attla/flash-messages" alt="Total Downloads"></a>
</p>

✨ Intuitive package to flash notifications on laravel.

## Installation

```bash
composer require attla/flash-messages
```

## Configuration

To publish the configuration file, run the following command:

```bash

php artisan vendor:publish --tag=attla/flash-messages/config

```

The `types` array on configuration is usaded to indicate the class to the message.

The `icons` are default icons for each message type.

## Usage

For create a new message you call the facade method as the type name from the configuration

```php

use Attla\Flash\Facade as Flash;

// Create a flash message with the helper function
$flash = flash('Example of message', 'info');
// Create with facade
$flash = Flash::info('Example of message');

// Set the message as dismissible
$flash->dismissible();

// Set a custom class for the message
$flash->class('custom-message-class');

// Set a icon for the message
$flash->icon('far fa-circle-info');
$flash->icon('<i class="far fa-circle-info"></i>');

// Set a timeout for the message
$flash->timeout(6); // will be removed after 6 seconds

// If needed, you can unqueue the message
$flash->destory();

```

### List of message methods

| Method | Parameters | Description |
|--|--|--|
| ``dismissible()`` | - | Make the message disposable |
| ``timeout(seconds)`` | Integer | The message will be removed after the time |
| ``class(class)`` | String | Set a custom class for the message |
| ``destory()`` | - | Unqueue the message |
| ``delete()`` | - | Alias for ``destory()`` |
| ``forget()`` | - | Alias for ``destory()`` |
| ``unset()`` | - | Alias for ``destory()`` |
| ``unqueue()`` | - | Alias for ``destory()`` |

## License

This package is licensed under the [MIT license](LICENSE) © [Octha](https://octha.com).
