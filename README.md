# quiz-server-json-rpc-symfony

[![Build Status](https://travis-ci.org/JasonAForral/quiz-server-json-rpc-symfony.svg?branch=master)](https://travis-ci.org/JasonAForral/quiz-server-json-rpc-symfony)

Unit Testing:

```bash
docker-compose run web bin/phpunit --configuration app
```

build:

```bash
docker-compose build
docker-compose run web composer install
```

#### Objective:

[ ] Create quiz server that pulls questions and answers from database
[ ] Stores user records

#### Steps Taken:

[*] Set up Symfony framework
* Set up unit tests
* Wrote classes for Questions, Answers, Quizes
* Set up database
* Wrote classes for Repositories
* Wrote class for JSON-RPC linting