CREATE TABLE `houses` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `street`  varchar(255)          NOT NULL,
    `number` int(100)          NOT NULL,
    `addition` varchar(255)          NOT NULL,
    `zipcode` varchar(255)          NOT NULL,
    `city` varchar(255)          NOT NULL,

    PRIMARY KEY (`id`)
);