## Blog

### Description

Code of 'Master Laravel PHP for Beginners and Intermediate' Udemy course created by Piotr Jura

### Installation and startup:

- Install XAMPP 7.3.5 or later
- Install Composer 1.8.5 or later
- Clone or copy the project to the default Apache root directory (/xampp/htdocs)
- Run 'composer install' command
- Create a .env file from the .env.example file 
- Run 'php artisan key:generate' command
- Configure an Apache virtual host in \xampp\apache\conf\extra\httpd-vhosts.conf file by adding lines:
``` 
    <VirtualHost blog.test:80>
        DocumentRoot "C:/xampp/htdocs/blog-laravel-course/public"
        <Directory "C:/xampp/htdocs/blog-laravel-course/public">
            Options Indexes FollowSymLinks
                    AllowOverride All
                    Require all granted
         </Directory>
    </VirtualHost>
``` 
- Open a text editor as administrator and add url you want to use to \drivers\etc\hosts file (e.g 127.0.0.1 blog.test)
- In the .env file change the database name: DB_DATABASE=blog 
- Create database named 'blog'
- Run 'php artisan migrate'
- Register to redislabs.com
- Add to the .env file: 
``` 
    REDIS_HOST=endpoint provided on the redislabs page      		
    REDIS_PASSWORD=password provided on the redislabs page  				
    REDIS_CACHE_DB=cache    
    REDIS_CACHE_DB=0   
    CACHE_DRIVER=redis 
```
- Register to mailtrap at https://mailtrap.io
- Add to the .env file:  
```
    MAIL_USERNAME=username provided by mailtrap   
    MAIL_PASSWORD=password provided by mailtrap   
    MAIL_FROM_ADDRESS=any random email address  
```

### Notes: 

To load random generated data into the application database run 'php artisan db:seed'

