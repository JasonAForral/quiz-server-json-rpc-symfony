FROM ubuntu:16.04

RUN mkdir /code
WORKDIR /code

RUN apt-get update && apt-get install --yes curl git \
  php7.0 php7.0-xml php7.0-zip wget

ADD get-composer.sh /code/
RUN sh get-composer.sh

ADD get-symfony.sh /code/
RUN sh get-symfony.sh