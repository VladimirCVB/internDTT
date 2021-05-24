CREATE TABLE `houses_filter` (
    `id`    int(10)     unsigned NOT NULL AUTO_INCREMENT,
    `house_id`  int(10)          NOT NULL,
    `livings_count` int(100)          NOT NULL,
    `bedr_count` int(100)           NOT NULL,
    `toilets_count` int(100)           NOT NULL,
    `storages_count` int(100)           NOT NULL,
    `barths_count` int(100)           NOT NULL,
    `total_count` int(100)           NOT NULL,

    PRIMARY KEY (`id`)
);