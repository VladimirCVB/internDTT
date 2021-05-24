CREATE TABLE `users` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `user_type`  enum(70)          NOT NULL,
    `name` varchar(255)          NOT NULL,
    `email` varchar(255)          NOT NULL,
    `password` varchar(255)          NOT NULL,

    PRIMARY KEY (`id`)
);