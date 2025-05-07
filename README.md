## About this project
This is a simple CRUD php api for a fictional shop for me to train my dev skills.

## How to run
```
# Create the containers (php/apache2 and mysql)
docker-compose up -d

# Create the database
docker exec -it my-market-mysql bash -c "mysql -u defined_user -pdefined_password < database/my-market-schema.sql"
```

And you're ready to go!