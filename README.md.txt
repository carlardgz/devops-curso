docker run -d --name db -v C:\Users\Usuario\Desktop\Python\Curso\Mysql\data:/var/lib/mysql/ -p 3306:3006 mysql:v1 
docker run -d --name admin -v C:\Users\Usuario\Desktop\Python\Curso\Phpmyadmin\config.user.inc.php:/etc/phpmyadmin/config.user.inc.php-p 8081:80 --link db admin:v1
docker run -d --name app -v C:\Users\Usuario\Desktop\Python\Curso\aplicacion:/var/www/html/ -p 8082:80 --link db app:v1