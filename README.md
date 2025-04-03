- [![Starts](https://img.shields.io/github/stars/laravelir/ticketable?style=flat&logo=github)](https://github.com/laravelir/ticketable/forks)
- [![Forks](https://img.shields.io/github/forks/laravelir/ticketable?style=flat&logo=github)](https://github.com/laravelir/ticketable/stargazers)
  [![Total Downloads](https://img.shields.io/packagist/dt/laravelir/ticketable.svg?style=flat-square)](https://packagist.org/packages/laravelir/ticketable)


# laravelir/ticketable

A ticketable for laravel

### Installation

1. Run the command below to add this package:

```
composer require laravelir/ticketable
```

2. Open your config/app.php and add the following to the providers array:

```php
Laravelir\Ticketable\Providers\TicketableServiceProvider::class,
```

1. Run the command below to install the package:

```
php artisan ticketable:install
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
