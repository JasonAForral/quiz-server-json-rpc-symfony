# quiz-server-json-rpc-symfony

[![Build Status](https://travis-ci.org/JasonAForral/quiz-server-json-rpc-symfony.svg?branch=master)](https://travis-ci.org/JasonAForral/quiz-server-json-rpc-symfony)

Unit Testing:

```bash
docker-compose run web bin/phpunit --configuration app
```

Build:

```bash
docker-compose build
docker-compose run web composer install
```

#### Objective:

- [ ] Create quiz server that pulls questions and answers from database
- [ ] Stores user records

#### Steps Taken:

- [x] Set up Symfony framework
- [x] Set up unit tests
- [x] Write classes for Questions, Answers, Quizes
- [x] Set up database
- [x] Write classes for Repositories
- [x] Write class for JSON-RPC linting