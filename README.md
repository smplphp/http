<img src="smpl-logo.png" alt="SMPL" align="left">

# HTTP

A simple, modern PHP 8 library for representing HTTP requests and responses.

![Packagist Version](https://img.shields.io/packagist/v/smplphp/http)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/smplphp/http)
![GitHub](https://img.shields.io/github/license/smplphp/http)
![Psalm Level](https://shepherd.dev/github/smplphp/http/level.svg)

Main:

[![codecov](https://codecov.io/gh/smplphp/http/branch/main/graph/badge.svg?token=FHJ41NQMTA)](https://codecov.io/gh/smplphp/http)
[![CircleCI](https://circleci.com/gh/smplphp/http/tree/main.svg?style=shield)](https://circleci.com/gh/smplphp/http/tree/main)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fsmplphp%2Fhttp%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/smplphp/http/main)

Develop:

[![codecov](https://codecov.io/gh/smplphp/http/branch/develop/graph/badge.svg?token=FHJ41NQMTA)](https://codecov.io/gh/smplphp/http)
[![CircleCI](https://circleci.com/gh/smplphp/http/tree/develop.svg?style=shield)](https://circleci.com/gh/smplphp/http/tree/develop)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fsmplphp%2Fhttp%2Fdevelop)](https://dashboard.stryker-mutator.io/reports/github.com/smplphp/http/develop)

## Install

Install via composer.

```bash
composer require smplphp/http
```

## Usage

TBW

## Testing

The full test suite of PHPUnit, Infection, PHPStan and Psalm can be run using the following command.

```bash
make test
```

### PHPUnit

To run PHPUnit alone, you can run the following.

```bash
make phpunit
```

Or if you want code-coverage

```bash
make phpunit-coverage
```

### Infection

To run Infection alone, you can run the following.

```bash
make infection
```

Or if you want a report

```bash
make infection-report
```

### PHPStan

To run PHPStan alone, you can run the following.

```bash
make phpstan
```

### Psalm

To run Psalm alone, you can run the following.

```bash
make psalm
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/smplphp/http/blob/master/LICENSE.md) for more information.
