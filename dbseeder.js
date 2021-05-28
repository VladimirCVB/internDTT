// dbseeder.js
const faker = require("faker");
const Seeder = require("mysql-db-seed").Seeder;
// ES6 use `import {Seeder} from "mysql-db-seed";`

// Generate a new Seeder instance
const seed = new Seeder(
  10, 
  "db_host",
  "db_username",
  "db_password",
  "database"
);

(async () => {
  await seed.seed(
    30,
    "users", 
    {
      email: faker.internet.email,
      profile_picture: faker.image.people,
      first_name: faker.name.firstName,
      last_name: faker.name.lastName,
      uuid: faker.random.uuid,
      created_at: seed.nativeTimestamp(),
      updated_at: seed.nativeTimestamp()
    }
  )
  seed.exit();
  process.exit();
})();

//Run command to seed database
//node dbseeder.js