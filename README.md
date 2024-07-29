# A realtime chat application with laravel and pusher

[![Latest Version on Packagist](https://img.shields.io/packagist/v/blinqpay/payment-router.svg?style=flat-square)](https://packagist.org/packages/blinqpay/payment-router)
[![Total Downloads](https://img.shields.io/packagist/dt/blinqpay/payment-router.svg?style=flat-square)](https://packagist.org/packages/blinqpay/payment-router)
![GitHub Actions](https://github.com/blinqpay/payment-router/actions/workflows/main.yml/badge.svg)

This is a simple laravel chat application where users can login and create chat message with other users in realtime.

### Installation Steps

```bash
Clone project
Run composer install for the main project
Rename .env.example to .env
Generate your laravel key : php artisan key:generate
Run php artisan migrate
php artisan vendor:publish --tag payment-router
```

### Testing

```bash
php artisan test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email kingsley.udenewu@hotmail.com instead of using the issue tracker.

## Credits

-   [KINGSLEY UDENEWU](https://github.com/kingsleyudenewu)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
