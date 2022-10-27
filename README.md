#  JakMall Test Review Application

###  Installation

1. Install project

```bash

$ git clone https://github.com/aannn123/JakMall.git

```
2. Composer install

```bash

$ cd your_name_directory
$ composer install

```

3. Generate Key

```bash

$ php artisan key:generate

```

4. Setting Redis
Go to .env and add this

```bash
REDIS_CLIENT=predis
```

5. Run application

```bash

$ php artisan serve

```

###  Testing Application

1. Get data review summary
```bash

http://127.0.0.1:8000/api/review/summary

```

2. Get data review by product id


```bash

http://127.0.0.1:8000/api/review/product/{product_id}

```

###  Testing PHPUnit

You can run your PHPUnit tests by running the phpunit command:

```bash

$ ./vendor/bin/phpunit

```



Or run the following command:

```bash

$ php artisan test

```