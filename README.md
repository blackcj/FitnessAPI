# FITNESS API

PHP API used to store health and fitness data. This example code base is currently only set up to handle a single user. A users table with unique API keys will be added in the future.

This API will be used to store fitness data collected from a native Android app. Data will be displayed to the user on the web and within the mobile app.

**Technologies Used**

PHP, MySQL, [Slim Framework](http://docs.slimframework.com/start/get-started/), API DOC

## SETUP

### MySQL Database

Create a database named `fitness`. Add the following table:

```SQL
CREATE TABLE `heartrate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `heartrate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

### PHP Server

Install composer to project (similar to `npm` but on a per project basis)

```
curl -s https://getcomposer.org/installer | php
```

Get dependencies (similar to `npm install`)

```
php composer.phar install
```

Start local server (similar to `npm start`)

```
php -S localhost:8000
```

Create a `config.php` file using the `config-sample.php` as a template. Pass the `X-API-KEY` header you set in the `config.php` file with all requests.

## API Documentation

Documentation can be found in the `apidoc` folder. Run the following to re-generate API documentation:

```
apidoc -i ./ -e apidoc/ -o apidoc/
```

## RESOURCES

- https://www.shift8web.ca/2015/04/use-php-to-set-up-a-restful-api-with-simple-authentication/
- http://apidocjs.com/#getting-started
- http://docs.slimframework.com/
