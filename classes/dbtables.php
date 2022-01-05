<?php
#
# database tables
#
namespace VERHUISKALENDER;

class Dbtables
{
	const verhuiskalender = ["name"=>"verhuiskalender", "columns"=>"
		`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `created` datetime NOT NULL,
        `modified` datetime NOT NULL,
        `relationID` int NOT NULL,
        `code` varchar(30) NOT NULL,
        `description` varchar(255) NOT NULL,
        `date` date NOT NULL,
        `fromtime` varchar(5) NOT NULL,
        `tilltime` varchar(5) NOT NULL,
		PRIMARY KEY (`id`)"];
    // tabel van appartementen
    const appartementen = ["name"=>"hellas_appartments", "columns"=>"
		`bouwnummer` varchar(4) NOT NULL,
        `huisnummer` int(11) NOT NULL,
        `gebouw` varchar(1) NOT NULL,
        `verdieping` int(11) NOT NULL,
        `splitsing` int(11) NOT NULL"];
    // relaties
    const relaties =  ["name"=>"hellas_relations", "columns"=>"
        `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		`modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		`status` varchar(255) NOT NULL,
		`relationtype` varchar(255) NOT NULL,
		`photo` varchar(255) NOT NULL,
		`gender` varchar(255) NOT NULL,
		`firstname` varchar(255) NOT NULL,
		`middlename` varchar(255) NOT NULL,
		`lastname` varchar(255) NOT NULL,
		`street` varchar(255) NOT NULL,
		`house` varchar(255) NOT NULL,
		`zipcode` varchar(255) NOT NULL,
		`place` varchar(255) NOT NULL,
		`email` varchar(255) NOT NULL,
		`phone` varchar(255) NOT NULL,
		`mobile` varchar(255) NOT NULL,
		`oldappartment` varchar(255) NOT NULL,
		`appartment` varchar(255) NOT NULL,
		PRIMARY KEY (`id`)"];
     // joined table verhuiskalender, relaties, 
    const aktiviteiten = ["name"=>"aktiviteiten", "columns"=>"
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` varchar(30) NOT NULL,
    `description` varchar(255) NOT NULL,
    `date` date NOT NULL,
    `fromtime` varchar(5) NOT NULL,
    `tilltime` varchar(5) NOT NULL,
    `gebouw` varchar(1) NOT NULL,
    `verdieping` varchar int(11) NOT NULL,
    `firstname` varchar(255) NOT NULL,
    `middlename` varchar(255) NOT NULL,
    `lastname` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(255) NOT NULL,
    `mobile` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)"];
}
?>