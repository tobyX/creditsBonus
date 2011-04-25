CREATE TABLE wcf1_guthaben_coupon
(
	couponID int(10) unsigned NOT NULL auto_increment,
	couponcode varchar(50) NOT NULL,
	userID int(10) unsigned NULL,
	guthaben int(11) NOT NULL DEFAULT 0,
	chashTime int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (couponID),
	KEY userID (userID),
	UNIQUE KEY couponcode (couponcode)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;