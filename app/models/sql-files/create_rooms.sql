CREATE TABLE `rooms` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `house_id`  int(10)          NOT NULL,
    `room_type` enum(100)          NOT NULL,
    `width` int(100)          NOT NULL,
    `length` int(100)          NOT NULL,
    `height` int(100)          NOT NULL,

    PRIMARY KEY (`id`)
);