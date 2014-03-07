-- データベースの初期化 --
drop table if exists posts;
drop table if exists comments;
drop table if exists accounts;
drop table if exists studylogs;
drop table if exists studytimes;
drop table if exists targets;
drop table if exists mytargets;
drop table if exists friends;
drop table if exists todo;
drop table if exists demands;



-- テーブルの作成 --
create table accounts (
	id int auto_increment primary key,
	mailaddress varchar(255) not null,
	pass varchar(255) not null,
	name varchar(100) not null,
	introduction varchar(3000),
	sex char(1),
	birthday date,
	studylog_count int,
	img_ext varchar(30),
	entry_flg char(1) default '0'
);
create table posts (
	id int auto_increment primary key,
	account_id int,
	post_datetime timestamp,
	text varchar(3000),
	img_ext varchar(10),
	tmp int
);
create table comments (
	account_id int,
	post_datetime timestamp,
	post_id int,
	text varchar(3000) not null,
	primary key(account_id, post_datetime)
);
create table targets (
	id int auto_increment primary key,
	name varchar(50) not null,
	date date not null
);
create table mytargets (
	account_id int,
	target_id int,
	primary key(account_id, target_id)
);
create table studylogs (
	id int auto_increment primary key,
	account_id int,
	date date,
	text varchar(3000)
);
create table studytimes (
	studylog_id int,
	target_id int,
	time int default 0,
	primary key(studylog_id, target_id)
);
create table friends (
	id int auto_increment primary key,
	my_id int,
	account_id int
);
create table todo (
	id int auto_increment primary key,
	account_id int,
	date date,
	target_id int,
	text varchar(1000),
	done char(1) default '0',
	tmp int
);
create table demands (
	id int auto_increment,
	account_id int not null,
	qname varchar(100) not null,
	done char(1) default '0',
	primary key (id, qname)
);



-- データ挿入 --
insert into accounts values(1,'dammy00@gmail.com','aG9nZWhvZ2U=','今枝稔晴','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-20',56,'.jpg','1');
insert into accounts values(2,'dammy01@gmail.com','aG9nZWhvZ2U=','鈴木一郎','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-21',56,'.jpg','1');
insert into accounts values(3,'dammy02@gmail.com','aG9nZWhvZ2U=','山田太郎','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-22',56,'.jpg','1');
insert into accounts values(4,'dammy03@gmail.com','aG9nZWhvZ2U=','山田花子','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','1','1990-04-23',56,'.jpg','1');
insert into accounts values(5,'dammy04@gmail.com','aG9nZWhvZ2U=','藤森良','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-24',56,'.jpg','1');
insert into accounts values(6,'dammy05@gmail.com','aG9nZWhvZ2U=','加藤大','名古屋に住む専門学校生です。\nIT技術者になるべく、日々勉強しています。\n\n一緒に合格を目指しましょう！','0','1990-04-25',56,'.jpg','1');



insert into posts values(1,1,'2013-08-24 15:59:00','今日はセキュリティを勉強しました。',null,null);
insert into posts values(2,1,'2013-08-24 15:59:01','今日はセキュリティを勉強しました。',null,null);
insert into posts values(3,1,'2013-08-24 15:59:02','今日はセキュリティを勉強しました。',null,null);
insert into posts values(4,1,'2013-08-24 15:59:03','今日はセキュリティを勉強しました。',null,null);
insert into posts values(5,1,'2013-08-24 15:59:04','今日はセキュリティを勉強しました。',null,null);
insert into posts values(6,1,'2013-08-24 15:59:05','今日はセキュリティを勉強しました。',null,null);
insert into posts values(7,1,'2013-08-24 15:59:06','今日はセキュリティを勉強しました。',null,null);
insert into posts values(8,1,'2013-08-24 15:59:07','今日はセキュリティを勉強しました。',null,null);
insert into posts values(9,1,'2013-08-24 15:59:08','今日はセキュリティを勉強しました。',null,null);
insert into posts values(10,1,'2013-08-24 15:59:09','今日はセキュリティを勉強しました。',null,null);
insert into posts values(11,1,'2013-08-24 15:59:10','今日はセキュリティを勉強しました。',null,null);
insert into posts values(12,1,'2013-08-24 15:59:11','今日はセキュリティを勉強しました。',null,null);
insert into posts values(13,1,'2013-08-24 15:59:12','今日はセキュリティを勉強しました。',null,null);
insert into posts values(14,1,'2013-08-24 15:59:13','今日はセキュリティを勉強しました。',null,null);
insert into posts values(15,1,'2013-08-24 15:59:14','今日はセキュリティを勉強しました。',null,null);
insert into posts values(16,1,'2013-08-24 15:59:15','今日はセキュリティを勉強しました。',null,null);
insert into posts values(17,1,'2013-08-24 15:59:16','今日はセキュリティを勉強しました。',null,null);
insert into posts values(18,1,'2013-08-24 15:59:17','今日はセキュリティを勉強しました。',null,null);
insert into posts values(19,1,'2013-08-24 15:59:18','今日はセキュリティを勉強しました。',null,null);
insert into posts values(20,1,'2013-08-24 15:59:19','今日はセキュリティを勉強しました。',null,null);
insert into posts values(21,1,'2013-08-24 15:59:20','今日はセキュリティを勉強しました。',null,null);
insert into posts values(22,1,'2013-08-24 15:59:21','今日はセキュリティを勉強しました。',null,null);
insert into posts values(23,1,'2013-08-24 15:59:22','今日はセキュリティを勉強しました。',null,null);
insert into posts values(24,1,'2013-08-24 15:59:23','今日はセキュリティを勉強しました。',null,null);
insert into posts values(25,1,'2013-08-24 15:59:24','今日はセキュリティを勉強しました。',null,null);
insert into posts values(26,1,'2013-08-24 15:59:25','今日はセキュリティを勉強しました。',null,null);
insert into posts values(27,1,'2013-08-24 15:59:26','今日はセキュリティを勉強しました。',null,null);
insert into posts values(28,1,'2013-08-24 15:59:27','今日はセキュリティを勉強しました。',null,null);
insert into posts values(29,1,'2013-08-24 15:59:28','今日はセキュリティを勉強しました。',null,null);
insert into posts values(30,1,'2013-08-24 15:59:29','今日はセキュリティを勉強しました。',null,null);
insert into posts values(31,1,'2013-08-24 15:59:30','今日はセキュリティを勉強しました。',null,null);
insert into posts values(32,1,'2013-08-24 15:59:31','今日はセキュリティを勉強しました。',null,null);
insert into posts values(33,1,'2013-08-24 15:59:32','今日はセキュリティを勉強しました。',null,null);
insert into posts values(34,1,'2013-08-24 15:59:33','今日はセキュリティを勉強しました。',null,null);
insert into posts values(35,1,'2013-08-24 15:59:34','今日はセキュリティを勉強しました。',null,null);
insert into posts values(36,1,'2013-08-24 15:59:35','今日はセキュリティを勉強しました。',null,null);
insert into posts values(37,1,'2013-08-24 15:59:36','今日はセキュリティを勉強しました。',null,null);
insert into posts values(38,1,'2013-08-24 15:59:37','今日はセキュリティを勉強しました。',null,null);
insert into posts values(39,1,'2013-08-24 15:59:38','今日はセキュリティを勉強しました。',null,null);
insert into posts values(40,1,'2013-08-24 15:59:39','今日はセキュリティを勉強しました。',null,null);
insert into posts values(41,1,'2013-08-24 15:59:40','今日はセキュリティを勉強しました。',null,null);
insert into posts values(42,1,'2013-08-24 15:59:41','今日はセキュリティを勉強しました。',null,null);
insert into posts values(43,1,'2013-08-24 15:59:42','今日はセキュリティを勉強しました。',null,null);
insert into posts values(44,1,'2013-08-24 15:59:43','今日はセキュリティを勉強しました。',null,null);
insert into posts values(45,1,'2013-08-24 15:59:44','今日はセキュリティを勉強しました。',null,null);
insert into posts values(46,1,'2013-08-24 15:59:45','今日はセキュリティを勉強しました。',null,null);
insert into posts values(47,4,'2013-08-24 15:59:46','試験まであと2日ですね。体調には気をつけてすごそう。',null,null);
insert into posts values(48,4,'2013-08-24 15:59:47','今日も頑張りましょう！',null,null);
insert into posts values(49,2,'2013-08-24 15:59:48','今日はセキュリティを勉強しました。',null,null);
insert into posts values(50,5,'2013-08-24 15:59:49','模試の結果はさんざんだった。...気分転換しよ',null,null);
insert into posts values(51,4,'2013-08-24 15:59:50','合格しましたーーー！',null,null);
insert into posts values(52,1,'2013-08-24 15:59:51','今日はセキュリティを勉強しました。',null,null);
insert into posts values(53,3,'2013-08-24 15:59:52','僕も合格しました！',null,null);



insert into comments values(1,'2013-08-24 15:59:00',1,'こんにちは、今枝稔晴です！00000000000001');
-- insert into comments values(1,'2013-08-24 15:59:01',1,'こんにちは、今枝稔晴です！00000000000002');
-- insert into comments values(1,'2013-08-24 15:59:02',1,'こんにちは、今枝稔晴です！00000000000003');
-- insert into comments values(1,'2013-08-24 15:59:03',4,'こんにちは、今枝稔晴です！00000000000004');
-- insert into comments values(1,'2013-08-24 15:59:04',5,'こんにちは、今枝稔晴です！00000000000005');
-- insert into comments values(1,'2013-08-24 15:59:05',5,'こんにちは、今枝稔晴です！00000000000006');
-- insert into comments values(1,'2013-08-24 15:59:06',7,'こんにちは、今枝稔晴です！00000000000007');
-- insert into comments values(1,'2013-08-24 15:59:07',8,'こんにちは、今枝稔晴です！00000000000008');
-- insert into comments values(1,'2013-08-24 15:59:08',9,'こんにちは、今枝稔晴です！00000000000009');
-- insert into comments values(1,'2013-08-24 15:59:09',10,'こんにちは、今枝稔晴です！00000000000010');
-- insert into comments values(1,'2013-08-24 15:59:10',11,'こんにちは、今枝稔晴です！00000000000011');
-- insert into comments values(1,'2013-08-24 15:59:11',12,'こんにちは、今枝稔晴です！00000000000012');
-- insert into comments values(1,'2013-08-24 15:59:12',13,'こんにちは、今枝稔晴です！00000000000013');
-- insert into comments values(1,'2013-08-24 15:59:13',14,'こんにちは、今枝稔晴です！00000000000014');
-- insert into comments values(1,'2013-08-24 15:59:14',15,'こんにちは、今枝稔晴です！00000000000015');
-- insert into comments values(1,'2013-08-24 15:59:15',16,'こんにちは、今枝稔晴です！00000000000016');
-- insert into comments values(1,'2013-08-24 15:59:16',17,'こんにちは、今枝稔晴です！00000000000017');
-- insert into comments values(1,'2013-08-24 15:59:17',18,'こんにちは、今枝稔晴です！00000000000018');
-- insert into comments values(1,'2013-08-24 15:59:18',19,'こんにちは、今枝稔晴です！00000000000019');
-- insert into comments values(1,'2013-08-24 15:59:19',20,'こんにちは、今枝稔晴です！00000000000020');
-- insert into comments values(1,'2013-08-24 15:59:20',21,'こんにちは、今枝稔晴です！00000000000021');
-- insert into comments values(1,'2013-08-24 15:59:21',22,'こんにちは、今枝稔晴です！00000000000022');
-- insert into comments values(1,'2013-08-24 15:59:22',23,'こんにちは、今枝稔晴です！00000000000023');
-- insert into comments values(1,'2013-08-24 15:59:23',24,'こんにちは、今枝稔晴です！00000000000024');
-- insert into comments values(1,'2013-08-24 15:59:24',25,'こんにちは、今枝稔晴です！00000000000025');
-- insert into comments values(1,'2013-08-24 15:59:25',26,'こんにちは、今枝稔晴です！00000000000026');
-- insert into comments values(1,'2013-08-24 15:59:26',27,'こんにちは、今枝稔晴です！00000000000027');
-- insert into comments values(1,'2013-08-24 15:59:27',28,'こんにちは、今枝稔晴です！00000000000028');
-- insert into comments values(1,'2013-08-24 15:59:28',29,'こんにちは、今枝稔晴です！00000000000029');
-- insert into comments values(1,'2013-08-24 15:59:29',30,'こんにちは、今枝稔晴です！00000000000030');
-- insert into comments values(1,'2013-08-24 15:59:30',31,'こんにちは、今枝稔晴です！00000000000031');
-- insert into comments values(1,'2013-08-24 15:59:31',32,'こんにちは、今枝稔晴です！00000000000032');
-- insert into comments values(1,'2013-08-24 15:59:32',33,'こんにちは、今枝稔晴です！00000000000033');
-- insert into comments values(1,'2013-08-24 15:59:33',34,'こんにちは、今枝稔晴です！00000000000034');
-- insert into comments values(1,'2013-08-24 15:59:34',35,'こんにちは、今枝稔晴です！00000000000035');
-- insert into comments values(1,'2013-08-24 15:59:35',36,'こんにちは、今枝稔晴です！00000000000036');
-- insert into comments values(1,'2013-08-24 15:59:36',37,'こんにちは、今枝稔晴です！00000000000037');
-- insert into comments values(1,'2013-08-24 15:59:37',38,'こんにちは、今枝稔晴です！00000000000038');
-- insert into comments values(1,'2013-08-24 15:59:38',39,'こんにちは、今枝稔晴です！00000000000039');
-- insert into comments values(1,'2013-08-24 15:59:39',40,'こんにちは、今枝稔晴です！00000000000040');
-- insert into comments values(1,'2013-08-24 15:59:40',41,'こんにちは、今枝稔晴です！00000000000041');
-- insert into comments values(1,'2013-08-24 15:59:41',42,'こんにちは、今枝稔晴です！00000000000042');
-- insert into comments values(1,'2013-08-24 15:59:42',43,'こんにちは、今枝稔晴です！00000000000043');
-- insert into comments values(1,'2013-08-24 15:59:43',44,'こんにちは、今枝稔晴です！00000000000044');
-- insert into comments values(1,'2013-08-24 15:59:44',45,'こんにちは、今枝稔晴です！00000000000045');
-- insert into comments values(1,'2013-08-24 15:59:45',46,'こんにちは、今枝稔晴です！00000000000046');
-- insert into comments values(1,'2013-08-24 15:59:46',47,'こんにちは、今枝稔晴です！00000000000047');
-- insert into comments values(1,'2013-08-24 15:59:47',48,'こんにちは、今枝稔晴です！00000000000048');
-- insert into comments values(1,'2013-08-24 15:59:48',49,'こんにちは、今枝稔晴です！00000000000049');
-- insert into comments values(1,'2013-08-24 15:59:49',51,'こんにちは、今枝稔晴です！00000000000050');
-- insert into comments values(1,'2013-08-24 15:59:50',51,'こんにちは、今枝稔晴です！00000000000051');
-- insert into comments values(1,'2013-08-24 15:59:51',52,'こんにちは、今枝稔晴です！00000000000052');
-- insert into comments values(1,'2013-08-24 15:59:52',53,'こんにちは、今枝稔晴です！00000000000053');
-- insert into comments values(1,'2013-08-24 15:59:53',55,'こんにちは、今枝稔晴です！00000000000054');
-- insert into comments values(1,'2013-08-24 15:59:54',55,'こんにちは、今枝稔晴です！00000000000055');



insert into targets values(1,'応用情報処理技術者試験','2013-10-20');
insert into targets values(2,'基本情報処理技術者試験','2013-10-20');
insert into targets values(3,'センター試験','2014-01-18');
insert into targets values(4,'簿記能力検定試験','2014-07-14');
insert into targets values(5,'TOIEC公開テスト','2014-03-16');



insert into mytargets values(1,1);
insert into mytargets values(1,2);
insert into mytargets values(2,1);
insert into mytargets values(3,1);
insert into mytargets values(4,1);
insert into mytargets values(5,1);



insert into studylogs(account_id, date, text) values(1,'2013-11-25','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-11-26','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-11-27','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-11-28','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-11-29','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-11-30','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-01','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-02','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-03','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-04','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-05','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-06','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-07','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-08','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-09','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-10','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
insert into studylogs(account_id, date, text) values(1,'2013-12-11','今日は思いの外勉強がはかどりました。明日も油断せずに学習します。');
insert into studylogs(account_id, date, text) values(2,'2013-12-11','今日は思いの外勉強がはかどりました。明日も油断せずに学習します。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-12','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-13','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-14','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-15','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-16','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-17','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');
-- insert into studylogs(account_id, date, text) values(1,'2013-12-18','昨日は途中で居眠りしてしまった。\n明日は勉強時間を有効に使いたい。');



insert into studytimes values(1,1,120);
insert into studytimes values(1,2,45);
insert into studytimes values(2,1,60);
insert into studytimes values(2,2,30);
insert into studytimes values(3,1,60);
insert into studytimes values(3,2,400);
insert into studytimes values(13,1,60);
insert into studytimes values(13,2,400);
insert into studytimes values(14,1,60);
insert into studytimes values(14,2,400);
insert into studytimes values(17,1,300);
insert into studytimes values(17,2,200);
insert into studytimes values(16,1,0);
insert into studytimes values(16,2,400);
insert into studytimes values(15,1,200);
insert into studytimes values(15,2,0);
insert into studytimes values(18,1,300);
insert into studytimes values(18,2,100);



insert into friends values(1,1,2);
insert into friends values(2,1,3);
-- insert into friends values(3,1,4);
-- insert into friends values(4,2,1);
-- insert into friends values(5,2,5);
-- insert into friends values(6,2,3);



insert into todo(account_id, date, target_id, text, done) values(1,'2013-11-25',1,'応用情報の参考書を20ページ分終わらせる','1');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-11-25',1,'応用情報の参考書を21ページ分終わらせる','1');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-11-25',1,'応用情報の参考書を22ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-11-25',1,'応用情報の参考書を23ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-11-25',2,'基本情報の参考書を24ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-11-25',2,'基本情報の参考書を25ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を26ページ分終わらせる','1');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を27ページ分終わらせる','1');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を28ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を29ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',2,'基本情報の参考書を30ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',2,'基本情報の参考書を31ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を32ページ分終わらせる','1');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を33ページ分終わらせる','1');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を34ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',1,'応用情報の参考書を35ページ分終わらせる','0');
insert into todo(account_id, date, target_id, text, done) values(1,'2013-12-08',2,'基本情報の参考書を36ページ分終わらせる','0');
