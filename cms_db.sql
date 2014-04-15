-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 15, 2014 at 01:17 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `loginattempts`
--

CREATE TABLE IF NOT EXISTS `loginattempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_category` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `news_date` date NOT NULL,
  `summary` varchar(1024) NOT NULL,
  `content` text NOT NULL,
  `picture` varchar(120) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_category`, `title`, `news_date`, `summary`, `content`, `picture`, `active`) VALUES
(1, 2, 'Arsenal and Wenger Avoid Nightmare and Advance to F.A. Cup Final', '2014-04-12', 'Arsne Wenger paced. He fidgeted. He squatted then rose then squatted. When he finally stood still, he pulled at the belt loops of his natty suit. For more than two hours Saturday at Wembley Stadium, Wenger looked altogether uncomfortable.\r\n\r\nIt was as if he knew what was happening. As if he had seen it happen before. And he had: In the nine years since Arsenal last won a trophy, there have been many near-misses and almosts and cant-believe-its for Wenger, the clubs longtime manager.', 'Arsne Wenger paced. He fidgeted. He squatted then rose then squatted. When he finally stood still, he pulled at the belt loops of his natty suit. For more than two hours Saturday at Wembley Stadium, Wenger looked altogether uncomfortable.\r\n\r\nIt was as if he knew what was happening. As if he had seen it happen before. And he had: In the nine years since Arsenal last won a trophy, there have been many near-misses and almosts and cant-believe-its for Wenger, the clubs longtime manager.\r\n\r\nThis had all the trappings of another. But with a late goal from Per Mertesacker and a grand performance from goalkeeper Lukasz Fabianski, Arsenal avoided yet one more collapse and advanced  barely  to the F.A. Cup final with a 4-2 penalty shootout victory over Wigan after a 1-1 draw. The Gunners will face either Sheffield United or Hull City at Wembley on May 17.\r\n\r\nEveryone expected us out in front, Wenger said afterward. This was a Cup game; the difference between winning and losing is very small.\r\n\r\nWhoever the opponent is in the final, Arsenal will surely be favored again, though history has shown those situations are no bargain for the club. Arsenals last trip to a Wembley final was in 2011, when most expected it to coolly dispatch Birmingham City and win the League Cup. Instead, Wenger and his players were stunned by a late goal and lost, 2-1.\r\n\r\nA defeat to the Latics on Saturday would not have been quite that stunning  they are, it must be said, the defending champions  but Arsenal is a division above Wigan all the same, and the F.A. Cup has taken on a particularly pointed meaning for the Gunners this season.\r\n\r\nTo many observers, the quest to end Arsenals drought has become a referendum on Wengers status with the club after 18 years of his being in charge. Hopes of winning the Premier League title are long gone, and even Arsenals top-four Champions League place is in doubt as Everton has, for the moment, overtaken it. For Wenger, in other words, the F.A. Cup is all that is left.\r\n\r\nPerhaps that was why he looked particularly agitated after an hour. That was when Mertesacker, the gangly defender, woefully mistimed a tackle in the penalty area and gave Wigan a penalty kick. Jordi Gmez blasted the shot home in front of the blue end of the stadium, and a sense of dread settled in among the Arsenal faithful. For the most part, the team looked lethargic and unimaginative, while the Wigan players, buoyed by their lead, settled back to defend.\r\n\r\nIm absolutely proud of what they put in, Wigan Manager Uwe Rsler said.\r\n\r\nFaced with elimination, the Gunners responded. They peppered Wigan goalkeeper Scott Carson  who was stellar in keeping his team in it  and were denied by the post when Bacary Sagnas header in the 81st minute bounced away. Watching from the sideline, Wenger spun back in disbelief.\r\n\r\nA minute later, though, he pumped his fist excitedly as Mertesacker atoned for his miscue by nodding the ball into the net after Alex Oxlade-Chamberlain slashed it across the goal. Even Fabianski joined in the histrionics, sprinting from the other end of the field to slide along the turf and embrace his teammates.\r\n\r\nAfter 30 minutes of extra time went scoreless  Oxlade-Chamberlain had the best chance when his thunderous blast came back off the crossbar  the shootout tilted quickly after Fabianski saved Wigans first two penalties. Santi Cazorlas shot ultimately sealed the victory, and the Arsenal players danced around the field in celebration.\r\n\r\nWenger was more placid, shaking hands with Rsler before heading into the tunnel. Asked afterward how he felt, Wenger shrugged.\r\n\r\nRelieved, he said.', 'arsenal.jpg', 1),
(2, 4, '10 terrific things you can do with the Galaxy S5 but not the iPhone 5s', '2014-04-13', 'In the past, Samsung has had problems with what we here at BGR often refer to as feature spam. As was most painfully apparent in last years Galaxy S4, the company developed the habit of stuffing as many gimmicky new features as possible into its phones, thinking that all this clutter might appeal to a wider range of users. Samsung clearly recognized the problem beginning with last years Galaxy Note 3, however, and it has since shifted its focus to refinement and the addition of a few new features to each device that are actually useful.', 'With the Galaxy S5, Samsung continues that trend. In fact, many of the features the company added to the Galaxy S5 arent just useful, theyre awesome. Many are also unique, and what better way to illustrate that than by comparing the S5 to the most popular smartphone on the planet, Apples iPhone 5s.\r\n\r\nEach of these great flagship phones has advantages over the other, but theres no denying that Samsungs new smartphone packs a few nifty features that the iPhone just doesnt have. Here are 10 of our favorites:\r\n\r\nTV and component remote  Apples iPhone can be used as a remote to control certain devices like the Apple TV. Third parties have also built apps that can be used to control various devices like televisions and Blu-ray players over Wi-Fi. But the Galaxy S5 has a built-in infrared blaster that can control just about any media device on the planet that uses a standard IR remote.\r\n\r\nWatch full 1080p HD video  Though the device itself is among the most comfortable to use, the iPhones tiny screen isnt terribly good for watching videos. At least not compared to smartphones with larger displays.\r\n\r\nThe Retina display is still a beauty but no matter how you slice it, youll never be able to watch 1,920 x 1,080-pixel videos at full quality on the iPhones 1,136 x 640-pixel screen.\r\n\r\nExpand the memory  As cheap as microSD cards are these days, its more annoying now than it has ever been before when gadget makers force consumers to cough up an extra $100 or $200 for a smartphone with more storage.\r\n\r\nApple charges a $200 premium for an extra 48GB of storage on the iPhone, bumping space up to 64GB from 16GB. Meanwhile, a brand-name microSD card with 64GB of storage costs less than $50.\r\n\r\nThankfully, Samsungs Galaxy S5 includes a microSD slot and microSDXC support, so it will work with cards up to 128GB in size.\r\n\r\nSwap the battery  The iPhone 5s has pretty good battery life compared to some phones, but theres still no way it will last through a full day of very heavy use. The Galaxy S5 might not make it through a crazy day either, but at least S5 users have the option of carrying a spare battery to pop in when their main battery gets too low.\r\n\r\nA portable battery charger accomplishes the same thing of course, but with added bulk.\r\n\r\nSurvive being submerged in water  The Galaxy S5 can survive a spill or a dunk with no problem. In fact, its certified to be water-resistant for 30 minutes at a depth of up to three feet, so you can even take pictures underwater if you want.\r\n\r\nIf you drop your iPhone 5s in three feet of water, prepare to buy a new iPhone 5s.\r\n\r\nMake secure payments with your fingerprint  The iPhone 5s has a fingerprint scanner, but its utility is severely limited by the fact that, well, Apple doesnt let anyone do anything interesting with it. Touch ID can unlock the phone and authenticate App Store purchases, but thats it.\r\n\r\nSamsungs fingerprint scanner technology might not be as smooth as Apples, but a deal with PayPal means you can actually use it to pay for goods. Whats more, upcoming deals will further expand the scanners utility since Samsung is open to working with partners.\r\n\r\nShoot 4K video  1080p is so 2013. This year is all about 4K.\r\n\r\nOk, not really.\r\n\r\n4K video playback is still confined to pricier high-end TVs and monitors, but Samsungs Galaxy S5 is future-proof in that regard. In the coming year or two when the prices of 4K devices really start to drop, S5 users will have plenty of homemade content ready to go.\r\n\r\nMonitor your heart rate  There are a bunch of third-party apps that can use the camera on the iPhone to monitor your heart rate, but those solutions arent quite as comprehensive as the dedicated heart rate monitor on the Galaxy S5.\r\n\r\nWhile heart rate monitoring and data is isolated to the third-party apps in question on the iPhone, the monitor on the Galaxy S5 can be used across a variety of apps  and not just Samsungs own apps. Third-party software can also access the monitor, so youll be able to log heart rate data in your workout app of choice, assuming the developer integrates it.\r\n\r\nRestrict access when sharing the phone with a child  Nothing quiets down an annoying kid faster than a smartphone game, but the last thing you want is for an erroneous tap to lead to an awkward exchange during which youre forced to explain the 47 bathroom selfies you took that morning.\r\n\r\nWith the iPhone, your only choice is to stop taking bathroom selfies. Heaven forbid.\r\n\r\nThe Galaxy S5, however, includes a special Kids Mode that limits access to apps you designate as kid-friendly. After all, nothing should stand between you and your bathroom selfies.\r\n\r\nLast for a week on a single charge  The fact that you have the option to carry an extra battery with you is great, but Galaxy S5 owners might never actually have to use an extra battery.\r\n\r\nWhen the charge on the S5 starts to get low, users can enable what Samsung calls ultra power saving mode. When enabled, this new feature cuts the colors on the display to just black and white, limits background processes, kills background data, and restricts access to most apps.\r\n\r\nWith this new power saving mode enabled, the Galaxy S5 will last for 24 hours on standby with a charge of just 10%. With a fully charged battery, it would provide more than a week of standby time.', 'galaxy.jpg', 1),
(3, 14, 'Strong quake hits near Solomon Islands; tsunami warning cancelled', '2014-04-11', 'A powerful magnitude 7.6 earthquake struck near the Solomon Islands on Sunday morning, triggering a tsunami warning that was later cancelled, according to U.S. government agencies, and there were no immediate reports of damage.', 'The quake was centered 100 km (60 miles) south of Kira Kira on the island of Makira at a depth of 29 km (18 miles), according to the U.S. Geological Survey.\r\n\r\n"So far we have received no reports of damage," said Constable Taylor Fugo from Kira Kira police. "The people responded very well to the (tsunami) warning. They all went up the hills and have been watching and waiting for advice."\r\n\r\nA tsunami warning for the Solomon Islands, Papua New Guinea and Vanuatu was cancelled after only very small tsunami wave activity, just a couple of centimetres, had been measured at two reading stations near the epicentre, the Pacific Tsunami Warning Center said.\r\n\r\nAn earlier tsunami watch for Fiji, Australia, Indonesia and nearby areas was cancelled after the earthquake was revised down from its original magnitude of 8.3.\r\n\r\nA series of aftershocks followed the quake, the strongest a magnitude 5.9, hit the region shortly afterwards, the USGS said.\r\n\r\nThe Solomon Islands straddles the so-called "Pacific Ring of Fire," a highly seismically active zone where different plates on the earth''s crust meet and create a large number of earthquakes and volcanoes.\r\n\r\nA powerful 8.0 magnitude quake in 2013 in a similar area generated a local tsunami that killed at least five people.\r\n\r\n(Reporting by Lincoln Feast in Sydney; Editing by David Gregorio and Lisa Shumaker)', 'island.jpg', 1),
(4, 3, 'Official: Health Secretary Kathleen Sebelius resigning', '2014-04-10', 'Kathleen Sebelius -- who weathered heavy criticism over the flaw-filled launch of the Obamacare website, then saw the program through as it topped a major milestone -- is resigning as secretary of the Department of Health and Human Services, a White House official said Thursday.', 'Kathleen Sebelius -- who weathered heavy criticism over the flaw-filled launch of the Obamacare website, then saw the program through as it topped a major milestone -- is resigning as secretary of the Department of Health and Human Services, a White House official said Thursday.\r\nPresident Barack Obama intends to nominate Sylvia Mathews Burwell, current director of the Office of Management and Budget, to replace Sebelius, according to the official.\r\nA former Kansas governor and, before that, state insurance commissioner, Sebelius was sworn in as HHS secretary in April 2009.\r\n Obama announces Sebelius'' resignation\r\nHer time as head of the federal health agency coincided with the passage and implementation of the Affordable Care Act, the bill often referred to as Obamacare.\r\nSebelius came under fire last fall for the rocky rollout of HealthCare.gov, the website central to the new law''s implementation.\r\nThat included being subject of a "Saturday Night Live" parody and talk show one-liners panning her. Republicans in Congress were especially critical of what they saw as her lack of leadership shepherding through what they saw as an ill-conceived, ill-advised law. Wyoming Sen. John Barrasso went so far as to characterize her last October as the "laughingstock of America."\r\nBut Sebelius, 65, held on to her job, insisting America shouldn''t abandon the legislation and all that it hopes to achieve.\r\nIn an interview with CNN''s Sanjay Gupta, she admitted that Obama didn''t know of the website''s many technical problems until "the first couple of days" after it went live October 1.\r\n"There are people in this country who have waited for decades for affordable health coverage for themselves and their families," Sebelius said, explaining why the website''s launch wasn''t pushed back despite anticipated problems. "...So waiting is not really an option."\r\nThe website''s performance did improve significantly, prompting the calls for her job to die down as well. Earlier this month, in a letter to department employees, Sebelius reflected on Obamacare enrollment exceeding its target of 7 million as evidence of "the progress we''ve made, together," while stating "our work is far from over."\r\n"I know that this law has been at the center of much debate and discourse in Washington, but what this enrollment demonstrates is that the Affordable Care Act is working and much needed," she said in the note.\r\nObamacare hits 7.5 million sign-ups, Sebelius says\r\nAccording to senior Obama administration officials, Sebelius told the President in early March that she thought the enrollment period would end well and, after that, she planned to step down. Even granted the initial uproar over the website, her decision to resign was on her own accord, the officials said.\r\nOne White House official praised her overseeing "one of the most consequential initiatives of this administration" as well as her efforts to "improve children''s health, expand mental health care, reduce racial and ethnic disparities, bring us closer to the first AIDS-free generation and promote women''s health."\r\n"The President is deeply grateful for her service," the official said.\r\nHouse Majority Leader Eric Cantor, a Virginia Republican, thanked Sebelius for her five years in the federal government -- while taking at a swipe at the legislation she is most closely associated with.\r\n"She had an impossible task: nobody can make Obamacare work," Cantor tweeted.\r\nOther Republicans weren''t that gracious. Rep. Marsha Blackburn of Tennessee said Sebelius'' departure "has been a long time coming after a litany of failures and total mismanagement."\r\nNot surprisingly, given the sharp partisan divide that defines the Obamacare debate, Democrats came to her support. House Minority Leader Nancy Pelosi commended the outgoing health secretary for her dedication "to a single purpose: to make health care a right, not a privilege, for all Americans."\r\n"When all is said and done," tweeted ex-Obama senior adviser David Axelrod, "Sebelius has lots to be proud of, including the surprisingly strong finish on exchange signups after rocky start."\r\nSebelius is expected to be by the President''s side at 11 a.m. Friday when he announces Burwell''s nomination, according to a White House official.\r\nBurwell, 48, was confirmed to her current Cabinet-rank position in April 2013. She came to the White House from her spot atop the Walmart Foundation -- the giant retail chain''s charitable organization which, according to its website, donated nearly $1 billion to causes worldwide in 2011.\r\nPrior to that, Burwell worked for the Bill and Melinda Gates Foundation and in President Bill Clinton''s administration under then-Treasury Secretary Robert Rubin.', 'resigns.jpg', 1),
(5, 4, 'kljn', '2014-04-17', 'kjnkl', 'lkkjlk', 'Lighthouse.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_category`
--

CREATE TABLE IF NOT EXISTS `news_category` (
  `news_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  PRIMARY KEY (`news_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `news_category`
--

INSERT INTO `news_category` (`news_category_id`, `category_name`) VALUES
(2, 'Sports'),
(3, 'Politics'),
(4, 'Technology'),
(14, 'Wheather');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_by`, `created_on`, `last_login`, `active`) VALUES
(1, '', 'admin@cms.com', '265eb7242d201f0dd1c8c3ee2ba5d75184adb3cb', NULL, 'admin@cms.com', NULL, '11defedd58ba64834b56069939e67e2b06088705', 1386400937, NULL, NULL, 1386367627, 1397457151, 1),
(4, '\0\0', 'test@test.com', 'e2c9152140d574f74953f23602fca176aafe2646', NULL, 'test@test.com', NULL, NULL, NULL, NULL, NULL, 1397025630, 1397025647, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usersgroups`
--

CREATE TABLE IF NOT EXISTS `usersgroups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_group_id_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `usersgroups`
--

INSERT INTO `usersgroups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
