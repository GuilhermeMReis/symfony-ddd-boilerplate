# Symfony DDD/CQRS boilerplate

A symfony project based on a DDD structure with CQRS (at least the idea was to get something close). 

Synchronous busses: `Command`, `Query` and `Domain event`

Asynchronous bus: `Integration event`. Redis as transport engine


Ps. for Windows users, take a look on the `./Makefile` for the equivalent `make` commands using `docker-compose`.

## Requirements
- Docker

## Running the instances
```shell
make up
```

## Create JWT keys
```shell
docker-compose exec php php bin/console lexik:jwt:generate-keypair
```

## Run fixtures
```shell
make fixtures
```

## Running tests
```shell
make test
```

## Hello world
```shell
http://localhost:8282/hello
```

## Context example: `src/Company`
A real basic explanation of how you can use this boilerplate in your projects would be to fully understand DDD rules and
how the relationship between Entities and AggregateRoots should be. We've tried to create a simple to understand mock
concept as would describe the basic functionalities of our main infrastructures utilities.

### Infrastructure utilities:
- `Command:` Use this interface in order to fire off commands. Your commands should have everything that they need in order
to execute that action. We use public attributes as our contract to execute that command.
- `CommandHandler:` Use this interface to target the handler class of your commands. Commands handlers by their nature are
fire and forget, they don't return any value, they can throw exceptions though.
- `Query:` Use this interface in order to fire off query. Your query has a contract of the attributes that the queryHandler
will need in order to execute that query.
- `QueryHandler:` Use this interface to target the handler class of your query. Queries should return a `QueryResult` class
which has no interface, the attributes should be public for the json converter to pick them up and translate as a json return
  in an API context.
- `AggregateRoot:` Use this class as your base class of your aggregateRoots. It will provide access to `write` and `publish`
methods for you to be able to fire `DomainEvents` and `IntegrationEvents`. AggregateRoot has a direct binding to BaseDoctrineRepository
  class, so all AggregateRoot classes should have a repository.
- `DomainEvent:` Use this class as your base class of your domain events. From your `AggregateRoot` class, you will have access
to `write(new DomainEvent())`, which it will be fired off when persisting the Aggregate and handling synchronously by its handler.
- `IntegrationEvent:` Use this class as your base class of your integration events. From your `AggregateRoot` class, you will
have access to `publish(new IntegrationEvent())`, which it will be fired off when persisting the Aggregate and handling
asynchronously by its handler.
  

This project is not recommended being used in a production environment (yet).

PR's are welcomed. Please feel free to open issues or `[FEATURE-REQUEST]`.
