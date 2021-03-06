# ๐ Api for learn DDD

# ๐ Set Up
- [Install Docker](https://docs.docker.com/engine/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

## ๐ณ Create and execute docker containers
- Create the docker containers `make build`
- Start the docker containers `make run`

## โ๐ผ Populate the database
- Run the `make migrate`

## ๐ฅ Application execution
1. Install all the dependencies and bring up the project with Docker executing: `make build`
2. To Access the api use the next url `http://localhost/api/v1/health-check`

## ๐งช Testing
- To run all the tests you will have to execute the `make test` command,
  this command also populates the database.
  
## ๐ Documentation
- Access to api documentation `http://localhost:8082/`
