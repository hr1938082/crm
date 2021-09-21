-- --------------------------------------------------------

--
-- Database: `Client Manager`
--

-- --------------------------------------------------------

SET sql_mode = '';
-- --------------------------------------------------------

--
-- Table structure for table `kk_attached_files`
--

DROP TABLE IF EXISTS `kk_attached_files`;
CREATE TABLE IF NOT EXISTS `kk_attached_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kk_clients`
--

DROP TABLE IF EXISTS `kk_clients`;
CREATE TABLE IF NOT EXISTS `kk_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `emailconfirmed` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

DROP TABLE IF EXISTS `kk_client_activity`;
CREATE TABLE IF NOT EXISTS `kk_client_activity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Table structure for table `kk_comments`
--

DROP TABLE IF EXISTS `kk_comments`;
CREATE TABLE IF NOT EXISTS `kk_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `comment_to` varchar(255) NOT NULL,
  `to_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_contacts`
--

DROP TABLE IF EXISTS `kk_contacts`;
CREATE TABLE IF NOT EXISTS `kk_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(40) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `website` varchar(255) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(100) NOT NULL,
  `persons` text NOT NULL,
  `remark` text NOT NULL,
  `marketing` text NOT NULL,
  `expire` date NOT NULL,
  `lead_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `other` text NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_currency`
--

DROP TABLE IF EXISTS `kk_currency`;
CREATE TABLE IF NOT EXISTS `kk_currency` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(5) NOT NULL,
  `abbr` varchar(10) NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kk_departments`
--

DROP TABLE IF EXISTS `kk_departments`;
CREATE TABLE IF NOT EXISTS `kk_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_domains`
--

DROP TABLE IF EXISTS `kk_domains`;
CREATE TABLE IF NOT EXISTS `kk_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `registration_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `provider` varchar(255) NOT NULL,
  `hosting` varchar(255) NOT NULL,
  `customer` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `renew` tinyint(1) NOT NULL,
  `remark` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `zz_email_logs`
--
DROP TABLE IF EXISTS `kk_email_logs`;
CREATE TABLE IF NOT EXISTS `kk_email_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_to` varchar(100) NOT NULL,
  `email_bcc` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_event`
--

DROP TABLE IF EXISTS `kk_event`;
CREATE TABLE IF NOT EXISTS `kk_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allday` tinyint(1) NOT NULL,
  `color` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_expenses`
--

DROP TABLE IF EXISTS `kk_expenses`;
CREATE TABLE IF NOT EXISTS `kk_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_by` varchar(255) NOT NULL,
  `expense_type` int(11) NOT NULL,
  `currency` int(3) NOT NULL,
  `purchase_amount` int(100) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `description` text NOT NULL,
  `attached_file` text NOT NULL,
  `other` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_expense_type`
--

DROP TABLE IF EXISTS `kk_expense_type`;
CREATE TABLE IF NOT EXISTS `kk_expense_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_info`
--

DROP TABLE IF EXISTS `kk_info`;
CREATE TABLE IF NOT EXISTS `kk_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `legal_name` varchar(255) NOT NULL,
  `language` varchar(60) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `invoice_setting` text NOT NULL,
  `theme` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kk_info`
--

INSERT INTO `kk_info` (`id`, `url`, `name`, `legal_name`, `language`, `logo`, `favicon`, `email`, `address`, `phone`, `fax`, `currency`, `signature`, `invoice_setting`, `theme`, `last_updated`) VALUES
(1, 'pepdev.com', 'Compnay Name', 'Compnay Legel Name', 'en-US', 'logo-color.png', 'favicon.png', 'support@pepdev', '{"address1":"Address 1","address2":"Address 2","city":"City","country":"Country","pincode":"000000"}', '1234567890', '1234567213', 'USD', '', '{\"accountnumber\":\"1234567890123456\",\"accountname\":\"John Doe\",\"bankname\":\"Bank Name\",\"bankdetails\":\"Bank code - 1234567\",\"template\":\"2\",\"customernote\":\"It was pleasure working with you\",\"tc\":\"Pay us as soon as possible to avoid delay charges\"}', '{\"layout\":\"\",\"layout_fixed\":\"menu-fixed page-hdr-fixed\",\"layout_menu\":false,\"side_menu\":\"dark\",\"header_color\":\"bg-white\"}', '2018-02-23 08:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `kk_invoice`
--

DROP TABLE IF EXISTS `kk_invoice`;
CREATE TABLE IF NOT EXISTS `kk_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `duedate` date NOT NULL,
  `paiddate` date NOT NULL,
  `currency` int(5) NOT NULL,
  `paymenttype` int(11) NOT NULL,
  `items` text NOT NULL,
  `total` text,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `discount_type` int(2) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `due` decimal(10,2) NOT NULL,
  `note` text,
  `tc` varchar(255) NOT NULL,
  `want_payment` int(1) NOT NULL,
  `want_signature` int(1) NOT NULL,
  `project_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `inv_status` tinyint(1) NOT NULL,
  `rid` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_items`
--

DROP TABLE IF EXISTS `kk_items`;
CREATE TABLE IF NOT EXISTS `kk_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `currency` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_leads`
--

DROP TABLE IF EXISTS `kk_leads`;
CREATE TABLE IF NOT EXISTS `kk_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(30) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `website` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `source` varchar(255) NOT NULL,
  `marketing` text NOT NULL,
  `expire` date NOT NULL,
  `contact_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `kk_login_attempts`
--

DROP TABLE IF EXISTS `kk_login_attempts`;
CREATE TABLE IF NOT EXISTS `kk_login_attempts` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `count` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_notes`
--

DROP TABLE IF EXISTS `kk_notes`;
CREATE TABLE IF NOT EXISTS `kk_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(7) NOT NULL,
  `background` varchar(7) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `other` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_payments`
--

DROP TABLE IF EXISTS `kk_payments`;
CREATE TABLE IF NOT EXISTS `kk_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `method` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` int(3) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payer_ip` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `paid_to` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_payment_gateway`
--

DROP TABLE IF EXISTS `kk_payment_gateway`;
CREATE TABLE IF NOT EXISTS `kk_payment_gateway` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `mode` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kk_payment_gateway`
--

INSERT INTO `kk_payment_gateway` (`id`, `username`, `password`, `signature`, `mode`, `status`, `last_updated`) VALUES
(1, '', '', '', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `kk_payment_status`
--

DROP TABLE IF EXISTS `kk_payment_status`;
CREATE TABLE IF NOT EXISTS `kk_payment_status` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_payment_type`
--

DROP TABLE IF EXISTS `kk_payment_type`;
CREATE TABLE IF NOT EXISTS `kk_payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_projects`
--

DROP TABLE IF EXISTS `kk_projects`;
CREATE TABLE IF NOT EXISTS `kk_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `customer` int(11) NOT NULL,
  `billing_method` int(2) NOT NULL,
  `currency` int(4) NOT NULL,
  `rate_hour` int(4) NOT NULL,
  `project_hour` int(4) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `staff` text NOT NULL,
  `task` text NOT NULL,
  `completed` int(3) NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_proposal`
--

DROP TABLE IF EXISTS `kk_proposal`;
CREATE TABLE IF NOT EXISTS `kk_proposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `currency` int(5) NOT NULL,
  `paymenttype` int(2) NOT NULL,
  `date` date NOT NULL,
  `expiry` date NOT NULL,
  `rate` int(11) NOT NULL,
  `items` text NOT NULL,
  `total` text NOT NULL,
  `note` varchar(255) NOT NULL,
  `tc` varchar(255) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `zz_recurring_invoice`
--
DROP TABLE IF EXISTS `kk_recurring_invoice`;
CREATE TABLE IF NOT EXISTS `kk_recurring_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `currency` int(5) NOT NULL,
  `paymenttype` int(11) NOT NULL,
  `items` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `discount_type` int(2) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text,
  `tc` varchar(255) NOT NULL,
  `want_payment` int(1) NOT NULL,
  `want_signature` int(1) NOT NULL,
  `other` text NOT NULL,
  `repeat_every` varchar(10) NOT NULL,
  `inv_status` tinyint(1) NOT NULL,
  `inv_date` date NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `zz_recurring_log`
--

DROP TABLE IF EXISTS `kk_recurring_log`;
CREATE TABLE IF NOT EXISTS `kk_recurring_log` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `recurring_type` varchar(50) NOT NULL,
  `logs` text NOT NULL,
  `other` text NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `kk_setting`
--
DROP TABLE IF EXISTS `kk_setting`;
CREATE TABLE IF NOT EXISTS `kk_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `data` text,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;


--
-- Dumping data for table `kk_setting`
--

INSERT INTO `kk_setting` (`id`, `name`, `data`, `status`) VALUES
(1, 'emailsetting', '{"fromemail":"","fromname":"","reply":"","host":"","port":"25","username":"","password":"","encryption":"tls","authentication":"1"}', 0),
(2, 'recurring', '123456', 1);


-- --------------------------------------------------------

--
-- Table structure for table `kk_subscribe`
--

DROP TABLE IF EXISTS `kk_subscribe`;
CREATE TABLE IF NOT EXISTS `kk_subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `kk_taxes`
--

DROP TABLE IF EXISTS `kk_taxes`;
CREATE TABLE IF NOT EXISTS `kk_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `rate` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kk_template`
--

DROP TABLE IF EXISTS `kk_template`;
CREATE TABLE IF NOT EXISTS `kk_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;


INSERT INTO `kk_template` (`id`, `template`, `name`, `subject`, `message`, `status`, `last_updated`) VALUES
(1, 'newticket', 'New Ticket', 'Manasa Theme: New Ticket Received ', '&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Dear {NAME},&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Your support ticket&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; font-family: Verdana;&quot;&gt;{SUBJECT}&lt;/span&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;&amp;nbsp;has been submitted. We try to reply to all tickets as soon as possible, usually within 24 hours.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Your ID: {ID}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Your Email Address: {EMAIL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket message: {MESSAGE}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;You can view the status of your ticket here: {TICKETURL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;You will receive an e-mail notification when our staff replies to your ticket.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder; font-family: Verdana;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;/p&gt;', 0, '2018-03-15 16:15:41'),
(2, 'deleteticket', 'Delete Ticket', 'Manasa Theme: Delete Ticket', '&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket Deleted&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket Subject : {SUBJECT}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket ID:{ID} is Deleted.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: red; font-family: Verdana;&quot;&gt;&lt;strong&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/strong&gt;&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;/p&gt;', 0, '2018-03-15 16:15:47'),
(3, 'ticketresponce', 'Ticket Responce', 'Manasa Theme: Ticket Responce ', '&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Hello,&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Staff just reply of your ticket &lt;/span&gt;&lt;strong&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{SUBJECT}&lt;/span&gt;&lt;/strong&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Name: {NAME}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;ID: {ID}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Email Address: {EMAIL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Message: {MESSAGE}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;You can manage this ticket here: {TICKETURL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: red; font-family: Verdana;&quot;&gt;&lt;strong&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/strong&gt;&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;/p&gt;', 0, '2018-03-15 16:16:01'),
(4, 'ticketreply', 'Ticket Reply', 'Manasa Theme: Ticket Reply  ', '&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Hello,&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;A new reply of ticket &lt;/span&gt;&lt;strong&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{SUBJECT} &lt;/span&gt;&lt;/strong&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;has been submitted.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Name: {NAME}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket ID: {ID}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Email Address: {EMAIL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Message: {MESSAGE}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;You can manage this ticket here:&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{TICKETURL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: red; font-family: Verdana;&quot;&gt;&lt;strong&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/strong&gt;&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!&lt;/span&gt;&lt;/p&gt;', 0, '2018-03-15 16:16:06'),
(5, 'closeticket', 'Close Ticket', 'Manasa Theme: Close Ticket ', '&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket Close&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket Subject : {SUBJECT}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Ticket ID:{ID} is Closed.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;You can manage this ticket here&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{TICKETURL}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: red; font-family: Verdana;&quot;&gt;&lt;strong&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/strong&gt;&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;/p&gt;', 0, '2018-03-15 16:16:13'),
(6, 'newinvoice', 'New Invoice', 'Manasa Theme: Invoice Created', '&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt; font-weight: bold;&quot; style=&quot;padding: 5px;&quot;&gt;&lt;font color=&quot;#222222&quot; face=&quot;verdana, droid sans, lucida sans, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-family: Verdana;&quot;&gt;Hello {company},&lt;/span&gt;&lt;/font&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt; font-weight: bold;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; padding: 5px; font-size: 11pt; font-weight: bold;&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-weight: 400; font-family: Verdana;&quot;&gt;This email serves as your official invoice from&amp;nbsp;&lt;/span&gt;&lt;strong style=&quot;font-size: 13.3333px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{business_name}.&lt;/span&gt;&lt;/strong&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 10px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 10px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Invoice URL: {inv_url}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Invoice ID: {inv_id}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Invoice Amount: {amount}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Paid Amount: {paid}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Due Amount: {due}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Due Date: {due_date}&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span data-mce-style=&quot;font-size: 13.3333330154419px; line-height: 21.3333320617676px;&quot; style=&quot;font-size: 13.3333px; line-height: 21.3333px; font-family: Verdana;&quot;&gt;Invoice PDF has been attached to this mail. If you have any questions or need assistance, please don\'t hesitate to contact us.&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Best Regards,&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{business_name} Team&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder; font-family: Verdana;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br style=&quot;color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;br&gt;&lt;/div&gt;', 0, '2018-03-15 16:16:23'),
(7, 'newquotes', 'New Quotes', 'Manasa Theme: Quotes Created', '&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt; font-weight: bold;&quot; style=&quot;padding: 5px;&quot;&gt;&lt;span style=&quot;color: rgb(34, 34, 34); font-family: Verdana; font-size: 13.3333px;&quot;&gt;Hello {company}&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Here is the quote you requested for {project_name}. The quote is valid until {valid_until}.&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 10px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 10px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Quote URL: {quote_url}&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 10px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 10px 5px;&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-family: Verdana;&quot;&gt;Amount:&amp;nbsp;{amount}&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span data-mce-style=&quot;font-size: 13.3333330154419px; line-height: 21.3333320617676px;&quot; style=&quot;font-size: 13.3333px; line-height: 21.3333px;&quot;&gt;&lt;span style=&quot;font-family: Verdana; font-size: 13.3333px;&quot;&gt;Quote PDF has been attached to this mail.&lt;/span&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;&amp;nbsp;You may view the quote at any time and if you have any query then contact us.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Best Regards,&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{business_name} Team&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder; font-family: Verdana;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br style=&quot;color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;br&gt;&lt;/div&gt;', 0, '2018-03-15 16:17:02'),
(8, 'newuser', 'New Admin User', 'Manasa Theme: New Admin User ', '&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Hello {name},&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Welcome to {business_name}.&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Your admin credentials has been created. Now you can login to admin portal. See below for credentials...&amp;nbsp;&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;---------------------------------------------------------------------------------------&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Login URL: {login_url}&amp;nbsp;&lt;br&gt;Username: {username}&lt;br&gt;Email Address: {email}&lt;br&gt;Password: {password}&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;----------------------------------------------------------------------------------------&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;We very much appreciate you for choosing us.&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;{business_name} Team&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif; color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br style=&quot;font-family: Poppins, Poppins, sans-serif;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 0, '2018-03-15 10:42:22'),
(9, 'newclient', 'New Client', 'Manasa Theme: New Client', '&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Dear {name},&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Welcome to {business_name}.&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;You can track your invoice, quotes, tickets, profile, transactions from this portal.&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Your login information is as follows:&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;---------------------------------------------------------------------------------------&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;Login URL: {client_login_url}&amp;nbsp;&lt;br&gt;Email Address: {email}&lt;br&gt;Password: Your chosen password.&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;----------------------------------------------------------------------------------------&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;We very much appreciate you for choosing us.&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;{business_name} Team&lt;/p&gt;&lt;p style=&quot;font-family: Verdana, Arial, Helvetica, sans-serif;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif; color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br style=&quot;font-family: Poppins, Poppins, sans-serif;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 0, '2018-03-15 12:29:34'),
(10, 'forgotpassword', 'Forgot password', 'Manasa Theme: forgot Password', '&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt; font-weight: bold;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; padding: 5px; font-size: 11pt; font-weight: bold;&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-weight: 400; font-family: Verdana;&quot;&gt;Hello {name}&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt; font-weight: bold;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; padding: 5px; font-size: 11pt; font-weight: bold;&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-weight: 400; font-family: Verdana;&quot;&gt;This is to confirm that we have received a Forgot Password request for your Account Username - {email}&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Click this link to reset your password-&amp;nbsp;&lt;/span&gt;&lt;br&gt;&lt;font color=&quot;#1da9c0&quot;&gt;&lt;span style=&quot;padding: 3px; font-family: Verdana;&quot;&gt;&lt;b&gt;{reset_link}&lt;/b&gt;&lt;/span&gt;&lt;/font&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Please note: until your password has been changed, your current password will remain valid. If you have not generated this request. Please contact us as soon as possible.&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Regards,&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{business_name} Team&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder; font-family: Verdana;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br style=&quot;color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;br&gt;&lt;/div&gt;', 0, '2018-03-15 16:17:17'),
(11, 'paymentconfirmation', 'Payment Confirmation', 'Invoice Payment Confirmation', '&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt;&quot; style=&quot;padding: 5px;&quot;&gt;&lt;font color=&quot;#222222&quot; face=&quot;verdana, droid sans, lucida sans, sans-serif&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-family: Verdana;&quot;&gt;Hello {company},&lt;/span&gt;&lt;/font&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px; font-size: 11pt;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; padding: 5px; font-size: 11pt; font-weight: bold;&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-weight: 400; font-family: Verdana;&quot;&gt;This is a payment receipt for Invoice {id}&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Login to your client Portal to view this invoice.&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 10px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 10px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Invoice URL: {inv_url}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Invoice ID: {id}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Paid Amount: {paid_amount}&lt;/span&gt;&lt;br style=&quot;font-size: 13.3333px;&quot;&gt;&lt;span style=&quot;font-size: 13.3333px; font-family: Verdana;&quot;&gt;Paid Date: {paid_date}&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Transaction Id: {txn_id}&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 5px;&quot;&gt;&lt;span data-mce-style=&quot;font-size: 13.3333330154419px; line-height: 21.3333320617676px;&quot; style=&quot;font-size: 13.3333px; line-height: 21.3333px; font-family: Verdana;&quot;&gt;If you have any questions or need assistance, please don\'t hesitate to contact us.&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;Best Regards,&lt;/span&gt;&lt;br&gt;&lt;span style=&quot;font-family: Verdana;&quot;&gt;{business_name} Team&lt;/span&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;br&gt;&lt;/div&gt;&lt;div data-mce-style=&quot;padding: 0px 5px;&quot; style=&quot;color: rgb(34, 34, 34); font-family: verdana, &amp;quot;droid sans&amp;quot;, &amp;quot;lucida sans&amp;quot;, sans-serif; font-size: 13.3333px; padding: 0px 5px;&quot;&gt;&lt;span style=&quot;font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;&quot;&gt;&lt;span style=&quot;font-weight: bolder; font-family: Verdana;&quot;&gt;*DO NOT REPLY TO THIS E-MAIL*&lt;/span&gt;&lt;/span&gt;&lt;br style=&quot;color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;&quot;&gt;This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!&lt;/span&gt;&lt;br&gt;&lt;/div&gt;', 0, '2018-03-15 16:17:25');


-- --------------------------------------------------------

--
-- Table structure for table `kk_tickets`
--

DROP TABLE IF EXISTS `kk_tickets`;
CREATE TABLE IF NOT EXISTS `kk_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `department` varchar(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `reply_status` tinyint(1) NOT NULL,
  `remark` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_updated` datetime NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kk_tickets_message`
--

DROP TABLE IF EXISTS `kk_tickets_message`;
CREATE TABLE IF NOT EXISTS `kk_tickets_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `attached` text NOT NULL,
  `message_by` tinyint(1) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kk_users`
--

DROP TABLE IF EXISTS `kk_users`;
CREATE TABLE IF NOT EXISTS `kk_users` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_role` int(4) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `meta` text,
  `other` text,
  `password` varchar(255) NOT NULL,
  `temp_hash` varchar(225) NOT NULL,
  `emailconfirmed` bit(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_of_joining` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kk_users`
--

INSERT INTO `kk_users` (`user_id`, `user_role`, `user_name`, `firstname`, `lastname`, `email`, `mobile`, `meta`, `other`, `password`, `temp_hash`, `emailconfirmed`, `status`, `date_of_joining`) VALUES
(1, 1, 'admin', 'John', '', 'support@pepdev.com', '1111111111', NULL, NULL, '$2y$10$9AdTEHAJODoONsTAsgsZWeRnSCPavPsWJ6f8ifUQ6p1w7zHAAj9/q', '', '1', 1, '2018-02-15 14:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `kk_user_role`
--

DROP TABLE IF EXISTS `kk_user_role`;
CREATE TABLE IF NOT EXISTS `kk_user_role` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kk_user_role`
--

INSERT INTO `kk_user_role` (`id`, `name`, `description`, `permission`, `date_of_joining`) VALUES
(1, 'Admin', 'You can not change Admin role setting', '["contacts","contact\\/add","contact\\/edit","contact\\/delete","projects","project\\/add","project\\/edit","project\\/delete","quotes","quote\\/add","quote\\/edit","quote\\/delete","invoices","invoice\\/add","invoice\\/edit","invoice\\/delete","expenses","expense\\/add","expense\\/edit","expense\\/delete","users","user\\/add","user\\/edit","user\\/delete","subscriber","subscriber\\/add","subscriber\\/edit","subscriber\\/delete"]', '2018-01-11 04:45:47');

