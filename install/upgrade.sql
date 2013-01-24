# OPENCART UPGRADE SCRIPT v1.5.x
# WWW.OPENCART.COM
# Qphoria

# THIS UPGRADE ONLY APPLIES TO PREVIOUS 1.5.x VERSIONS. DO NOT RUN THIS SCRIPT IF UPGRADING FROM v1.4.x 

# DO NOT RUN THIS ENTIRE FILE MANUALLY THROUGH PHPMYADMIN OR OTHER MYSQL DB TOOL
# THIS FILE IS GENERATED FOR USE WITH THE UPGRADE.PHP SCRIPT LOCATED IN THE INSTALL FOLDER
# THE UPGRADE.PHP SCRIPT IS DESIGNED TO VERIFY THE TABLES BEFORE EXECUTING WHICH PREVENTS ERRORS

# IF YOU NEED TO MANUALLY RUN THEN YOU CAN DO IT BY INDIVIDUAL VERSIONS. EACH SECTION IS LABELED.
# BE SURE YOU CHANGE THE PREFIX "oc_" TO YOUR PREFIX OR REMOVE IT IF NOT USING A PREFIX

#### START 1.5.1

ALTER TABLE `oc_affiliate` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0;  
ALTER TABLE `oc_affiliate` ADD `webmoney_wmr` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER payment;
ALTER TABLE `oc_affiliate` ADD `webmoney_wmz` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER webmoney_wmr;
ALTER TABLE `oc_affiliate` ADD `webmoney_wme` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER webmoney_wmz;
ALTER TABLE `oc_affiliate` ADD `webmoney_wmu` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER webmoney_wme;
ALTER TABLE `oc_affiliate` ADD `yandex_money` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER webmoney_wmu;
ALTER TABLE `oc_product_to_category` ADD `main_category` tinyint(1) NOT NULL DEFAULT '0' AFTER category_id;
ALTER TABLE `oc_affiliate` MODIFY `approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_banner` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_category` MODIFY `top` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_category` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_country` MODIFY `postcode_required` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_country` MODIFY `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '';
ALTER TABLE `oc_coupon` MODIFY `logged` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_coupon` MODIFY `shipping` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_coupon` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_currency` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_customer` MODIFY `newsletter` tinyint(1) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `oc_customer`  MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_customer`  MODIFY `approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_information` MODIFY `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '';
ALTER TABLE `oc_language` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_order_history` MODIFY `notify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `oc_product` MODIFY `shipping` tinyint(1) NOT NULL DEFAULT '1' COMMENT '';
ALTER TABLE `oc_product` MODIFY `subtract` tinyint(1) NOT NULL DEFAULT '1' COMMENT '';
ALTER TABLE `oc_product` MODIFY `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `oc_product_option` MODIFY `required` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_product_option_value` MODIFY `subtract` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_return_history` MODIFY `notify` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_return_product` MODIFY `opened` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_review` MODIFY `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '';
ALTER TABLE `oc_user` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_voucher` MODIFY `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '';
ALTER TABLE `oc_zone`  MODIFY `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '';
ALTER TABLE `oc_setting` ADD `serialized` tinyint(1) NOT NULL DEFAULT 0 COMMENT '' AFTER value;

CREATE TABLE IF NOT EXISTS oc_manufacturer_description (
  manufacturer_id INT(11) NOT NULL,
  language_id INT(11) NOT NULL,
  description TEXT NOT NULL COLLATE utf8_general_ci,
  meta_description VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
  meta_keyword VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
  seo_title VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
  seo_h1 VARCHAR(255) NOT NULL COLLATE utf8_general_ci,
  PRIMARY KEY (manufacturer_id, language_id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_ncategory;
CREATE TABLE `oc_ncategory` (
  `ncategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `column` int(3) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ncategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=59 ;

DROP TABLE IF EXISTS oc_ncategory_description;
CREATE TABLE `oc_ncategory_description` (
  `ncategory_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_general_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_general_ci NOT NULL, 
  `seo_h1` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ncategory_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_ncategory_to_layout;
CREATE TABLE `oc_ncategory_to_layout` (
  `ncategory_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`ncategory_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_ncategory_to_store;
CREATE TABLE `oc_ncategory_to_store` (
  `ncategory_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`ncategory_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_ncomments;
CREATE TABLE `oc_ncomments` (
  `ncomment_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `author` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `text` text COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ncomment_id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=37 ;

DROP TABLE IF EXISTS oc_news;
CREATE TABLE `oc_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `acom` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

DROP TABLE IF EXISTS oc_news_description;
CREATE TABLE `oc_news_description` (
  `news_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `meta_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_general_ci NOT NULL, 
  `seo_h1` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`news_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS oc_news_related;
CREATE TABLE `oc_news_related` (
  `news_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_news_to_layout;
CREATE TABLE `oc_news_to_layout` (
  `news_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_news_to_ncategory;
CREATE TABLE `oc_news_to_ncategory` (
  `news_id` int(11) NOT NULL,
  `ncategory_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`ncategory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_news_to_store;
CREATE TABLE `oc_news_to_store` (
  `news_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_customer_support;
CREATE TABLE `oc_customer_support` (
	`customer_support_id` INT(11) NOT NULL AUTO_INCREMENT,
	`customer_support_topic_id` INT(11) NULL DEFAULT NULL,
	`customer_support_status` VARCHAR(50) NULL,
	`store_id` INT(11) NULL DEFAULT NULL,
	`customer_id` INT(11) NULL DEFAULT NULL,
	`reference` VARCHAR(50) NULL,
	`subject` TINYTEXT NULL COLLATE 'utf8_general_ci',
	`enquiry` TEXT NULL COLLATE 'utf8_general_ci',
	`date_added` DATETIME NULL DEFAULT NULL,
	`date_updated` DATETIME NULL DEFAULT NULL,
	`customer_support_1st_category_id` INT(11) NULL DEFAULT NULL,
	`customer_support_2nd_category_id` INT(11) NULL DEFAULT NULL,
	`status` TINYINT(4) NULL DEFAULT '1',
	PRIMARY KEY (`customer_support_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
	
DROP TABLE IF EXISTS oc_customer_support_category;	
CREATE TABLE `oc_customer_support_category` (
	`category_id` INT(11) NOT NULL AUTO_INCREMENT,
	`parent_id` INT(11) NOT NULL DEFAULT '0',
	`sort_order` INT(3) NOT NULL DEFAULT '0',
	`date_added` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`status` INT(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_customer_support_category_description;	
CREATE TABLE `oc_customer_support_category_description` (
	`category_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`category_id`, `language_id`),
	INDEX `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS oc_customer_support_category_to_store;	
CREATE TABLE `oc_customer_support_category_to_store` (
	`category_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,
	PRIMARY KEY (`category_id`, `store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

#### START 1.5.1.3

CREATE TABLE IF NOT EXISTS oc_tax_rate_to_customer_group (
    tax_rate_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    customer_group_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    PRIMARY KEY (tax_rate_id, customer_group_id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS oc_tax_rule (

    tax_rule_id int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    tax_class_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    tax_rate_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    based varchar(10) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    priority int(5) NOT NULL DEFAULT '1' COMMENT '',
    PRIMARY KEY (tax_rule_id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE oc_category_description ADD seo_title VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER meta_keyword;
ALTER TABLE oc_category_description ADD seo_h1 VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER seo_title;
ALTER TABLE oc_customer ADD token varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER approved;
ALTER TABLE oc_information_description ADD meta_description VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER description;
ALTER TABLE oc_information_description ADD meta_keyword VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER meta_description;
ALTER TABLE oc_information_description ADD seo_title VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER meta_keyword;
ALTER TABLE oc_information_description ADD seo_h1 VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER seo_title;
ALTER TABLE oc_option_value ADD image varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER option_id;
ALTER TABLE oc_product_description ADD seo_title VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER meta_keyword;
ALTER TABLE oc_product_description ADD seo_h1 VARCHAR(255) NOT NULL COLLATE utf8_general_ci AFTER seo_title;
ALTER TABLE oc_order MODIFY invoice_prefix varchar(26) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci;
ALTER TABLE oc_product_image ADD sort_order int(3) NOT NULL DEFAULT '0' COMMENT '' AFTER image;
ALTER TABLE oc_tax_rate ADD name varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER geo_zone_id;
ALTER TABLE oc_tax_rate ADD type char(1) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER rate;
ALTER TABLE oc_tax_rate DROP tax_class_id ;
ALTER TABLE oc_tax_rate DROP priority ;
ALTER TABLE oc_tax_rate MODIFY rate decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT '';
ALTER TABLE oc_tax_rate DROP description ;

ALTER TABLE oc_product_tag ADD INDEX product_id (product_id);
ALTER TABLE oc_product_tag ADD INDEX language_id (language_id);
ALTER TABLE oc_product_tag ADD INDEX tag (tag);

INSERT IGNORE INTO oc_manufacturer_description (manufacturer_id, language_id) SELECT manufacturer_id, language_id FROM oc_manufacturer , oc_language;

#### START 1.5.2


CREATE TABLE IF NOT EXISTS oc_customer_ip_blacklist (
    customer_ip_blacklist_id int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    ip varchar(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (customer_ip_blacklist_id),
    INDEX ip (ip)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS oc_order_fraud (
    order_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    customer_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    country_match varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    country_code varchar(2) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    high_risk_country varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    distance int(11) NOT NULL DEFAULT 0 COMMENT '',
    ip_region varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_city varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_latitude decimal(10,6) NOT NULL DEFAULT '' COMMENT '',
    ip_longitude decimal(10,6) NOT NULL DEFAULT '' COMMENT '',
    ip_isp varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_org varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_asnum int(11) NOT NULL DEFAULT 0 COMMENT '',
    ip_user_type varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_country_confidence varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_region_confidence varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_city_confidence varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_postal_confidence varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_postal_code varchar(10) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_accuracy_radius int(11) NOT NULL DEFAULT 0 COMMENT '',
    ip_net_speed_cell varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_metro_code int(3) NOT NULL DEFAULT 0 COMMENT '',
    ip_area_code int(3) NOT NULL DEFAULT 0 COMMENT '',
    ip_time_zone varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_region_name varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_domain varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_country_name varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_continent_code varchar(2) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ip_corporate_proxy varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    anonymous_proxy varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    proxy_score int(3) NOT NULL DEFAULT 0 COMMENT '',
    is_trans_proxy varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    free_mail varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    carder_email varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    high_risk_username varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    high_risk_password varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    bin_match varchar(10) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    bin_country varchar(2) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    bin_name_match varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    bin_name varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    bin_phone_match varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    bin_phone varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    customer_phone_in_billing_location varchar(8) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ship_forward varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    city_postal_match varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    ship_city_postal_match varchar(3) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    score decimal(10,5) NOT NULL DEFAULT '' COMMENT '',
    explanation text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    risk_score decimal(10,5) NOT NULL DEFAULT '' COMMENT '',
    queries_remaining int(11) NOT NULL DEFAULT 0 COMMENT '',
    maxmind_id varchar(8) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    error text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    date_added datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '',
    PRIMARY KEY (order_id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS oc_order_voucher (
    order_voucher_id int(11) NOT NULL DEFAULT 0 COMMENT '' auto_increment,
    order_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    voucher_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    description varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    code varchar(10) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    from_name varchar(64) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    from_email varchar(96) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    to_name varchar(64) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    to_email varchar(96) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    voucher_theme_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    message text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    amount decimal(15,4) NOT NULL DEFAULT '' COMMENT '',
    PRIMARY KEY (order_voucher_id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE oc_order ADD shipping_code varchar(128) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER shipping_method;
ALTER TABLE oc_order ADD payment_code varchar(128) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER payment_method;
ALTER TABLE oc_order ADD forwarded_ip varchar(15) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER ip;
ALTER TABLE oc_order ADD user_agent varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER forwarded_ip;
ALTER TABLE oc_order ADD accept_language varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER user_agent;
ALTER TABLE oc_order DROP reward;

ALTER TABLE oc_order_product ADD reward int(8) NOT NULL DEFAULT 0 COMMENT '' AFTER tax;

ALTER TABLE oc_product MODIFY `weight` decimal(15,8) NOT NULL DEFAULT '0.00000000' COMMENT '';
ALTER TABLE oc_product MODIFY `length` decimal(15,8) NOT NULL DEFAULT '0.00000000' COMMENT '';
ALTER TABLE oc_product MODIFY `width` decimal(15,8) NOT NULL DEFAULT '0.00000000' COMMENT '';
ALTER TABLE oc_product MODIFY `height` decimal(15,8) NOT NULL DEFAULT '0.00000000' COMMENT '';

ALTER TABLE `oc_return` ADD `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '' AFTER `order_id`;
ALTER TABLE `oc_return` ADD `product` varchar(255) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER `telephone`;
ALTER TABLE `oc_return` ADD `model` varchar(64) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER `product`;
ALTER TABLE `oc_return` ADD `quantity` int(4) NOT NULL DEFAULT '0' COMMENT '' AFTER `model`;
ALTER TABLE `oc_return` ADD `opened` tinyint(1) NOT NULL DEFAULT '0' COMMENT '' AFTER `quantity`;
ALTER TABLE `oc_return` ADD `return_reason_id` int(11) NOT NULL DEFAULT '0' COMMENT '' AFTER `opened`;
ALTER TABLE `oc_return` ADD `return_action_id` int(11) NOT NULL DEFAULT '0' COMMENT '' AFTER `return_reason_id`;

DROP TABLE IF EXISTS oc_return_product;

ALTER TABLE oc_tax_rate_to_customer_group DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

# Disable Category Module to force user to reenable with new settings to avoid php error
UPDATE `oc_setting` SET `value` = replace(`value`, 's:6:"status";s:1:"1"', 's:6:"status";s:1:"0"') WHERE `key` = 'category_module';

#### Start 1.5.2.2

# Disable UPS Extension to force user to reenable with new settings to avoid php error
UPDATE `oc_setting` SET `value` = 0 WHERE `key` = 'ups_status';

CREATE TABLE IF NOT EXISTS oc_customer_group_description (
    customer_group_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    language_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    name varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    description text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (customer_group_id, language_id)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE oc_address ADD company_id varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER company;
ALTER TABLE oc_address ADD tax_id varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER company_id;
ALTER TABLE oc_address DROP company_no;
ALTER TABLE oc_address DROP company_tax;

ALTER TABLE oc_customer_group ADD approval int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER customer_group_id;
ALTER TABLE oc_customer_group ADD telephone_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER approval;
ALTER TABLE oc_customer_group ADD fax_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER telephone_display;
ALTER TABLE oc_customer_group ADD address_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER fax_display;
ALTER TABLE oc_customer_group ADD company_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER address_display;
ALTER TABLE oc_customer_group ADD company_id_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER company_display;
ALTER TABLE oc_customer_group ADD company_id_required int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER company_id_display;
ALTER TABLE oc_customer_group ADD tax_id_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER company_id_required;
ALTER TABLE oc_customer_group ADD tax_id_required int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER tax_id_display;
ALTER TABLE oc_customer_group ADD address_2_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER tax_id_required;
ALTER TABLE oc_customer_group ADD additional_display int(1) NOT NULL DEFAULT 0 COMMENT '' AFTER address_2_display;
ALTER TABLE oc_customer_group ADD sort_order int(3) NOT NULL DEFAULT 0 COMMENT '' AFTER additional_display;

### This line is executed using php in the upgrade model file so we dont lose names
#ALTER TABLE oc_customer_group DROP name;

ALTER TABLE `oc_order` ADD payment_company_id varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER payment_company;
ALTER TABLE `oc_order` ADD payment_tax_id varchar(32) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci AFTER payment_company_id;
ALTER TABLE `oc_information` ADD bottom int(1) NOT NULL DEFAULT '1' COMMENT '' AFTER information_id;

CREATE TABLE IF NOT EXISTS oc_order_misc (
    order_id int(11) NOT NULL DEFAULT 0 COMMENT '',
    `key` varchar(64) NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    value text NOT NULL DEFAULT '' COMMENT '' COLLATE utf8_general_ci,
    PRIMARY KEY (order_id, `key`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;