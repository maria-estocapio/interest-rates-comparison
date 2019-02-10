# Interest Rate Comparison Installer


## Technology Used
* PHP as backend programming language
* CodeIgniter framework
* Composer as the dependency management tool
* PHPUnit 5.7

## Requirements
* Apache 2.4.x 
* PHP 5.4 or later
* Composer 1.8.3
* Git

## How to Build the Project

### Install CodeIgniter

```
$ composer create-project kenjis/codeigniter-composer-installer mom-homework-ci
```

[Install CodeIgniter Rest Server](https://github.com/chriskacerguis/codeigniter-restserver):
```
$ cd mom-homework-ci
$ php bin/install.php restserver 2.7.2
```
[Install Request Library](https://requests.ryanmccue.info/):
```
$ composer require rmccue/requests
```

### Install PHPUnit Test

```
$ composer require phpunit/phpunit ^5.7
$ composer require kenjis/ci-phpunit-test
$ php vendor/kenjis/ci-phpunit-test/install.php
```

### Download the project files
```
$ cd mom-homework-ci
$ git init
$ git remote add origin https://github.com/maria-estocapio/interest-rates-comparison
$ git fetch
$ git checkout origin/master -ft
```

## How to Run the Project

### Run PHP built-in server (PHP 5.4 or later)

```
$ cd mom-homework-ci
$ bin/server.sh
```
## How to Run the PHPUnit Test
```
$ cd mom-homework-ci/application/test
$ ..\..\vendor\bin\phpunit  (windows)
$../../vendor/bin/phpunit  (Unix/Mac)
```

## API Document
#### URL

**For Trend:**
http://127.0.0.1:8000/api/financial

**For Average:**
http://127.0.0.1:8000/api/financial/average

**Request Parameter**

| Parameter Name |   Description|
| ------------ | ------------ |
|  start_date |  this is the start month  Format: YYYY-MM  ex. *start_date = 2018-01* |
| end_date  |  this is the end month Format: YYYY-MM ex. *end_date = 2018-12* |
|  period | this is the period ex. 3 for 3month , 6 for 6-month or 12 for 12-month period  |
|  rate_type |  this is the type of rate ex. *fixed or savings* |

Response (JSON)

| Response Field  |  Description |
| ------------ | ------------ |
|  msg| Success or Error Occured message response  |
|  status |Success or Failed response  |
|  status_code | this is the HTTP response standard  status code  |
| result  |  list of matching results |


## UI

I have provided simple UI to show the Trend and Average chart.  
The UI is included in the same package. 

**For Trend**:
http://127.0.0.1:8000/ui/charts

**For Average**:
http://127.0.0.1:8000/ui/charts/average















