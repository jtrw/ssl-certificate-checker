# Ssl Certificate Checker


Util for check ssl and get info about site 

## Install

Via Composer

``` bash
$ composer require jtrw/ssl-certificate-checker
```

## Usage SslCertificateChecker

```php
include_once __DIR__."/../vendor/autoload.php";


$sslCheck = new \Jtrw\SslCertificate\SslCertificateInfo();

$infoObject = $sslCheck->getInfo("http://expired-ecc-dv.ssl.com");

```

`$infoObject` has instance of `CertInfoInterface` and has newxt methods:
```php
    public function getUrl(): string;
    
    public function getSerialNumber(): string;
    
    public function getSslVerifyResult(): int;
    
    public function isSslVerified(): bool;
    
    public function getSubject(): array;
    
    public function getIssuer(): array;
    
    public function getVersion(): string;
    
    public function getStartDate(): DateTime;
    
    public function getExpireDate(): DateTime;
    
    public function getAllCerts(): array;
}
```

Next case get shotr info about sites

```php
$sslCheck = new \Jtrw\SslCertificate\SslCertificateInfo();
$info = $sslCheck->check([
    "http://expired-ecc-dv.ssl.com" => ['expire_date' => '18.08.2019'],
    "http://google.com",
    "fb.com"
]);
var_dump($info);
```
Output:
```
array(3) {
  [0]=>
  array(3) {
    ["host"]=>
    string(31) "https://expired-ecc-dv.ssl.com/"
    ["is_verified"]=>
    bool(false)
    ["expire_date"]=>
    string(19) "2019-08-16 15:20:44"
  }
  [1]=>
  array(3) {
    ["host"]=>
    string(19) "https://google.com/"
    ["is_verified"]=>
    bool(true)
    ["expire_date"]=>
    string(19) "2021-09-20 01:38:44"
  }
  [2]=>
  array(3) {
    ["host"]=>
    string(17) "https://fb.com/"
    ["is_verified"]=>
    bool(true)
    ["expire_date"]=>
    string(19) "2021-12-02 23:59:59"
  }
}
```

## Testing

``` bash
$ composer test
```

