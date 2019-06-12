<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;


class CreateTablesShell extends Shell
{
    /**
     * @param string $appConfig Configuration used to go
     */
    public function main($appConfig = null)
    {

        if (empty($appConfig)) {
            echo "No configuration specified!\n\n";
        } else {
            Configure::load('cabinets/' . $appConfig, 'default', true);
            ConnectionManager::drop('default');
            ConnectionManager::drop('test');
            ConnectionManager::config(Configure::consume('Datasources'));
        }

        /**
         * @var Connection $conn
         */
        $conn = ConnectionManager::get('default');
        $conn->begin();
        $conn->query('CREATE TABLE `transactions` (
                                                          `id` INT(11) NOT NULL AUTO_INCREMENT,
                                                          `amount` DECIMAL(20,10) NOT NULL,
                                                          `currency` VARCHAR(45) NOT NULL,
                                                          `user_id` INT(11) NOT NULL,
                                                          `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                          `usd` DECIMAL(20,10) NOT NULL,
                                                          `rawdata` LONGTEXT,
                                                          PRIMARY KEY (`id`)
                                                        ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;');

        $conn->query('     ALTER TABLE `transactions` 
ADD COLUMN `type` VARCHAR(45) NOT NULL DEFAULT "NA" AFTER `rawdata`,
ADD COLUMN `entity_id` INT NULL AFTER `type`;');


        $conn->query("CREATE TABLE `users` (
                                                  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                  `email` CHAR(45) NOT NULL,
                                                  `phone` VARCHAR(45) DEFAULT NULL,
                                                  `password` VARCHAR(45) NOT NULL,
                                                  `status` INT(11) NOT NULL DEFAULT '0',
                                                  `balance` DECIMAL(20,10) DEFAULT '0.0000000000',
                                                  `wallet` VARCHAR(255) DEFAULT NULL,
                                                  `is_admin` INT(1) NOT NULL DEFAULT '0',
                                                  `kyc_reached` INT(1) NOT NULL DEFAULT '0',
                                                  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                  `tokens` DECIMAL(20,10) DEFAULT '0.0000000000',
                                                  `name` VARCHAR(255) DEFAULT NULL,
                                                  `age` INT(3) DEFAULT NULL,
                                                  `country` VARCHAR(45) DEFAULT NULL,
                                                  `ref_user` INT(10) DEFAULT NULL,
                                                  `personal_referal_bonus` INT(10) DEFAULT '0',
                                                  `personal_bonus` INT(10) DEFAULT '0',
                                                  `in_chain` DECIMAL(20,10) DEFAULT '0.0000000000',
                                                  `clickid` VARCHAR(255) DEFAULT NULL,
                                                  `registration_data` JSON DEFAULT NULL,
                                                  PRIMARY KEY (`id`),
                                                  UNIQUE KEY `email_UNIQUE` (`email`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;");


        $conn->query("INSERT INTO `users` VALUES (1,
                                                        'admin@twister-vl.ru',
                                                        '9998442010',
                                                        '1391e76498cbc2480dcd496ee2bb339e',
                                                        1,
                                                        0,
                                                        '123123',
                                                        1,
                                                        1,
                                                        '2017-11-04 01:09:37',
                                                        0,
                                                        'Andrey Nedobylskiy',
                                                        NULL,
                                                        '',
                                                        NULL,
                                                        0,
                                                        0,
                                                        0,
                                                        '',
                                                        NULL);");
        $conn->query("INSERT INTO `users` VALUES (2,
                                                        'a.sheshunova@gmail.com',
                                                        '',
                                                        '496dcebcdf23e64eab9e7f653765292a',
                                                        1,
                                                        0,
                                                        '',
                                                        1,
                                                        1,
                                                        '2017-11-04 01:09:37',
                                                        0,
                                                        'Angelika Sheshunova',
                                                        NULL,
                                                        '',
                                                        NULL,
                                                        0,
                                                        0,
                                                        0,
                                                        '', 
                                                        NULL);");

        $conn->query('           ALTER TABLE `users` 
ADD COLUMN `bonus_for_referals` INT(11) NULL DEFAULT 0 AFTER `personal_referal_bonus`;');


        $conn->query("CREATE TABLE `keyvalue` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `key` CHAR(250) DEFAULT NULL,
  `value` LONGTEXT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_UNIQUE` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
");

        $conn->query("CREATE TABLE `faq` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `q` LONGTEXT NULL,
  `a` LONGTEXT NULL,
  PRIMARY KEY (`id`));

");


        $conn->query("CREATE TABLE `logs` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `data` LONGTEXT,
  `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `type` VARCHAR(45) DEFAULT 'None',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

");

        $conn->query("CREATE TABLE `social_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `profile_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `birth_day` varchar(255) DEFAULT NULL,
  `birth_month` varchar(255) DEFAULT NULL,
  `birth_year` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
        $conn->query("ALTER TABLE `social_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);");
        $conn->query("ALTER TABLE `social_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");


        $conn->query("CREATE TABLE `kyc_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `kyc_user_id` varchar(50) DEFAULT NULL,
  `applicant_id` varchar(100) DEFAULT NULL,
  `result` text,
  `comment` varchar(255) DEFAULT NULL,
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finish` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
");
        $conn->query("ALTER TABLE `kyc_attempts`
  ADD PRIMARY KEY (`id`);");
        $conn->query("ALTER TABLE `kyc_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;");

        $conn->query("
DROP TABLE IF EXISTS `users_settings`;
CREATE TABLE `users_settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `block` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $conn->query("
ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`id`);");
        $conn->query("
ALTER TABLE `users_settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
        ");

        $conn->query("
ALTER TABLE `users` ADD `otp_hash` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL AFTER `clickid`;
        ");


        $conn->query("
                        CREATE TABLE `tasks` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `type` varchar(45) NOT NULL,
                          `flag` enum('new','pending','finished') NOT NULL DEFAULT 'new',
                          `params` json DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          KEY `id` (`id`),
                          KEY `standart` (`id`,`type`,`flag`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                         ");

        $conn->query("ALTER TABLE `users`
ADD `tokens_bonus` DECIMAL(20,10) NULL DEFAULT '0.0000000000' AFTER `tokens`");

        $conn->query("
ALTER TABLE `users` ADD `roles` ENUM('ADMIN','ANALYST','MODERATOR','SYSTEM','USER') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USER' AFTER `personal_referal_bonus`");

        $conn->query("
                        CREATE TABLE `api_tokens` (
                          `token` varchar(255) NOT NULL,
                          `user_id` int(11) UNSIGNED DEFAULT NULL,
                          `expiration` datetime DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                         ");
        $conn->query("ALTER TABLE `transactions`
ADD `currencys_rate` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL AFTER `rawdata`");


        $conn->commit();
    }
}