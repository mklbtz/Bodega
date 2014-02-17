# Bodega - A Simple Storefront

## About

This was an endeavor to create a storefront akin to Amazon or Etsy, including a sorting of store items by category. Features Google-style search, an entire shopping cart workflow, and a backend for managers to see sales statistics and ship orders. Written in PHP; requires a MySQL database.

## Database

This project requires a MySQL database to run properly. Below is the create syntax for each of the tables.


    CREATE TABLE `bodega_cart` (
        `upc` int(12) unsigned NOT NULL AUTO_INCREMENT,
        `email` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
        `quantity` int(11) unsigned NOT NULL DEFAULT '1',
        PRIMARY KEY (`upc`,`email`),
        CONSTRAINT `bodega_cart_ibfk_1` FOREIGN KEY (`upc`) REFERENCES `bodega_items` (`UPC`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

