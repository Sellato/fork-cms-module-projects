-- Create syntax for TABLE 'project_content'
CREATE TABLE `project_content` (
  `project_id` bigint(20) NOT NULL,
  `language` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `seo_url_overwrite` enum('N','Y') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description_overwrite` enum('N','Y') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_title_overwrite` enum('N','Y') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- Create syntax for TABLE 'project_images'
CREATE TABLE `project_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sequence` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `edited_on` datetime NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `hidden` enum('N','Y') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- Create syntax for TABLE 'project_images_content'
CREATE TABLE `project_images_content` (
  `image_id` bigint(20) NOT NULL,
  `language` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- Create syntax for TABLE 'projects'
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hidden` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `edited_on` timestamp NULL DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `status` enum('active','draft') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_on` timestamp NULL DEFAULT NULL,
  `size` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- Create syntax for TABLE 'projects_categories'
CREATE TABLE `projects_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_on` timestamp NULL DEFAULT NULL,
  `edited_on` timestamp NULL DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `hidden` enum('N','Y') COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `parent_id` int(11) DEFAULT NULL,
  `path` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- Create syntax for TABLE 'projects_category_content'
CREATE TABLE `projects_category_content` (
  `category_id` bigint(20) NOT NULL,
  `language` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `extra_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- Create syntax for TABLE 'projects_linked_catgories'
CREATE TABLE `projects_linked_catgories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;
