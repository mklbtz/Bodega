# Bodega - A Simple Storefront

## About

This was an endeavor to create a storefront akin to Amazon or Etsy, including a sorting of store items by category. Features Google-style search, an entire shopping cart workflow with account logins, and a backend for managers to see sales statistics and ship orders. Written in PHP; requires a MySQL database.

## Database

This project requires a MySQL database to run properly. Below is the create syntax for each of the tables.


    CREATE TABLE `bodega_cart` (
        `upc` int(12) unsigned NOT NULL AUTO_INCREMENT,
        `email` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
        `quantity` int(11) unsigned NOT NULL DEFAULT '1',
        PRIMARY KEY (`upc`,`email`),
        CONSTRAINT `bodega_cart_ibfk_1` FOREIGN KEY (`upc`) REFERENCES `bodega_items` (`UPC`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

    CREATE TABLE `bodega_contains` (
      `oid` int(12) unsigned NOT NULL,
      `upc` int(12) unsigned NOT NULL,
      `quantity` int(11) NOT NULL,
      `purchase_price` float NOT NULL,
      PRIMARY KEY (`oid`,`upc`),
      KEY `upc` (`upc`),
      CONSTRAINT `bodega_contains_ibfk_2` FOREIGN KEY (`upc`) REFERENCES `bodega_items` (`upc`),
      CONSTRAINT `bodega_contains_ibfk_3` FOREIGN KEY (`oid`) REFERENCES `bodega_orders` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE `bodega_customers` (
      `email` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `first_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `last_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `street` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `city` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `state` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `password` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `staff` tinyint(1) NOT NULL DEFAULT '0',
      `manager` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE `bodega_items` (
      `upc` int(12) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `description` mediumtext CHARACTER SET utf8,
      `category` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `base_price` float NOT NULL,
      `quantity` int(11) unsigned NOT NULL,
      `img_url` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
      `promo_price` float DEFAULT NULL,
      PRIMARY KEY (`upc`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1101 DEFAULT CHARSET=latin1;

    CREATE TABLE `bodega_orders` (
      `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
      `email` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
      `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `is_shipped` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      KEY `email` (`email`),
      CONSTRAINT `bodega_orders_ibfk_1` FOREIGN KEY (`email`) REFERENCES `bodega_customers` (`email`)
    ) ENGINE=InnoDB AUTO_INCREMENT=6122 DEFAULT CHARSET=latin1;

    CREATE TABLE `bodega_sessions` (
      `session_id` varchar(40) NOT NULL DEFAULT '0',
      `ip_address` varchar(45) NOT NULL DEFAULT '0',
      `user_agent` varchar(120) NOT NULL,
      `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
      `user_data` text NOT NULL,
      PRIMARY KEY (`session_id`),
      KEY `last_activity_idx` (`last_activity`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

