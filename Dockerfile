FROM yiisoftware/yii2-php:8.3-apache

# install psql
RUN apt-get update -y && apt install -y postgresql-client
