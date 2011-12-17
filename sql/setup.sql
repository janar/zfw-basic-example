
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `users` (`id`, `role`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'admin', 'admin', 'user', 'admin@admin.com', 'd3942dce589a8baf879be01b717184712b119a72');
 
