// dbseeder.js
const faker = require("faker");
const Seeder = require("mysql-db-seed").Seeder;
// ES6 use `import {Seeder} from "mysql-db-seed";`
const roomTypes = ['living', 'bedroom', 'toilet', 'storage', 'bathroom'];
var item = roomTypes[Math.floor(Math.random() * roomTypes.length)];

// Generate a new Seeder instance
const seed = new Seeder(
  10, 
  "localhost",
  "root",
  "",
  "dtt_test"
);

(async () => {
  //Because the randomizer from faker does not really work (meaning that it only generates 1 random value per call, I will have to use a 'for' loop to generate more randomness in the database)
  for (var i = 0; i < 50; i++){
    await seed.seed(
      1,
      "users", 
      {
        email: faker.internet.email,
        user_type: 'user',
        name: faker.name.findName,
        password: faker.internet.password,
        created_at: seed.nativeTimestamp(),
      }
    ),
    await seed.seed(
      6,
      "rooms", 
      {
        house_id: faker.datatype.number(150),
        room_type: faker.random.objectElement(['living', 'bedroom', 'toilet', 'storage', 'bathroom']),
        width: faker.datatype.number(2000),
        length: faker.datatype.number(5000),
        height: faker.datatype.number(2500),
      }
    ),
    await seed.seed(
      3,
      "listings", 
      {
        user_id: faker.datatype.number(50),
        house_id: faker.datatype.number(150),
        post_date: seed.nativeTimestamp(),
        active: faker.datatype.number(0, 1),
        inactive_date: null,
      }
    ),
    await seed.seed(
      3,
      "houses_filter", 
      {
        house_id: faker.datatype.number(150),
        livings_count: 1,
        bedr_count: 2,
        toilets_count: 3,
        storages_count: 1,
        barths_count: 2,
        total_count: 9,
      }
    ),
    await seed.seed(
      3,
      "houses", 
      {
        street: faker.address.streetName,
        number: faker.datatype.number(50),
        addition: null,
        zipcode: faker.address.zipCode,
        city: faker.address.city,
      }
    )
  }
  seed.exit();
  process.exit();
})();

//Run command to seed database
//node dbseeder.js