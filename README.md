# [zuri.net](http://zuri.net) PHP Client

[![Build Status](https://travis-ci.org/gweibel/zurinet-php.png?branch=master)](https://travis-ci.org/gweibel/zurinet-php)

## Usage

```php
$z = new Zurinet();
foreach ($z->getReviews(18300) as $review) {
    printf("%s: %s\n", $review['author'], $review['message']);
}
```

## Installation

```bash
composer require gweibel/zurinet-php
```

## License

MIT
