CREATE TABLE wcf1_guthaben_coupon
(
	couponID int(10) unsigned NOT NULL auto_increment,
	couponcode varchar(50) NOT NULL,
	guthaben int(11) NOT NULL DEFAULT 0,
	promotion tinyint(1) unsigned NOT NULL DEFAULT 0,
	lastCashTime int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (couponID),
	UNIQUE KEY couponcode (couponcode)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE wcf1_guthaben_coupon_to_user
(
	couponID int(10) unsigned NOT NULL,
	userID int(10) unsigned NULL,
	cashTime int(10) unsigned NOT NULL,
	PRIMARY KEY (couponID, userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;