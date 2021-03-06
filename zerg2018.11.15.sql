-- phpMyAdmin SQL Dump
-- version 4.0.10.19
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018-11-15 17:15:54
-- 服务器版本: 5.6.35-log
-- PHP 版本: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zerg`
--

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='banner管理表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`id`, `name`, `description`, `delete_time`, `update_time`, `create_time`) VALUES
(1, '首页置顶', '首页轮播图', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `banner_item`
--

CREATE TABLE IF NOT EXISTS `banner_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `delete_time` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='banner子项表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `banner_item`
--

INSERT INTO `banner_item` (`id`, `img_id`, `key_word`, `type`, `delete_time`, `banner_id`, `update_time`, `create_time`) VALUES
(1, 65, '6', 1, NULL, 1, NULL, NULL),
(2, 2, '25', 1, NULL, 1, NULL, NULL),
(3, 3, '11', 1, NULL, 1, NULL, NULL),
(5, 1, '10', 1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `img_url` varchar(255) DEFAULT NULL COMMENT '外键，关联image表',
  `delete_time` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `listorder` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='商品类目' AUTO_INCREMENT=92 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `img_url`, `delete_time`, `description`, `update_time`, `create_time`, `listorder`) VALUES
(2, '果味', '/images/category-dryfruit.png', NULL, NULL, 1540454198, NULL, 1),
(3, '蔬菜', '/images/category-vg.png', NULL, NULL, NULL, NULL, 8),
(4, '炒货', '/images/category-fry-a.png', NULL, NULL, 1540454208, NULL, 2),
(5, '点心', '/images/category-cake.png', NULL, NULL, NULL, NULL, 7),
(6, '粗茶', '/images/category-tea.png', NULL, NULL, NULL, NULL, 9),
(7, '淡饭', '/images/category-rice.png', NULL, NULL, 1540454214, NULL, 3),
(88, 'mmme', '/images/20181114/f4e0d5e412bf1b2f511627ba2636fbb7.png', NULL, NULL, 1542190151, 1540458532, 0.4),
(89, 'emmmmm', '/images/20181026/00e8498112517d80387a667cbf3e63cf.jpg', NULL, NULL, 1541250491, 1540542370, 2),
(91, 'cc', '/images/20181115/ac5a5fcfe8d799f2f83792c1b930de48.png', NULL, NULL, 1542249574, 1542190166, 0);

-- --------------------------------------------------------

--
-- 表的结构 `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 来自本地，2 来自公网',
  `usage_comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'useless',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='图片总表' AUTO_INCREMENT=107 ;

--
-- 转存表中的数据 `image`
--

INSERT INTO `image` (`id`, `url`, `from`, `usage_comment`, `delete_time`, `update_time`, `create_time`) VALUES
(1, '/images/banner-1a.png', 1, '""', NULL, NULL, NULL),
(2, '/images/banner-2a.png', 1, '""', NULL, NULL, NULL),
(3, '/images/banner-3a.png', 1, '""', NULL, NULL, NULL),
(9, '/images/category-rice.png', 1, '""', NULL, NULL, NULL),
(10, '/images/product-dryfruit@1.png', 1, '""', NULL, NULL, NULL),
(13, '/images/product-vg@1.png', 1, '""', NULL, NULL, NULL),
(14, '/images/product-rice@6.png', 1, '""', NULL, NULL, NULL),
(16, '/images/1@theme.png', 1, '""', NULL, NULL, NULL),
(17, '/images/2@theme.png', 1, '""', NULL, NULL, NULL),
(18, '/images/3@theme.png', 1, '""', NULL, NULL, NULL),
(31, '/images/product-rice@1.png', 1, '""', NULL, NULL, NULL),
(32, '/images/product-tea@1.png', 1, '""', NULL, NULL, NULL),
(33, '/images/product-dryfruit@2.png', 1, '""', NULL, NULL, NULL),
(36, '/images/product-dryfruit@3.png', 1, '""', NULL, NULL, NULL),
(37, '/images/product-dryfruit@4.png', 1, '""', NULL, NULL, NULL),
(38, '/images/product-dryfruit@5.png', 1, '""', NULL, NULL, NULL),
(39, '/images/product-dryfruit-a@6.png', 1, '""', NULL, NULL, NULL),
(40, '/images/product-dryfruit@7.png', 1, '""', NULL, NULL, NULL),
(41, '/images/product-rice@2.png', 1, '""', NULL, NULL, NULL),
(42, '/images/product-rice@3.png', 1, '""', NULL, NULL, NULL),
(43, '/images/product-rice@4.png', 1, '""', NULL, NULL, NULL),
(44, '/images/product-fry@1.png', 1, '""', NULL, NULL, NULL),
(45, '/images/product-fry@2.png', 1, '""', NULL, NULL, NULL),
(46, '/images/product-fry@3.png', 1, '""', NULL, NULL, NULL),
(47, '/images/product-tea@2.png', 1, '""', NULL, NULL, NULL),
(48, '/images/product-tea@3.png', 1, '""', NULL, NULL, NULL),
(49, '/images/1@theme-head.png', 1, '""', NULL, NULL, NULL),
(50, '/images/2@theme-head.png', 1, '""', NULL, NULL, NULL),
(51, '/images/3@theme-head.png', 1, '""', NULL, NULL, NULL),
(52, '/images/product-cake@1.png', 1, '""', NULL, NULL, NULL),
(53, '/images/product-cake@2.png', 1, '""', NULL, NULL, NULL),
(54, '/images/product-cake-a@3.png', 1, '""', NULL, NULL, NULL),
(55, '/images/product-cake-a@4.png', 1, '""', NULL, NULL, NULL),
(56, '/images/product-dryfruit@8.png', 1, '""', NULL, NULL, NULL),
(57, '/images/product-fry@4.png', 1, '""', NULL, NULL, NULL),
(58, '/images/product-fry@5.png', 1, '""', NULL, NULL, NULL),
(59, '/images/product-rice@5.png', 1, '""', NULL, NULL, NULL),
(60, '/images/product-rice@7.png', 1, '""', NULL, NULL, NULL),
(62, '/images/detail-12@1-dryfruit.png', 1, '""', NULL, NULL, NULL),
(63, '/images/detail-13@1-dryfruit.png', 1, '""', NULL, NULL, NULL),
(65, '/images/banner-4a.png', 1, '""', NULL, NULL, NULL),
(66, '/images/product-vg@4.png', 1, '""', NULL, NULL, NULL),
(67, '/images/product-vg@5.png', 1, '""', NULL, NULL, NULL),
(68, '/images/product-vg@2.png', 1, '""', NULL, NULL, NULL),
(69, '/images/product-vg@3.png', 1, '""', NULL, NULL, NULL),
(70, '/images/20181016/8a5743254e17f7f519c806a7951ea6fe.jpg', 1, '""', NULL, NULL, NULL),
(71, '/images/20181016/95f49b5252871c1f1411047882cf766f.jpg', 1, 'useless', NULL, 1539698479, 1539698479),
(72, '/images/20181016/55bb636f9db9892001ac0f7a8f43f07b.jpg', 1, 'useless', NULL, 1539699200, 1539699200),
(73, '/images/20181016/1be3170138bce6671c4bf8e106824b83.jpg', 1, 'useless', NULL, 1539699306, 1539699306),
(74, '/images/20181016/961933209646900aedbc50850a30b527.jpg', 1, 'useless', NULL, 1539703765, 1539703765),
(75, '/images/20181016/991502c6d602fb57da9fe728f27147fe.jpg', 1, 'useless', NULL, 1539703842, 1539703842),
(76, '/images/20181016/948fb8167a8a2b20b7aef3d770184a4f.jpg', 1, 'image for category id = 76', NULL, 1539704392, 1539704218),
(77, '/images/20181023/44642383a6d9cd54bbe6c66e56651e86.jpg', 1, 'useless', NULL, 1540307679, 1540307679),
(78, '/images/20181024/be59da83e9aff2861b53b47a2e8e2975.jpg', 1, 'useless', NULL, 1540359608, 1540359608),
(79, '/images/20181024/021118e257b234fd05856d8df6049771.jpg', 1, 'useless', NULL, 1540365092, 1540365092),
(80, '/images/20181024/6f06179c284ab3ecd339a64a915f8749.jpg', 1, 'image for category id = 76', NULL, 1540381142, 1540381142),
(81, '/images/20181024/f93a9657438500e73ebef09eaaaba2f7.JPG', 1, 'image for category id = 77', NULL, 1540381320, 1540381320),
(82, '/images/20181024/be9c66170a0c47d0e4d9c43c5deeaf23.jpg', 1, 'image for category id = 78', NULL, 1540381335, 1540381335),
(83, '/images/20181024/b7c58a120e0dba66b63e30f40d6177cd.jpg', 1, 'image for category id = 79', NULL, 1540381360, 1540381360),
(84, '/images/20181024/85d26823a8b778794f8ba1de44d8b411.jpg', 1, 'image for category id = 80', NULL, 1540381378, 1540381378),
(85, '/images/20181024/4b4cdb9d9aecf3aaf5539186df6b23a6.jpg', 1, 'image for category id = 81', NULL, 1540390662, 1540390662),
(86, '/images/20181024/d9a1e515c3aa0c3a94035cb8e7bf663f.jpg', 1, 'image for category id = 82', NULL, 1540396767, 1540396767),
(87, '/images/20181025/4e0db661083c36619842bb60194e322f.jpg', 1, 'image for category id = 83', NULL, 1540396851, 1540396851),
(88, '/images/20181025/30c5e6347458ac0b78029a17ab080502.jpg', 1, 'image for category id = 84', NULL, 1540396892, 1540396892),
(89, '/images/20181025/83e3feff7a366fea57c47375474c9277.jpg', 1, 'image for category id = 85', NULL, 1540396945, 1540396945),
(90, '/images/20181025/dc8511d5c2458d049e1722d6103de845.jpg', 1, 'image for category id = 86', 1540435014, 1540435014, 1540432356),
(91, '/images/20181025/03c8036d70b0001fa2fc5aebc998289c.jpg', 1, 'image for category id = 87', 1540532803, 1540532803, 1540455123),
(92, '/images/20181025/845284dbff66473e8fc1f55951a7f650.jpg', 1, 'image for category id = 88', NULL, 1540458532, 1540458532),
(93, '/images/20181026/557d7a011a38dad35b0004ddea1f7631.jpg', 1, 'image for category id = 88', NULL, 1540532823, 1540532823),
(94, '/images/20181026/222d01697b27806bfebdf40a0775f0ad.jpg', 1, 'image for category id = 88', NULL, 1540532857, 1540532857),
(95, '/images/20181026/679abf155b9ac8abf6903006e3dbd732.jpg', 1, 'image for category id = 88', NULL, 1540532966, 1540532966),
(96, '/images/20181026/ed177b9de52c009cdea79ba4894c5f1e.jpg', 1, 'image for category id = 88', NULL, 1540533287, 1540533287),
(97, '/images/20181026/70648597c2b76f38011a8363a6386788.jpg', 1, 'image for category id = 88', NULL, 1540533313, 1540533313),
(98, '/images/20181026/b40ff56052b6c4ad0ac3a920418d822b.jpg', 1, 'image for category id = 88', NULL, 1540533663, 1540533663),
(99, '/images/20181026/73be6e5d2cbb1ed868e96a6a58ceac9f.jpg', 1, 'image for category id = 88', NULL, 1540536643, 1540536643),
(100, '/images/20181026/8bb48964f115e3bd83d353ac8c3ba7b4.jpg', 1, 'image for category id = 88', NULL, 1540542332, 1540542332),
(101, '/images/20181026/ccf9f878581561bd7114cef095ec0175.jpg', 1, 'image for category id = 88', NULL, 1540542347, 1540542347),
(102, '/images/20181026/00e8498112517d80387a667cbf3e63cf.jpg', 1, 'image for category id = 89', NULL, 1540542370, 1540542370),
(103, '/images/20181103/fb4034fab46739f6044e71a3d920d608.jpg', 1, 'image for category id = 90', 1541264141, 1541264141, 1541249486),
(104, '/images/20181104/abbd6bdd8a93fa4af235da2a25aa4620.jpg', 1, 'image for category id = 88', NULL, 1541264164, 1541264164),
(105, '/images/20181112/eba9495820565b539b5ca57bf3d4fc48.jpg', 1, 'image for category id = 88', NULL, 1542013659, 1542013659),
(106, '/images/20181112/4d7858232975c4fd733ffa6f14d4fd4c.jpg', 1, 'image for category id = 88', NULL, 1542013869, 1542013869);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `total_price` decimal(6,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:未支付， 2：已支付，3：已发货 , 4: 已支付，但库存不足',
  `snap_img` varchar(255) DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) DEFAULT NULL,
  `snap_items` text COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) DEFAULT NULL COMMENT '地址快照',
  `prepay_id` varchar(100) DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=546 ;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `order_no`, `user_id`, `delete_time`, `create_time`, `total_price`, `status`, `snap_img`, `snap_name`, `total_count`, `update_time`, `snap_items`, `snap_address`, `prepay_id`) VALUES
(539, 'BA03361545670896', 58, NULL, 1538536154, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538536154, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL),
(540, 'BA03361623786509', 58, NULL, 1538536161, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538536161, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL),
(541, 'BA03370764563234', 58, NULL, 1538537076, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538537076, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL),
(542, 'BA03377187372918', 58, NULL, 1538537718, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538537718, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL),
(543, 'BA03377429542202', 58, NULL, 1538537742, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538537742, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL),
(544, 'BA03378731357605', 58, NULL, 1538537872, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538537872, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL),
(545, 'BA03392770271592', 58, NULL, 1538539276, '0.01', 1, 'http://z.cn/images/product-dryfruit@2.png', '春生龙眼 500克', 1, 1538539276, '[{"id":5,"name":"\\u6625\\u751f\\u9f99\\u773c 500\\u514b","main_img_url":"http:\\/\\/z.cn\\/images\\/product-dryfruit@2.png","count":1,"totalPrice":0.01,"price":"0.01","counts":1}]', '{"name":"John Doe","mobile":"020-81167888","province":"Guangdong Sheng","city":"Guangzhou Shi","country":"Haizhu Qu","detail":"397 Xingang Middle Rd, KeCun","update_time":"1970-01-01 08:00:00"}', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` int(11) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `order_product`
--

INSERT INTO `order_product` (`order_id`, `product_id`, `count`, `delete_time`, `update_time`, `create_time`) VALUES
(539, 5, 1, NULL, NULL, NULL),
(540, 5, 1, NULL, NULL, NULL),
(541, 5, 1, NULL, NULL, NULL),
(542, 5, 1, NULL, NULL, NULL),
(543, 5, 1, NULL, NULL, NULL),
(544, 5, 1, NULL, NULL, NULL),
(545, 5, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT '商品名称',
  `listorder` int(11) DEFAULT '0',
  `price` decimal(6,2) NOT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `delete_time` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `main_img_url` varchar(255) DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL,
  `summary` varchar(50) DEFAULT NULL COMMENT '摘要',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `listorder`, `price`, `stock`, `delete_time`, `category_id`, `main_img_url`, `create_time`, `update_time`, `summary`) VALUES
(1, '芹菜 半斤', 4, '0.01', 998, NULL, 3, '/images/product-vg@1.png', NULL, 1541265305, NULL),
(2, '梨花带雨 3个', 5, '0.01', 984, NULL, 2, '/images/product-dryfruit@1.png', NULL, 1541298920, NULL),
(3, '素米 327克', 2, '0.01', 996, NULL, 7, '/images/product-rice@1.png', NULL, 1541298929, NULL),
(4, '红袖枸杞 6克*3袋', 99, '0.01', 998, NULL, 6, '/images/product-tea@1.png', NULL, NULL, NULL),
(5, '春生龙眼 500克', 99, '0.01', 995, NULL, 2, '/images/product-dryfruit@2.png', NULL, NULL, NULL),
(6, '小红的猪耳朵 120克', 99, '0.01', 997, NULL, 5, '/images/product-cake@2.png', NULL, NULL, NULL),
(7, '泥蒿 半斤', 99, '0.01', 998, NULL, 3, '/images/product-vg@2.png', NULL, NULL, NULL),
(8, '夏日芒果 3个', 99, '0.01', 995, NULL, 2, '/images/product-dryfruit@3.png', NULL, NULL, NULL),
(9, '冬木红枣 500克', 99, '0.01', 996, NULL, 2, '/images/product-dryfruit@4.png', NULL, NULL, NULL),
(10, '万紫千凤梨 300克', 99, '0.01', 996, NULL, 2, '/images/product-dryfruit@5.png', NULL, NULL, NULL),
(11, '贵妃笑 100克', 99, '0.01', 994, NULL, 2, '/images/product-dryfruit-a@6.png', NULL, NULL, NULL),
(12, '珍奇异果 3个', 99, '0.01', 999, NULL, 2, '/images/product-dryfruit@7.png', NULL, NULL, NULL),
(13, '绿豆 125克', 99, '0.01', 999, NULL, 7, '/images/product-rice@2.png', NULL, NULL, NULL),
(14, '芝麻 50克', 99, '0.01', 999, NULL, 7, '/images/product-rice@3.png', NULL, NULL, NULL),
(15, '猴头菇 370克', 99, '0.01', 999, NULL, 7, '/images/product-rice@4.png', NULL, NULL, NULL),
(16, '西红柿 1斤', 99, '0.01', 999, NULL, 3, '/images/product-vg@3.png', NULL, NULL, NULL),
(17, '油炸花生 300克', 99, '0.01', 999, NULL, 4, '/images/product-fry@1.png', NULL, NULL, NULL),
(18, '春泥西瓜子 128克', 99, '0.01', 997, NULL, 4, '/images/product-fry@2.png', NULL, NULL, NULL),
(19, '碧水葵花籽 128克', 99, '0.01', 999, NULL, 4, '/images/product-fry@3.png', NULL, NULL, NULL),
(20, '碧螺春 12克*3袋', 99, '0.01', 999, NULL, 6, '/images/product-tea@2.png', NULL, NULL, NULL),
(21, '西湖龙井 8克*3袋', 99, '0.01', 998, NULL, 6, '/images/product-tea@3.png', NULL, NULL, NULL),
(22, '梅兰清花糕 1个', 99, '0.01', 997, NULL, 5, '/images/product-cake-a@3.png', NULL, NULL, NULL),
(23, '清凉薄荷糕 1个', 99, '0.01', 998, NULL, 5, '/images/product-cake-a@4.png', NULL, NULL, NULL),
(25, '小明的妙脆角 120克', 99, '0.01', 999, NULL, 5, '/images/product-cake@1.png', NULL, NULL, NULL),
(26, '红衣青瓜 混搭160克', 99, '0.01', 999, NULL, 2, '/images/product-dryfruit@8.png', NULL, NULL, NULL),
(27, '锈色瓜子 100克', 99, '0.01', 998, NULL, 4, '/images/product-fry@4.png', NULL, NULL, NULL),
(28, '春泥花生 200克', 99, '0.01', 999, NULL, 4, '/images/product-fry@5.png', NULL, NULL, NULL),
(29, '冰心鸡蛋 2个', 99, '0.01', 999, NULL, 7, '/images/product-rice@5.png', NULL, NULL, NULL),
(30, '八宝莲子 200克', 99, '0.01', 999, NULL, 7, '/images/product-rice@6.png', NULL, NULL, NULL),
(31, '深涧木耳 78克', 99, '0.01', 999, NULL, 7, '/images/product-rice@7.png', NULL, NULL, NULL),
(32, '土豆 半斤', 99, '0.01', 999, NULL, 3, '/images/product-vg@4.png', NULL, NULL, NULL),
(33, '青椒 半斤', 99, '0.01', 999, NULL, 3, '/images/product-vg@5.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(55) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '图片排序序号',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `product_image`
--

INSERT INTO `product_image` (`id`, `img_url`, `delete_time`, `order`, `product_id`, `create_time`, `update_time`) VALUES
(4, '/images/detail-1@1-dryfruit.png', NULL, 1, 11, NULL, NULL),
(5, '/images/detail-2@1-dryfruit.png', NULL, 2, 11, NULL, NULL),
(6, '/images/detail-3@1-dryfruit.png', NULL, 3, 11, NULL, NULL),
(7, '/images/detail-4@1-dryfruit.png', NULL, 4, 11, NULL, NULL),
(8, '/images/detail-5@1-dryfruit.png', NULL, 5, 11, NULL, NULL),
(9, '/images/detail-6@1-dryfruit.png', NULL, 6, 11, NULL, NULL),
(10, '/images/detail-7@1-dryfruit.png', NULL, 7, 11, NULL, NULL),
(11, '/images/detail-8@1-dryfruit.png', NULL, 8, 11, NULL, NULL),
(12, '/images/detail-9@1-dryfruit.png', NULL, 9, 11, NULL, NULL),
(13, '/images/detail-11@1-dryfruit.png', NULL, 11, 11, NULL, NULL),
(14, '/images/detail-10@1-dryfruit.png', NULL, 10, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_property`
--

CREATE TABLE IF NOT EXISTS `product_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) NOT NULL COMMENT '详情属性',
  `product_id` int(11) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `product_property`
--

INSERT INTO `product_property` (`id`, `name`, `detail`, `product_id`, `delete_time`, `update_time`, `create_time`) VALUES
(1, '品名', '杨梅', 11, NULL, NULL, NULL),
(2, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, NULL, NULL, NULL),
(3, '产地', '火星', 11, NULL, NULL, NULL),
(4, '保质期', '180天', 11, NULL, NULL, NULL),
(5, '品名', '梨子', 2, NULL, NULL, NULL),
(6, '产地', '金星', 2, NULL, NULL, NULL),
(7, '净含量', '100g', 2, NULL, NULL, NULL),
(8, '保质期', '10天', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '专题名称',
  `description` varchar(255) DEFAULT NULL COMMENT '专题描述',
  `topic_img_id` int(11) NOT NULL COMMENT '主题图，外键',
  `delete_time` int(11) DEFAULT NULL,
  `head_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='主题信息表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `theme`
--

INSERT INTO `theme` (`id`, `name`, `description`, `topic_img_id`, `delete_time`, `head_img_id`, `update_time`, `create_time`) VALUES
(1, '专题栏位一', '美味水果世界', 16, NULL, 49, NULL, NULL),
(2, '专题栏位二', '新品推荐', 17, NULL, 50, NULL, NULL),
(3, '专题栏位三', '做个干物女', 18, NULL, 18, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `theme_product`
--

CREATE TABLE IF NOT EXISTS `theme_product` (
  `theme_id` int(11) NOT NULL COMMENT '主题外键',
  `product_id` int(11) NOT NULL COMMENT '商品外键',
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`theme_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题所包含的商品';

--
-- 转存表中的数据 `theme_product`
--

INSERT INTO `theme_product` (`theme_id`, `product_id`, `create_time`, `delete_time`, `update_time`) VALUES
(1, 2, NULL, NULL, NULL),
(1, 5, NULL, NULL, NULL),
(1, 8, NULL, NULL, NULL),
(1, 10, NULL, NULL, NULL),
(1, 12, NULL, NULL, NULL),
(2, 1, NULL, NULL, NULL),
(2, 2, NULL, NULL, NULL),
(2, 3, NULL, NULL, NULL),
(2, 5, NULL, NULL, NULL),
(2, 6, NULL, NULL, NULL),
(2, 16, NULL, NULL, NULL),
(2, 33, NULL, NULL, NULL),
(3, 15, NULL, NULL, NULL),
(3, 18, NULL, NULL, NULL),
(3, 19, NULL, NULL, NULL),
(3, 27, NULL, NULL, NULL),
(3, 30, NULL, NULL, NULL),
(3, 31, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `third_app`
--

CREATE TABLE IF NOT EXISTS `third_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) NOT NULL COMMENT '应用权限',
  `scope_description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `delete_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='访问API的各应用账号密码表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `third_app`
--

INSERT INTO `third_app` (`id`, `app_id`, `app_secret`, `app_description`, `scope`, `scope_description`, `delete_time`, `update_time`, `create_time`) VALUES
(1, 'starcraft', '777*777', 'CMS', '32', 'Super', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `extend` varchar(255) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=59 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `openid`, `nickname`, `extend`, `delete_time`, `create_time`, `update_time`) VALUES
(58, 'oMh7y5OyeL6No-tuIUNm1G7NZnbE', NULL, NULL, NULL, 1538484055, 1538484055);

-- --------------------------------------------------------

--
-- 表的结构 `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `province` varchar(20) DEFAULT NULL COMMENT '省',
  `city` varchar(20) DEFAULT NULL COMMENT '市',
  `country` varchar(20) DEFAULT NULL COMMENT '区',
  `detail` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `user_address`
--

INSERT INTO `user_address` (`id`, `name`, `mobile`, `province`, `city`, `country`, `detail`, `delete_time`, `user_id`, `update_time`, `create_time`) VALUES
(35, 'John Doe', '020-81167888', 'Guangdong Sheng', 'Guangzhou Shi', 'Haizhu Qu', '397 Xingang Middle Rd, KeCun', NULL, 58, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
