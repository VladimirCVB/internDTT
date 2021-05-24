CREATE TABLE `listings` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `user_id`  int(10)          NOT NULL,
    `house_id` int(10)          NOT NULL,
    `post_date` date(255)          NOT NULL,
    `active` boolean(1)          NOT NULL,
    `inactive_date` date(255)          NOT NULL,

    PRIMARY KEY (`id`)
);