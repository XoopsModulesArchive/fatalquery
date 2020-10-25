#
# Table structure for table `fatalquery_maps`
#

CREATE TABLE `fatalquery_maps` (
    `map_id`       INT(3)      NOT NULL AUTO_INCREMENT,
    `map_name`     VARCHAR(30) NOT NULL DEFAULT '',
    `in_rotation`  TINYINT(1)  NOT NULL DEFAULT '0',
    `map_dl_count` INT(11)     NOT NULL DEFAULT '0',
    `date_added`   VARCHAR(11) NOT NULL DEFAULT '00-00-0000',
    PRIMARY KEY (`map_id`)
)
    ENGINE = ISAM;

#
# Dumping data for table `fatalquery_maps`
#

# --------------------------------------------------------

#
# Table structure for table `fatalquery_svrs`
#

CREATE TABLE `fatalquery_svrs` (
    `svr_id`           INT(2)      NOT NULL AUTO_INCREMENT,
    `svr_uname`        VARCHAR(50)          DEFAULT NULL,
    `svr_address`      VARCHAR(50) NOT NULL DEFAULT '127.0.0.1',
    `svr_port`         INT(10)     NOT NULL DEFAULT '27015',
    `svr_status`       TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_name`         TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_address_on`   TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_mod_desc`     TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_mod_version`  TINYINT(1)  NOT NULL DEFAULT '1',
    `players_online`   TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_type`         TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_os`           TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_password`     TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_security`     TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_ping`         TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_player_info`  TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_rules`        TINYINT(1)  NOT NULL DEFAULT '0',
    `svr_curr_mapname` TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_curr_mappic`  TINYINT(1)  NOT NULL DEFAULT '1',
    `svr_join`         TINYINT(1)  NOT NULL DEFAULT '1',
    `block_status`     TINYINT(1)  NOT NULL DEFAULT '1',
    PRIMARY KEY (`svr_id`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;

#
# Dumping data for table `fatalquery_svrs`
#

INSERT INTO `fatalquery_svrs`
VALUES (1, 'User Query', 'user_query', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0);
