# Lumen-Doctrine-DDD-Example
Domain Driven Design Application Example, built with Lumen 5.3 and Doctrine.

# Introduction:
There are some DDD concepts, that application does not implement as: ValueObject, multiple Entites.
The main purpose is to give you a start point in terms of architecture.

#Assumptions:
The Application Services are understood as Entrypoint for Domain.
There is one Controller, Service Application and Service Provider by Domain.
Providers map Contracts and Implementations.

#Usage
composer install <br/>

To set the cache to database:
```sql
    
    CREATE TABLE `cache` (
      `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `value` text COLLATE utf8_unicode_ci NOT NULL,
      `expiration` int(11) NOT NULL,
      UNIQUE KEY `cache_key_unique` (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```
To generate the schema<br/>
<b>php artisan  doctrine:schema:create</b><br>

or create the table
```sql
CREATE TABLE `manager` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `company_id` int(11) NOT NULL,
      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 ```

#Requirements
"php": ">=5.6.4", <br />
"laravel/lumen-framework": "5.3.*", <br />
"laravel-doctrine/orm": "1.2.*",

#Credits
https://github.com/GrahamCampbell/Laravel-Throttle <br/>
https://github.com/tecnom1k3/sp-simple-jwt <br/>
https://github.com/krisanalfa/lumen-jwt/blob/develop/app/Http/Middleware/CORSMiddleware.php <br/>

#References:
DDD <br/>
https://github.com/dddinphp <br/>
http://www.zankavtaskin.com/2013/09/applied-domain-driven-design-ddd-part-1.html <br/>
https://www.youtube.com/watch?v=pL9XeNjy_z4&list=PLx4mLirQvMeV0uNpo1UaculL-djjI8eTz <br/>
https://www.youtube.com/watch?v=yPvef9R3k-M <br/>
https://www.youtube.com/watch?v=dnUFEg68ESM <br/>

Hexagonal Architecture <br/>
http://fideloper.com/hexagonal-architecture <br/>
http://alistair.cockburn.us/Hexagonal+architecture <br/>
https://www.yordipauptit.com/hexagonal-architecture-in-php/ <br/>

Laravel Doctrine <br/>
http://www.laraveldoctrine.org/

XML Doctrine Mapping <br/>
http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/xml-mapping.html

Criteria Array to Doctrine Criteria <br/>
https://gist.github.com/jgornick/8671644

Foreign Key <br/>
https://maltronblog.wordpress.com/2015/02/15/fkrelation/
https://engineering.thetrainline.com/2015/07/23/foreign-keys-dont-go-there/
http://microservices.io/patterns/data/database-per-service.html

Generators <br/>
https://github.com/InfyOmLabs/laravel-generator
https://github.com/motamonteiro/gerador

#Author
Davi dos Santos - davi646@gmail.com