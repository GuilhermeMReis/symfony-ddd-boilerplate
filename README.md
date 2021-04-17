# symfony-ddd-boilerplate

## Run project
```shell
make up
```
or
```shell
docker-compose up -d
```

## Hello world
```
http://localhost:8282/hello
```

## Run functional tests
```shell
make functional-test
```
or
```shell
docker-compose exec php symfony composer test:functional
```