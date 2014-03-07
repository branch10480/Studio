-- MySQL dump 10.13  Distrib 5.5.29, for osx10.6 (i386)
--
-- Host: localhost    Database: toshiharu-imaeda_studio
-- ------------------------------------------------------
-- Server version	5.5.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailaddress` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `introduction` varchar(3000) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `studylog_count` int(11) DEFAULT NULL,
  `img_ext` varchar(30) DEFAULT NULL,
  `entry_flg` char(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'dammy00@gmail.com','aG9nZWhvZ2U=','今枝稔晴','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-20',56,'.jpg','1'),(2,'dammy01@gmail.com','aG9nZWhvZ2U=','鈴木一郎','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-21',56,'.jpg','1'),(3,'dammy02@gmail.com','aG9nZWhvZ2U=','山田太郎','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-22',56,'.jpg','1'),(4,'dammy03@gmail.com','aG9nZWhvZ2U=','山田花子','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','1','1990-04-23',56,'.jpg','1'),(5,'dammy04@gmail.com','aG9nZWhvZ2U=','藤森良','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-24',56,'.jpg','1'),(6,'dammy05@gmail.com','aG9nZWhvZ2U=','加藤大','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-25',56,'.jpg','1');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `account_id` int(11) NOT NULL DEFAULT '0',
  `post_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_id` int(11) DEFAULT NULL,
  `text` varchar(3000) NOT NULL,
  PRIMARY KEY (`account_id`,`post_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'2014-03-07 11:44:49',110,'私いま応用情報試験受けてますので、分からないことがあったら聞いてくださいね〜( ´∀｀)'),(1,'2014-03-07 21:59:38',121,'よろしくお願いします(^^ゞ'),(2,'2014-03-07 11:46:43',110,'はい、是非お願いします'),(3,'2014-03-07 22:01:04',121,'はい、よろしくお願いします！');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demands`
--

DROP TABLE IF EXISTS `demands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `qname` varchar(100) NOT NULL,
  `done` char(1) DEFAULT '0',
  PRIMARY KEY (`id`,`qname`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demands`
--

LOCK TABLES `demands` WRITE;
/*!40000 ALTER TABLE `demands` DISABLE KEYS */;
INSERT INTO `demands` VALUES (1,1,'ITパスポート','0'),(2,1,'ITパスポート','0');
/*!40000 ALTER TABLE `demands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `my_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (59,2,1),(63,3,2),(64,1,3),(65,3,1);
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mytargets`
--

DROP TABLE IF EXISTS `mytargets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mytargets` (
  `account_id` int(11) NOT NULL DEFAULT '0',
  `target_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_id`,`target_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mytargets`
--

LOCK TABLES `mytargets` WRITE;
/*!40000 ALTER TABLE `mytargets` DISABLE KEYS */;
INSERT INTO `mytargets` VALUES (1,5),(2,1),(3,1),(4,1),(5,1);
/*!40000 ALTER TABLE `mytargets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `post_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` varchar(3000) DEFAULT NULL,
  `img_ext` varchar(10) DEFAULT NULL,
  `tmp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (105,1,'2014-03-07 11:23:23','これから応用情報の勉強を頑張ります！',NULL,1555590676),(106,1,'2014-03-07 11:26:23','今日も1日頑張りましょう！',NULL,710136270),(107,1,'2014-03-07 11:28:13','この問題難しかった！','.jpg',1236268773),(108,1,'2014-03-07 11:36:26','さぁ、明日が国家試験本番！\r\n悔いのないように最後まで頑張りましょう( ´∀｀)',NULL,1308457983),(109,1,'2014-03-07 11:37:42','国家試験終わりました。\r\n午前は完璧。午後は部分点をどれだけもらえるかがわからない。\r\n\r\n早く通知をくださいー！！\r\n\r\nなにはともあれ皆さんお疲れ様です。',NULL,1266170875),(110,2,'2014-03-07 11:43:22','基本情報に受かることができたので、これからは応用情報対策を頑張ります。',NULL,981294034),(111,1,'2014-03-07 11:48:10','TOIECに挑戦してみようと思います。\r\n新たな挑戦です(・ω<)',NULL,1734030724),(112,1,'2014-03-07 11:50:53','ということで参考書を買ってきました！','.JPG',264044792),(113,2,'2014-03-07 11:52:40','応用情報ってまず何から勉強すればいいんだろう？\r\n基本と同じで午後に力入れるべきかな〜',NULL,1742286694),(114,1,'2014-03-07 11:56:11','TOIECの目標はまず600超え。…しょぼいって言わないでね^^;',NULL,491944033),(115,1,'2014-03-07 12:06:09','高校時代に使っていた単語帳を引っ張りだして来ました。とりあえずはこれを勉強します。','.jpg',714365880),(116,2,'2014-03-07 13:18:52','明日本屋に行くことにします。',NULL,715014502),(117,2,'2014-03-07 13:20:30','とりあえず問題集を買ってきたのでUPします！','.jpg',2136933461),(118,2,'2014-03-07 13:21:38','うう…これは想像以上に難しい。午前の勉強をしっかりやるべきかも(・・;',NULL,785579756),(119,1,'2014-03-07 13:24:17','TOIEC本番まで10日を切りました。\r\nなんか焦ってきたよ',NULL,1807819019),(120,1,'2014-03-07 21:53:15','英単語はやっぱり文章を読む中で覚えるべきですよね。\r\n最近実感中です。',NULL,1348380258),(121,3,'2014-03-07 21:55:55','今日からStudioに登録しました。\r\n皆さん、これからよろしくお願いしますm(_ _)m',NULL,1855537915),(122,3,'2014-03-07 21:58:40','基本情報が受かって本当に良かった！\r\n\r\n気を抜かずに応用情報の勉強がんばります。',NULL,1007660733),(123,1,'2014-03-07 22:04:52','おはようございます。\r\n今日も寒いですが、一日張り切って行きましょう(・ω<)',NULL,1506959668);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studylogs`
--

DROP TABLE IF EXISTS `studylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studylogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `text` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studylogs`
--

LOCK TABLES `studylogs` WRITE;
/*!40000 ALTER TABLE `studylogs` DISABLE KEYS */;
INSERT INTO `studylogs` VALUES (1,1,'2013-11-25','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(2,1,'2013-11-26','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(3,1,'2013-11-27','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(4,1,'2013-11-28','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(5,1,'2013-11-29','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(6,1,'2013-11-30','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(7,1,'2013-12-01','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(8,1,'2013-12-02','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(9,1,'2013-12-03','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(10,1,'2013-12-04','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(11,1,'2013-12-05','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(12,1,'2013-12-06','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(13,1,'2013-12-07','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(14,1,'2013-12-08','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(15,1,'2013-12-09','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(16,1,'2013-12-10','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。'),(17,1,'2013-12-11','今日は思いの外勉強がはかどりました。明日も油断せずに学習します。'),(18,2,'2013-12-11','今日は思いの外勉強がはかどりました。明日も油断せずに学習します。'),(19,2,'2014-02-13','空き時間もこまめにつかって結構勉強できたと思う。明日もこの調子で頑張るぞ！'),(20,1,'2014-02-03','頑張ったよｐ\n'),(21,4,'2014-02-03','今日は集中して勉強できた。最近風邪が流行っているので体調管理に気をつけて勉強を進めたい。'),(28,1,'2014-02-05','今日は集中して勉強できた。明日のこの調子で頑張るぞ！'),(45,1,'2014-02-06','今日はしっかりがんばった！！'),(46,2,'2014-02-18','ちょっと今日は気を抜いて1時間ほどゲームをやってしまった。明日は気を抜かずに頑張るぞ！'),(50,1,'2014-02-19','今日も頑張った！'),(51,2,'2014-02-25','今日は野球の練習でしたが、スキマ時間を有効活用できたと思います。'),(56,1,'2014-03-06','今日も頑張りました！'),(57,2,'2014-03-06','今日は居眠りした回数が多かった。しかしお陰で集中した状態で問題を解けた感じがする。'),(58,1,'2014-03-07','昼に30分仮眠をとったら午後の勉強がスムーズにすすんだ。仮眠を習慣化するといいかもしれない。'),(59,1,'2014-03-05','過去問を1年解いて思ったのは、基礎力がまだまだだということ。午前問題をしっかり対策せねば。'),(60,1,'2014-03-04','今日はたくさん勉強出来ました。明日も頑張ります。'),(61,1,'2014-03-01','今日は少しですが勉強することが出来ました。スキマ時間を有効に使えたと思います。'),(62,2,'2014-03-07','今日は忙しいながらも勉強時間をしっかり確保できた。明日もスキマ時間を有効に活用して勉強します。'),(63,2,'2014-03-05','今日はつかれた。早めに寝ます。'),(64,2,'2014-03-04','今日は勉強をたくさん出来た。睡眠は大事なんだと気付かされた一日だった。'),(65,2,'2014-03-03','良い参考書があるとモチベーションが上がるものだと実感した。明日も頑張るぞ！'),(66,1,'2014-03-02','今日は少ししか勉強できなかった。スキマ時間をもっと有効に使いたい。');
/*!40000 ALTER TABLE `studylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studytimes`
--

DROP TABLE IF EXISTS `studytimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studytimes` (
  `studylog_id` int(11) NOT NULL DEFAULT '0',
  `target_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) DEFAULT '0',
  PRIMARY KEY (`studylog_id`,`target_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studytimes`
--

LOCK TABLES `studytimes` WRITE;
/*!40000 ALTER TABLE `studytimes` DISABLE KEYS */;
INSERT INTO `studytimes` VALUES (1,1,120),(1,2,45),(2,1,60),(2,2,30),(3,1,60),(3,2,400),(13,1,60),(13,2,400),(14,1,60),(14,2,400),(15,1,200),(15,2,0),(16,1,0),(16,2,400),(17,1,300),(17,2,200),(18,1,300),(18,2,100),(19,1,360),(20,1,270),(20,2,180),(20,4,180),(20,5,150),(21,1,420),(22,1,180),(22,2,120),(22,4,0),(22,5,0),(25,1,240),(25,2,180),(25,4,150),(25,5,360),(26,1,240),(26,2,90),(26,4,330),(26,5,150),(27,1,240),(27,2,90),(27,4,150),(27,5,150),(28,1,330),(28,2,30),(28,4,30),(28,5,300),(29,1,180),(29,5,210),(30,1,300),(30,5,210),(31,1,150),(31,5,210),(32,1,60),(32,2,180),(32,5,180),(33,1,120),(33,2,240),(33,5,180),(34,1,150),(34,2,120),(34,5,90),(35,1,90),(35,2,0),(35,4,90),(35,5,120),(36,1,270),(36,2,60),(36,5,120),(37,1,120),(37,2,180),(37,5,120),(38,1,90),(38,2,0),(38,4,60),(38,5,0),(39,1,120),(39,2,90),(39,5,120),(40,1,60),(40,2,90),(40,5,120),(41,1,90),(41,2,90),(41,5,60),(42,1,120),(42,2,210),(42,5,60),(43,1,150),(43,2,150),(43,5,150),(44,1,60),(44,2,90),(44,5,150),(45,1,210),(45,2,60),(45,5,60),(46,1,180),(46,5,150),(47,1,150),(47,5,210),(48,1,210),(48,5,210),(49,1,180),(49,5,90),(50,1,270),(50,5,90),(51,1,180),(51,5,120),(52,1,120),(52,5,210),(53,1,240),(53,5,90),(54,1,90),(54,5,240),(55,1,90),(55,5,180),(56,1,120),(56,5,210),(57,1,360),(58,1,180),(58,5,180),(59,1,240),(59,5,60),(60,1,240),(60,5,120),(61,1,60),(61,5,30),(62,1,360),(63,1,150),(64,1,300),(65,1,240),(66,1,60),(66,5,30);
/*!40000 ALTER TABLE `studytimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `targets`
--

DROP TABLE IF EXISTS `targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `targets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `targets`
--

LOCK TABLES `targets` WRITE;
/*!40000 ALTER TABLE `targets` DISABLE KEYS */;
INSERT INTO `targets` VALUES (1,'応用情報処理技術者試験','2014-04-20'),(2,'基本情報処理技術者試験','2013-10-20'),(3,'センター試験','2014-01-18'),(4,'簿記能力検定試験','2014-07-14'),(5,'TOIEC公開テスト','2014-03-16');
/*!40000 ALTER TABLE `targets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo`
--

DROP TABLE IF EXISTS `todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL,
  `done` char(1) DEFAULT '0',
  `tmp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo`
--

LOCK TABLES `todo` WRITE;
/*!40000 ALTER TABLE `todo` DISABLE KEYS */;
INSERT INTO `todo` VALUES (1,1,'2013-11-25',1,'応用情報の参考書を20ページ分終わらせる','1',NULL),(2,1,'2013-11-25',1,'応用情報の参考書を21ページ分終わらせる','1',NULL),(3,1,'2013-11-25',1,'応用情報の参考書を22ページ分終わらせる','0',NULL),(4,1,'2013-11-25',1,'応用情報の参考書を23ページ分終わらせる','0',NULL),(5,1,'2013-11-25',2,'基本情報の参考書を24ページ分終わらせる','0',NULL),(6,1,'2013-11-25',2,'基本情報の参考書を25ページ分終わらせる','0',NULL),(7,1,'2013-12-08',1,'応用情報の参考書を26ページ分終わらせる','1',NULL),(8,1,'2013-12-08',1,'応用情報の参考書を27ページ分終わらせる','1',NULL),(9,1,'2013-12-08',1,'応用情報の参考書を28ページ分終わらせる','0',NULL),(10,1,'2013-12-08',1,'応用情報の参考書を29ページ分終わらせる','0',NULL),(11,1,'2013-12-08',2,'基本情報の参考書を30ページ分終わらせる','0',NULL),(12,1,'2013-12-08',2,'基本情報の参考書を31ページ分終わらせる','0',NULL),(13,1,'2013-12-08',1,'応用情報の参考書を32ページ分終わらせる','1',NULL),(14,1,'2013-12-08',1,'応用情報の参考書を33ページ分終わらせる','1',NULL),(15,1,'2013-12-08',1,'応用情報の参考書を34ページ分終わらせる','0',NULL),(16,1,'2013-12-08',1,'応用情報の参考書を35ページ分終わらせる','0',NULL),(17,1,'2013-12-08',2,'基本情報の参考書を36ページ分終わらせる','0',NULL),(18,1,'2014-01-29',4,'ほげほげ','0',767631),(19,1,'2014-02-03',1,'問題集を3ページ','1',729647),(20,1,'2014-02-03',1,'教科書読み','1',343474),(21,2,'2014-02-02',1,'問題集を3ページ進める','0',423609),(22,1,'2014-02-03',2,'やること','1',482380),(23,4,'2014-02-04',1,'問題集を10ページ進める','1',122698),(24,4,'2014-02-04',1,'機能の復習','1',693164),(26,1,'2014-02-05',1,'やること','0',486468),(44,1,'2014-02-06',1,'やること','1',66357),(45,1,'2014-02-14',1,'やること','1',665202),(46,1,'2014-02-14',1,'やること','1',838906),(47,1,'2014-02-14',1,'こここ','1',781913),(48,1,'2014-02-14',5,'きょうやること','1',541197),(49,1,'2014-02-14',5,'やることだよ','1',740634),(50,2,'2014-02-18',1,'参考書を10ページ','1',652760),(51,1,'2014-02-19',1,'やること','1',158978),(52,1,'2014-02-19',1,'やることっっっｐ','1',48705),(53,1,'2014-02-19',1,'やることととととｔ','1',911303),(54,1,'2014-02-19',5,'やること！！！！！','1',907805),(55,2,'2014-02-26',1,'応用情報の問題集を10ページ進める','1',652864),(56,1,'2014-02-26',1,'応用情報参考書を10ページ読む','0',773320),(57,1,'2014-02-26',5,'英単語を30個暗記','0',904986),(58,1,'2014-03-06',1,'やること！','1',452200),(59,2,'2014-03-06',1,'インフォテックサーブの特別講義の復習','0',781508),(60,2,'2014-03-06',1,'問題集5ページ進める','0',252526),(61,1,'2014-03-07',1,'基本分野の復習','0',122354),(62,1,'2014-03-07',1,'教科書の流し読み','0',545253),(63,1,'2014-03-05',1,'参考書を30ページ進める','0',795730),(64,1,'2014-03-05',1,'過去問1年分','0',859820),(65,1,'2014-03-04',1,'参考書よみ','1',808638),(66,1,'2014-03-04',1,'ノート書き写し','1',177524),(67,1,'2014-03-04',1,'問題集10ページ','1',774677),(68,1,'2014-03-01',1,'参考書読み','1',311874),(69,1,'2014-03-01',5,'単語を30個覚える','1',554803),(70,2,'2014-03-07',1,'参考書を10ページ読む','1',580169),(71,2,'2014-03-07',1,'問題集1年分','1',503944),(72,2,'2014-03-05',1,'参考書を読む','1',329194),(73,2,'2014-03-04',1,'過去問を１年分（午前）','1',203558),(74,2,'2014-03-04',1,'過去問を１年分（午後）','1',148778),(75,2,'2014-03-03',1,'一問一答問題集を買ってくる','1',594108),(76,2,'2014-03-03',1,'買ってきた問題集を30ページ進める','1',622628),(77,1,'2014-03-02',1,'問題集を10ページ進める','1',790488);
/*!40000 ALTER TABLE `todo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-08  7:17:10
