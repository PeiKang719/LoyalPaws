-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 11:35 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loyalpaws`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBreedByType` (IN `offset` INT(3), IN `records_per_page` INT(2), IN `breed_type` VARCHAR(10))   BEGIN
 SELECT * FROM breed 
WHERE type = breed_type ORDER BY 
name LIMIT offset, records_per_page;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOrganization` (IN `offset` INT(3), IN `records_per_page` INT(2))   BEGIN
 SELECT * FROM 
organization ORDER BY oname LIMIT 
offset, records_per_page;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `username`, `password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `adopter`
--

CREATE TABLE `adopter` (
  `adopterID` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `state` varchar(30) NOT NULL,
  `area` varchar(40) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adopter`
--

INSERT INTO `adopter` (`adopterID`, `username`, `password`, `firstName`, `lastName`, `dob`, `state`, `area`, `phone`, `email`, `image`) VALUES
(1, 'benjamin', '202cb962ac59075b964b07152d234b70', 'Shawn', 'Lim', '2000-06-12', 'Kuala Lumpur', 'Bukit Bintang', '0108020455', 'ONGPEIKANG57@HOTMAIL.COM', NULL),
(3, 'alex', '202cb962ac59075b964b07152d234b70', 'Darren', 'Lee', '2008-05-04', 'Johor', 'Johor Bahru', '0108020455', 'ONGPEIKANG57@HOTMAIL.COM', 0x313638383432353034325f696d61676573202837292e6a706567),
(4, 'adopter1', '202cb962ac59075b964b07152d234b70', 'ong', 'peikang', '2023-06-06', 'Johor', 'Batu Pahat', '0108020455', 'ONGPEIKANG57@HOTMAIL.COM', 0x313638383435343236325f61646f70322e6a706567),
(5, 'pkpk', '202cb962ac59075b964b07152d234b70', 'Ong', 'Kang', '2023-01-08', 'Johor', 'Batu Pahat', '0108020455', 'b032010100@student.utem.edu.my', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `breed`
--

CREATE TABLE `breed` (
  `breedID` int(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `type` varchar(5) NOT NULL,
  `description` varchar(4000) NOT NULL,
  `breed_image` mediumblob NOT NULL,
  `kid_friendly` int(1) NOT NULL,
  `pet_friendly` int(1) NOT NULL,
  `stranger_friendly` int(1) NOT NULL,
  `affection` int(1) NOT NULL,
  `grooming` int(1) NOT NULL,
  `playfulness` int(1) NOT NULL,
  `shedding` int(1) NOT NULL,
  `energy_level` int(1) NOT NULL,
  `intelligence` int(1) NOT NULL,
  `vocality` int(1) NOT NULL,
  `origin` varchar(20) NOT NULL,
  `life_span` varchar(20) NOT NULL,
  `length` varchar(20) NOT NULL,
  `weight` varchar(20) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `breed`
--

INSERT INTO `breed` (`breedID`, `name`, `type`, `description`, `breed_image`, `kid_friendly`, `pet_friendly`, `stranger_friendly`, `affection`, `grooming`, `playfulness`, `shedding`, `energy_level`, `intelligence`, `vocality`, `origin`, `life_span`, `length`, `weight`, `size`) VALUES
(1, 'Afador', 'Dog', 'The Afador is a hybrid dog breed that is a cross between the Afghan Hound and the Labrador Retriever. This mixed breed combines the distinctive characteristics of both parent breeds, resulting in a unique and versatile canine companion.\r\n\r\nAfadors are typically large-sized dogs with a well-muscled build. They often inherit the sleek, long coat of the Afghan Hound, which may come in a variety of colors including black, tan, brown, or a combination of these. Their coat may require regular grooming to keep it clean and free from tangles.\r\n\r\nIn terms of temperament, Afadors are known for their loyalty, intelligence, and friendly nature. They are generally good-natured, social dogs that enjoy spending time with their families. Afadors are often affectionate, making them great family pets and companions. They can also exhibit the high energy and enthusiasm of the Labrador Retriever, requiring regular exercise and mental stimulation to keep them happy and well-behaved.\r\n\r\nDue to their mixed heritage, Afadors may inherit a combination of traits from their parent breeds. Its important to note that individual Afadors can vary in appearance, temperament, and other characteristics, as is the case with all mixed breed dogs.\r\n\r\nIf you`re considering adding an Afador to your family, its recommended to research and understand the needs of both Afghan Hounds and Labrador Retrievers, as this will give you a better understanding of what to expect from an Afador. Additionally, early socialization, consistent training, and regular exercise are important for their overall well-being and happiness.', 0x313638383430393030375f616661646f722d646f672e6a7067, 2, 3, 1, 5, 3, 3, 4, 4, 4, 5, 'alaska', '10 to 12', '50.8 to 73.66', '22.68 to 34.02', 'large'),
(2, 'Affenpinscher', 'Dog', 'Loyal, curious, and famously amusing, this almost-human toy dog is fearless out of all proportion to his size. As with all great comedians, it`s the Affenpinscher`s apparent seriousness of purpose that makes his antics all the more amusing.\r\n\r\nThe Affen`s apish look has been described many ways. They`ve been called `monkey dogs` and `ape terriers.` The French say diablotin moustachu (`mustached little devil`), and Star Wars fans argue whether they look more like Wookies or Ewoks.     Standing less than a foot tall, these sturdy terrier-like dogs approach life with great confidence. This isn`t a breed you train, a professional dog handler tells us, He`s like a human. You befriend him. The dense, harsh coat is described as `neat but shaggy` and comes in several colors; the gait is light a', 0x313638383430393839375f696d61676573202831292e6a706567, 1, 4, 3, 4, 3, 4, 1, 4, 5, 3, 'Germany', '12 to 15', '22.86 to 27.94', '3.18 to 4.54', 'small'),
(3, 'Afghan Hound', 'Dog', 'Among the most eye-catching of all dog breeds, the Afghan Hound is an aloof and dignified aristocrat of sublime beauty. Despite his regal appearance, the Afghan can exhibit an endearing streak of silliness and a profound loyalty.\r\n\r\nSince ancient times, Afghan Hounds have been famous for their elegant beauty. But the thick, silky, flowing coat that is the breed`s crowning glory isn`t just for show ` it served as protection from the harsh climate in mountainous regions where Afghans originally earned their keep. Beneath the Afghan`s glamorous exterior is a powerful, agile hound ` standing as high as 27 inches at the shoulder ` built for a long day`s hunt. Their huge paw-pads acted as shock absorbers on their homeland`s punishing terrain.  The Afghan Hound is a special breed for special people', 0x313638383431303139325f41666768616e5f646f675f2d5f63726f707065642e6a7067, 5, 4, 2, 4, 4, 4, 4, 5, 5, 3, 'Afghanistan', '12 to 18', '65.5 to 68.58', '22.68 to 27.22', 'large'),
(4, 'Airedale Terrier', 'Dog', 'His size, strength, and unflagging spirit have earned the Airedale Terrier the nickname `The King of Terriers.` The Airedale stands among the world`s most versatile dog breeds and has distinguished himself as hunter, athlete, and companion.\r\n\r\nThe Airedale Terrier is the largest of all terrier breeds. Males stand about 23 inches at the shoulder, females a little less. The dense, wiry coat is tan with black markings. Long, muscular legs give Airedales a regal lift in their bearing, and the long head`with its sporty beard and mustache, dark eyes, and neatly folded ears`conveys a keen intelligence. Airedales are the very picture of an alert and willing terrier`only bigger. And, like his smaller cousins in the terrier family, he can be bold, determined, and stubborn. Airedales are docile and', 0x313638383431303539325f646f776e6c6f6164202831292e6a706567, 3, 2, 3, 3, 4, 4, 5, 4, 3, 4, 'United Kingdom', '11 to 14', '50.8 to 63.5', '22.68 to 31.75', 'medium'),
(5, 'Akita', 'Dog', 'The Akita is a muscular, double-coated dog of ancient Japanese lineage famous for their dignity, courage, and loyalty. In their native land, they`re venerated as family protectors and symbols of good health, happiness, and long life.\r\n\r\nAkitas are burly, heavy-boned spitz-type dogs of imposing stature. Standing 24 to 28 inches at the shoulder, Akitas have a dense coat that comes in several colors, including white. The head is broad and massive, and is balanced in the rear by a full, curled-over tail. The erect ears and dark, shining eyes contribute to an expression of alertness, a hallmark of the breed. Akitas are quiet, fastidious dogs. Wary of strangers and often intolerant of other animals, Akitas will gladly share their silly, affectionate side with family and friends. They thrive on hum', 0x313638383431313034335f416b6974612d4765747479496d616765732d3538383632323938342d35333365393535646639323134333031613536623463303638396233323131342d62373536383931656163323434353035396362643539343330646266663765322e6a706567, 1, 1, 2, 3, 4, 5, 5, 4, 5, 2, 'Japan', '10 to 14', '66.04 to 71.12', '45.36 to 58.97', 'large'),
(6, 'Alaskan Klee Kai', 'Dog', 'The Alaskan Klee Kai is a small-sized companion dog that is alert, energetic, and curious, yet reserved with unfamiliar people and situations. \r\n\r\nThe Alaskan Klee Kai is a small sized companion dog with a smooth, agile, and well-balanced gait, a body that is well proportioned with a level topline and a length slightly longer than height.  The wedge-shaped head, erect triangle shaped ears, well furred double coat in three symmetrical contrasting color varieties, and a loosely curled tail reflect its arctic heritage. ', 0x313638383431383833315f646f776e6c6f6164202832292e6a706567, 3, 2, 2, 4, 1, 4, 4, 4, 4, 3, 'United States', '13 to 16', '30 to 43.18', '7.26 to 11.34', 'small'),
(7, 'Alaskan Malamute', 'Dog', 'An immensely strong, heavy-duty worker of spitz type, the Alaskan Malamute is an affectionate, loyal, and playful but dignified dog recognizable by his well-furred plumed tail carried over the back, erect ears, and substantial bone. The Alaskan Malamute stands 23 to 25 inches at the shoulder and weighs 75 to 85 pounds. Everything about Mals suggests their origin as an arctic sled dog: The heavy bone, deep chest, powerful shoulders, and dense, weatherproof coat all scream, I work hard for a living! But their almond-shaped brown eyes have an affectionate sparkle, suggesting Mals enjoy snuggling with their humans when the workday is done. Mals are pack animals. And in your family pack, the leader must be you. If a Mal doesnt respect you, he will wind up owning you instead of the other ', 0x313638383431393038315f416c61736b616e5f6d616c616d7574653835302e6a7067, 3, 2, 5, 4, 4, 5, 5, 5, 4, 3, 'Alaska', '10 to 14', '50.8 to 63.5', '34.02 to 38.56', 'medium'),
(8, 'Boerboel', 'Dog', 'Boerboels are intimidating but discerning guardians of home and family who learned their trade while protecting remote South African homesteads from ferocious predators. They are dominant and confident, also bright and eager to learn.\r\n\r\nThere`s a no-frills, no-nonsense quality to this sleek-coated avenger, who might stand as high as 27 inches at the shoulder and weigh as much as you do. A broad and blocky head, powerful jaws, and thick muscles from neck to rump mark it as a descendant of the ancient `molloser` dog family, the foundation of today`s mastiff-type breeds. In motion, the Boerboel just might be the most agile of all mastiff types. The imposing Boerboel is devoted to protecting the people and places he loves. Training and socialization should begin early, before a pup b', 0x313638383431393238365f696d61676573202832292e6a706567, 4, 2, 2, 4, 1, 4, 3, 3, 4, 3, 'South Africa', '9 to 11', '60.96 to 68.58', '68.04 to 90.72', 'large'),
(9, 'Bohemian Shepherd', 'Dog', 'The Bohemian Shepherd is an intelligent, lively, quick, athletic breed which enthusiastically welcomes most any activity introduced, making the breed rather versatile.\r\n\r\nThey succeed in many arenas such as agility, dog dancing, schutzhund, search and rescue, nose work, tracking, pastoral work, obedience, therapy dogs, service dogs, and are now breaking into the fields of coursing, dock diving and endurance tests. The Bohemian Shepherd makes an excellent family dog due to its devotion to family members and adoration of children. This is a breed which loves to be with its family and also does well with other non-human members of the family when raised with them.', 0x313638383431393439375f646f776e6c6f6164202833292e6a706567, 4, 4, 3, 5, 1, 5, 4, 4, 4, 3, 'Czech Republic', '12 to 15', '53.34 to 58.42', '18.60 to 27.22', 'medium'),
(10, 'Boxer', 'Dog', 'Loyalty, affection, intelligence, work ethic, and good looks: Boxers are the whole doggy package. Bright and alert, sometimes silly, but always courageous, the Boxer has been among America`s most popular dog breeds for a very long time. A well-made Boxer in peak condition is an awesome sight. A male can stand as high as 25 inches at the shoulder; females run smaller. Their muscles ripple beneath a short, tight-fitting coat. The dark brown eyes and wrinkled forehead give the face an alert, curious look. The coat can be fawn or brindle, with white markings. Boxers move like the athletes they are named for: smooth and graceful, with a powerful forward thrust. Boxers are upbeat and playful. Their patience and protective nature have earned them a reputation as a great dog with children. They ta', 0x313638383431393733355f696d61676573202833292e6a706567, 5, 4, 4, 4, 1, 5, 2, 4, 5, 3, 'Germany', '10 to 12', '58.42 to 63.5', '29.48 to 36.29', 'large'),
(11, 'Bulldog', 'Dog', 'Kind but courageous, friendly but dignified, the Bulldog is a thick-set, low-slung, well-muscled bruiser whose `sourmug` face is the universal symbol of courage and tenacity. These docile, loyal companions adapt well to town or country. \r\n\r\nYou can`t mistake a Bulldog for any other breed. The loose skin of the head, furrowed brow, pushed-in nose, small ears, undershot jaw with hanging chops on either side, and the distinctive rolling gait all practically scream I`m a Bulldog! The coat, seen in a variety of colors and patterns, is short, smooth, and glossy. Bulldogs can weigh up to 50 pounds, but that won`t stop them from curling up in your lap, or at least trying to. But don`t mistake their easygoing ways for laziness`Bulldogs enjoy brisk walks and need regular moderate exercise, along ', 0x313638383431393937375f646f776e6c6f6164202834292e6a706567, 2, 2, 2, 5, 3, 3, 3, 3, 5, 2, 'United Kingdom', '8 to 10', '35.56 to 40.64', '20.87 to 24.50', 'small'),
(12, 'Carolina Dog', 'Dog', 'Carolina Dogs are generally shy and suspicious in nature, but once a dog accepts a human into its pack, those behaviors disappear toward that human. A sighthound of medium build, they have the general appearance of a jackal or wolf.\r\n\r\nCarolina dogs are descended from the canines that accompanied the Paleo-Indians who traveled from Asia to North America over the Bering land bridge. Today, they can still be found living wild near the Georgia-South Carolina border, but have also been seen as far north as Ohio and Pennsylvania and as far west as Arizona; rural areas are the common denominator. The typical Carolina dog has pointed ears, a fox-like snout and a tail that curves like a fishhook when it is raised. They look similar to Australian Dingoes but, taxonomically, they fall under canis fami', 0x313638383432303136355f6361726f6c696e612d646f672d6765726d616e2d73686570686572642d6d69782d7374616e64696e672d6f7574646f6f722e6a7067, 3, 5, 2, 4, 1, 3, 4, 4, 2, 3, 'United States', '12 to 15', '45.72 to 50.8', '14.97 to 24.95', 'medium'),
(13, 'Czechoslovakian Vlcak', 'Dog', 'Very intelligent, self-thinking, not well suited to do repetitive tasks or service type work where the dog must stay on task for long periods.\r\n\r\nAn alert, primitive canine that resembles a wolf in appearance. They are highly intelligent, powerful, active, loyal and devoted to their owner. They have superior eyesight, hearing and sense of smell and are known for having excellent stamina and endurance. The Czechoslovakian Vlcak (CSV) was originally bred for working border patrol in Czechoslovakia in the 1950s. They are currently used in Europe and the United States for search and rescue, tracking, obedience, agility, drafting, herding, and working dog sports. The CSV is bred for versatility and hardiness in harsh elements and is much more independent in nature than many other working breeds. ', 0x313638383432303333385f4765747479496d616765732d3137353735343035312d32666633336632643433643634343966616135633338326435393932393765332e6a7067, 4, 3, 1, 3, 3, 4, 3, 4, 4, 1, 'Czech Republic', '12 to 16', '58.42 to 68.58', '24.95 to 27.22', 'large'),
(14, 'Drever', 'Dog', 'The Drever is robust and strong rather than elegant and speedy. They have a proud carriage, well-developed muscles and agile appearance. Affectionate, playful, and sweet, the Drever gets along well with most other breeds and is great in groups. The Drever was developed in the early twentieth century in Sweden. Hunting deer was difficult due to terrain and herd locations so hunters soon realized the benefits of using this short-legged, long-bodied dog to drive the deer over long distances and rough terrain right to them. A keen and even-tempered hound, the Drever is never aggressive, nervous or shy. They are content in most living situations, but tend to be vocal when alerting or at play.', 0x313638383432303439395f4472657665722d4d502e6a7067, 5, 4, 3, 4, 2, 4, 3, 5, 5, 4, 'Sweden', '13 to 16', '30.48 to 40.64', '15.88 to 18.14', 'small'),
(15, 'Danish-Swedish Farmdog', 'Dog', 'Known as the Little Big Dog, the Danish-Swedish Farmdog is a companion dog that loves to work and enjoys a challenge. They are a small, compact and slightly rectangular dog, known to mature late. This breed entered the American Kennel Club Foundation Stock Services Program (AKC FSS) in 2011. They are eligible to compete in Agility, Barn Hunt, Flyball, Herding, Lure Coursing, Nosework, Obedience and Rally, Tracking and AKC FSS Open Shows.   Club Contact Details Danish/Swedish Farmdog Club of America, Inc Brita Lemmon Puppies@farmdogs.org or cs@dsfca.org', 0x313638383432303832365f646f776e6c6f6164202835292e6a706567, 5, 5, 3, 4, 1, 4, 5, 4, 5, 3, 'Sweden', '11 to 13', '33.02 to 40.64', '6.80 to 9.07', 'small'),
(16, 'Dogue de Bordeaux', 'Dog', 'The most ancient of French dog breeds, the Dogue de Bordeaux (Mastiff of Bordeaux) was around even before France was France. These brawny fawn-coated guardians of considerable courage are famously loyal, affectionate, and protective.\r\n\r\nThe Dogue de Bordeaux is an immensely powerful mastiff-type guardian. Males can go 27 inches high and 110 pounds. The short, eye-catching coat is a richly colored fawn. The massive head features a Bulldog-like undershot jaw, expressive eyes, and a deeply furrowed brow. It is, proportionately, the largest head in the canine kingdom. The body is stocky and close to the ground, but Dogues can move like lions when duty calls.     DDBs of proper temperament are sweet and sensitive souls. Owners appreciate their breed`s loyalty to loved ones of all ages, but als', 0x313638383432313036325f4765747479496d616765732d3439373233313736312d66643734636435636232333434613263386462343333303363333437386538632e6a7067, 5, 1, 1, 3, 1, 3, 3, 2, 5, 3, 'United Kingdom', '5 to 8', '50.8 to 63.5', '49.90 to 62.58', 'medium'),
(17, 'Estrela Mountain Dog', 'Dog', 'The Estrela Mountain Dog is not only an excellent livestock guardian, but is also known for his love of children and family. Proper socialization and training as a puppy is very important so that the dominance in the Estrela`s personality does not become aggressive. The Estrela Mountain Dog is named for the Estrela Mountains in Portugal and is believed to be the oldest breed in the region. The breed has several distinctive physical characteristics including rosed ears, a black mask and a hook at the end of its tail. He is an inseparable companion of the shepherd and a faithful flock guardian, bravely protecting it against predators and thieves. A wonderful farm and house guard, he is distrustful towards strangers but typically docile to his master. As a companion in the home, an Estrela wi', 0x313638383432313234305f62613032633462626265383637613263633430613231656166393064646532332d2d73657272612d6c6f6e672d636f6174732e6a7067, 5, 3, 2, 5, 3, 3, 4, 3, 5, 3, 'Portugal', '10 to 14', '63.5 to 73.66', '34.93 to 59.88', 'large'),
(18, 'English Foxhound', 'Dog', 'The English Foxhound is a substantial galloping hound of great stamina. His long legs are straight as a gatepost, and just as sturdy. The back is perfectly level. And the chest is very deep, `girthing` as much as 31 inches on a hound measuring 24 inches at the shoulder, ensuring plenty of lung power for a grueling day`s hunt. These pack-oriented, scent-driven hounds are gentle and sociable, but rarely seen as house pets. They can be so driven by a primal instinct for pursuit that not much else, including training, matters to them. Owning these noble creatures is best left to huntsmen who kennel packs of hounds or to those experienced in meeting the special challenges of life with swift, powerful hounds hardwired for the chase. The English Foxhound is the epitome of what serious dog breede', 0x313638383432313431315f646f776e6c6f6164202836292e6a706567, 5, 5, 5, 4, 1, 5, 2, 4, 5, 5, 'United Kingdom', '10 to 13', '58.42 to 68.58', '27.22 to 34.02', 'large'),
(19, 'Finnish Spitz', 'Dog', 'The lively Finnish Spitz, the flame-colored, foxy-faced breed from the Land of 60,000 Lakes, is a small but fearless hunting dog whose unique style of tracking and indicating quarry has earned him the nickname the `Barking Bird Dog.` The balanced, squarely symmetrical Finnish Spitz will stand not more than 20 inches at the shoulder and are easily recognized by their foxy face and prick ears projecting a lively expression, and a curving plumed tail. Their dense coat of glorious golden-red which is never monochromatic gives them the Finnish Spitz Glow. Finkies or Finns, as they are nicknamed, move with a bold and brisk gait. Finkies make excellent alertdogs, wary but not shy with strangers. This is a vocal breed  in Finland, owners hold contests to crown a `King Barker` and true', 0x313638383432313538395f646f776e6c6f6164202837292e6a706567, 5, 5, 3, 4, 3, 5, 4, 5, 5, 5, 'Finland', '13 to 15', '43.18 to 50.8', '11.34 to 14.97', 'medium'),
(20, 'Great Pyrenees', 'Dog', 'The Great Pyrenees is a large, thickly coated, and immensely powerful working dog bred to deter sheep-stealing wolves and other predators on snowy mountaintops. Pyrs today are mellow companions and vigilant guardians of home and family. Frequently described as `majestic,` Pyrs are big, immensely strong mountain dogs standing as high as 32 inches at the shoulder and often tipping the scales at more than 100 pounds. These steadfast guardians usually exhibit a Zen-like calm, but they can quickly spring into action and move with grace and speed to meet a threat. The lush weatherproof coat is all white, or white with markings of beautiful shades of gray, tan, reddish-brown, or badger.', 0x313638383432313734385f646f776e6c6f6164202838292e6a706567, 4, 3, 3, 4, 3, 3, 4, 4, 4, 3, 'Portugal', '10 to 12', '68.58 to 81.28', '45.36 to 68.4', 'large'),
(21, 'Hokkaido', 'Dog', 'The Hokkaido is a dog of noteworthy endurance and dignity. His temperament is faithful, docile, very alert and bold. He also shows accurate judgement and great stamina.\r\n\r\nThe Hokkaido is a medium-sized, strongly-built dog. They have longer, thicker coats than the other Japanese breeds, and also have wider chests and smaller ears. Like all the Nihon Ken, they have a double coat made up of protective, coarse outer guard hairs, and a fine, thick undercoat that is shed seasonally. The breed comes in several colors: white, red, black, brindle, sesame, and wolf grey. With early training, the Hokkaido is a very loyal and dedicated companion who wants to please his human family. They are incredibly intelligent thinkers and problem solvers, and they excel at tasks given to them.', 0x313638383432313935375f696d61676573202834292e6a706567, 4, 3, 3, 4, 1, 3, 4, 3, 4, 3, 'Japan', '12 to 15', '45.72 to 50.8', '19.96 to 29.94', 'medium'),
(22, 'Ibizan Hounds', 'Dog', 'The Ibizan Hound is a lithe and leggy visitor from the dawn of civilization, bred as a rabbit courser on the rocky shores of Spain`s Balearic Islands. World-class sprinters and leapers, Ibizans need ample space to air out their engines.\r\n\r\nIbizans are lithe and leggy visitors from the dawn of civilization. Art history students will recognize the elongated head, with its large erect ears, as a familiar motif of ancient Egypt. The elegant, racy body stands 22.5 to 27.5 inches at the shoulder, with coat colors of solid red or white, or red and white patterns. The rosy-colored leathers of the nose, eye rims, and lips, along with amber or caramel eyes, perfectly complement the coat. The breed`s quiet grace is often described as deer-like.', 0x313638383432323135305f646f776e6c6f6164202839292e6a706567, 5, 5, 4, 4, 1, 5, 3, 5, 5, 3, 'Ibiza', '11 to 14', '60.96 to 71.12', '20.42 to 24.95', 'large'),
(23, 'Japanese Chin', 'Dog', 'The Japanese Chin is a charming toy companion of silky, profuse coat and an unmistakably aristocratic bearing. Often described as a distinctly feline breed, this bright and amusing lapdog is fastidious, graceful, and generally quiet. Chin are the unrivaled noblemen of Japanese breeds. They`re tiny indoorsy companions, with an unmistakably Eastern look and bearing. The head is large, the muzzle short, and the round, dark eyes convey, as Chin fans like to say, a look of astonishment. The profuse mane around the neck and shoulders, the plumed tail arching over the back, and the pants or `culottes` on the hind legs project the elegant, exotic appearance so typical of Asia`s royal line of laptop cuddle bugs.', 0x313638383432323330335f646f776e6c6f616420283130292e6a706567, 3, 3, 4, 3, 2, 4, 3, 2, 3, 2, 'Japan', '10 to 12', '20.32 to 27.94', '3.18 to 4.99', 'small'),
(24, 'Jindo', 'Dog', 'Loyal, watchful, and intelligent, the Jindo developed as a breed on an island off the coast of South Korea. Medium-sized and natural in appearance, they are valued as independent hunters, discerning guardians, and loyal companions.\r\n\r\nThe Jindo Dog is a well-proportioned, medium-sized dog used for hunting and guarding. With erect ears and a rolled or sickle-shaped tail, it should be a vivid expression of agility, strength, alertness and dignity.The Jindo has a very strong instinct for hunting and is bold, brave, alert and careful, not tempted easily and impetuous. But most of all he is extremely faithful to his master. On the whole he is not fond of other animals, especially males. He also has a good sense of direction. A one-man dog, he readily accepts a new master, but never forgets his at', 0x313638383432323531335f696d61676573202835292e6a706567, 3, 3, 4, 5, 4, 4, 5, 4, 5, 3, 'Korea', '14 to 15', '48.26 to 55.88', '18.14 to 22.68', 'medium'),
(25, 'Keeshond', 'Dog', 'The amiable Keeshond is a medium-sized spitz dog of ample coat, famous for the distinctive \"spectacles\" on his foxy face. Once a fixture on the canal barges of his native Holland, the Kees was, and remains, a symbol of Dutch patriotism.\r\n\r\nThese square, sturdy companions descend from the same ancient stock as other spitz types, such as Pomeranians and Samoyeds. Typically \"spitzy,\" Keeshonden have a foxy face, pointed ears, an abundant coat, and a plumed tail carried high over the back. A unique breed characteristic and one of the most charming hallmarks in all dogdom is the \"spectacles.\" These shadings and markings around the eyes give the impression that a Kees is wearing designer eyewear. The specs draw attention to an alert, intelligent expression.', 0x313638383432323638335f646f776e6c6f616420283131292e6a706567, 5, 4, 4, 4, 2, 5, 5, 4, 5, 4, 'Germany', '12 to 15', '35.56 to 55.88', '15.88 to 20.41', 'medium'),
(26, 'Kuvasz', 'Dog', 'The snow-white Kuvasz is Hungary`s majestic guardian of flocks and companion of kings. A working dog of impressive size and strength, the imposing and thickly coated Kuvasz is a beautiful, smart, profoundly loyal, but challenging breed.\r\n\r\nImposing, impressive, majestic, massive, mighty, pick the adjective you like best, they all apply to the Kuvasz (pronounced KOO-vahz; the plural is Kuvaszok, pronounced KOO-vah-sock). This snow-white livestock guardian of luxuriant coat can stand as high as 30 inches at the shoulder, and weigh between 70 and 110 pounds. Despite their size and strength, Kuvs are quick-moving, nimble-footed protectors when meeting a threat. The breed`s fans say that the elegantly proportioned head is considered to be the most beautiful part of the Kuvasz.', 0x313638383432323833375f4b757661737a5f322e6a7067, 1, 2, 1, 4, 1, 4, 4, 4, 5, 3, 'Hungary', '10 to 12', '71.12 to 76.2', '45.36 to 52.16', 'large'),
(27, 'Labrador Retriever', 'Dog', 'The sweet-faced, lovable Labrador Retriever is America`s most popular dog breed. Labs are friendly, outgoing, and high-spirited companions who have more than enough affection to go around for a family looking for a medium-to-large dog. The sturdy, well-balanced Labrador Retriever can, depending on the sex, stand from 21.5 to 24.5 inches at the shoulder and weigh between 55 to 80 pounds. The dense, hard coat comes in yellow, black, and a luscious chocolate. The head is wide, the eyes glimmer with kindliness, and the thick, tapering `otter tail` seems to be forever signaling the breed`s innate eagerness. Labs are famously friendly. They are companionable housemates who bond with the whole family, and they socialize well with neighbor dogs and humans alike. But don`t mistake his easygoing pe', 0x313638383432333033355f7368757474657273746f636b5f313635373639323233352d31303234783638332e6a7067, 5, 5, 5, 5, 1, 5, 5, 5, 5, 3, 'Newfoundland', '11 to 13', '57.15 to 62.23', '29.48 to 36.29', 'medium'),
(28, 'Lagotto Romagnolo', 'Dog', 'The Lagotto Romagnolo, Italy`s adorable `truffle dog,` sports a curly coat and lavish facial furnishings. Despite their plush-toy looks, Lagotti are durable workers of excellent nose who root out truffles, a dainty and pricey delicacy.\r\n\r\nItalians have a word for it: carino. In English, we say cute. In any language, this breed is totally endearing. The Lagotto Romagnolo (plural: Lagotti Romagnoli) is known for wooly curls that cover the body head to tail, crowned by a lavish beard, eyebrows, and whiskers. Lagotti stand under 20 inches and weigh no more than 35 pounds. But don`t be fooled by their teddy-bear looks, these are rugged workers of true strength and endurance. The breed`s trademark curls feel and behave more like human hair than fur.', 0x313638383432333138395f35333135396238366631653761623735386161613938666335356265653863362e6a7067, 3, 3, 3, 4, 4, 4, 1, 4, 3, 2, 'Italy', '15 to 17', '43.18 to 48.26', '12.7 to 15.88', 'medium'),
(29, 'Golden Retriever', 'Dog', 'The Golden Retriever, an exuberant Scottish gundog of great beauty, stands among America`s most popular dog breeds. They are serious workers at hunting and field work, as guides for the blind, and in search-and-rescue, enjoy obedience and other competitive events, and have an endearing love of life when not at work. The Golden Retriever is a sturdy, muscular dog of medium size, famous for the dense, lustrous coat of gold that gives the breed its name. The broad head, with its friendly and intelligent eyes, short ears, and straight muzzle, is a breed hallmark. In motion, Goldens move with a smooth, powerful gait, and the feathery tail is carried, as breed fanciers say, with a merry action. The most complete records of the development of the Golden Retriever are included in the record boo', 0x313638383432333430335f476f6c64656e5f5265747269657665725f486973746f72795f363230783333302e6a7067, 5, 5, 5, 5, 3, 5, 5, 5, 5, 1, 'United Kingdom', '10 to 12', '58.42 to 63.5', '29.48 to 34.12', 'large'),
(30, 'Norwegian Lundehund', 'Dog', 'From Norway`s rocky island of Vaeroy, the uniquely constructed Norwegian Lundehund is the only dog breed created for the job of puffin hunting. With puffins now a protected species, today`s Lundehund is a friendly, athletic companion.\r\n\r\nAt a glance, Lundehunds seem a typical northern breed: A spitz type with triangular ears, curving tail, and a dense double coat. But a closer look reveals several unique traits. They have feet with at least six fully functioning toes and extra paw pads, an elastic neck that can crane back so the head touches the spine, ears that fold shut, and flexible shoulders that allow forelegs to extend to the side, perpendicular to the body. This last anomaly produces the breed`s distinctive `rotary` gait.\r\n\r\n', 0x313638383432333632305f4e6f7277656769616e2d4c756e646568756e642d4d502e6a7067, 5, 5, 5, 5, 1, 5, 5, 4, 5, 3, 'Norway', '12 to 15', '33.02 to 38.1', '6.80 to 8.16', 'small'),
(31, 'Chihuahua', 'Dog', 'The Chihuahua is a tiny dog with a huge personality. A national symbol of Mexico, these alert and amusing \"purse dogs\" stand among the oldest breeds of the Americas, with a lineage going back to the ancient kingdoms of pre-Columbian times. The Chihuahua is a balanced, graceful dog of terrier-like demeanor, weighing no more than 6 pounds. The rounded \"apple\" head is a breed hallmark. The erect ears and full, luminous eyes are acutely expressive. Coats come in many colors and patterns, and can be long or short. The varieties are identical except for coat. Chihuahuas possess loyalty, charm, and big-dog attitude. Even tiny dogs require training, and without it this clever scamp will rule your household like a little Napoleon. Compact and confident, Chihuahuas are ideal city pets. They are too ', 0x313638383432333930305f646f776e6c6f616420283132292e6a706567, 5, 2, 2, 4, 1, 4, 2, 3, 5, 5, 'Mexico', '14 to 16', '12.7 to 20.32', '1.36 to 2.72', 'small'),
(32, 'Pembroke Welsh Corgi', 'Dog', 'Among the most agreeable of all small housedogs, the Pembroke Welsh Corgi is a strong, athletic, and lively little herder who is affectionate and companionable without being needy. They are one the world`s most popular herding breeds. At 10 to 12 inches at the shoulder and 27 to 30 pounds, a well-built male Pembroke presents a big dog in a small package. Short but powerful legs, muscular thighs, and a deep chest equip him for a hard day`s work. Built long and low, Pembrokes are surprisingly quick and agile. They can be red, sable, fawn, and black and tan, with or without white markings. The Pembroke is a bright, sensitive dog who enjoys play with his human family and responds well to training. As herders bred to move cattle, they are fearless and independent. They are vigilant watchdogs, w', 0x313638383432343331395f696d61676573202836292e6a706567, 4, 3, 5, 5, 1, 4, 5, 4, 5, 4, 'Pembrokeshire', '12 to 13', '22.86 to 30.48', '11.34 to 13.6', 'small'),
(33, 'Toy Fox Terrier', 'Dog', 'A diminutive satin-coated terrier with an amusing toy-dog personality, the Toy Fox Terrier is, as breed fanciers say, truly a toy and a terrier. They began as barnyard ratters but are today beguiling companions with a big personality. A surefire recipe for fun: Take the lovability of a lapdog. Combine with terrier tenacity. Pour the mixture into a beautifully balanced container. Wrap in a tight-fitting satin coat. Top with large, erect ears and dark eyes that sparkle with eager intelligence. This is the Toy Fox Terrier, a lithe but sturdy little comedian standing under a foot tall but packed with enough charisma for a whole kennel of ordinary dogs. The breed`s admirers like to say, TFTs are truly a toy and a terrier.', 0x313638383432343637305f546f79466f78546572726965724765747479496d616765732d313137383138303136335365726765795279756d696e2d38623863623334613634303634353431383564646565613937623861306334352e6a7067, 4, 3, 3, 4, 1, 5, 4, 5, 5, 4, 'United States', '13 to 15', '21.59 to 29.21', '1.81 to 4.08', 'small'),
(34, 'Abyssinian', 'Cat', 'Showing cats was all the rage in the late Victorian era. One of the unusual breeds exhibited at the Crystal Palace Cat Show in 1871 was an Abyssinian — “captured in the late Abyssinian War” — who took third place. The report on the cat show, published in the January 27, 1872, issue of Harper’s Weekly, was the first known mention in print of the breed. Unfortunately, no records exist regarding the cats’ origins, although myths and speculation abound, including claims that it was the cat of the pharaohs, and that it was created in Britain by crossing silver and brown tabbies with cats that had “ticked” coats.', 0x313638383432353738305f6162797373696e69616e2d7374616e64696e672d776f6f64656e2d666c6f6f722d3333323030393730352d323030302d65353265353131653330653634303432613435623761366536663336343634642e6a706567, 5, 5, 2, 5, 2, 5, 3, 4, 3, 2, 'France', '9 to 15', '27.94 to 40.64', '2.72 to 4.54', 'medium'),
(35, 'Aegean', 'Cat', 'The Aegean is a natural cat breed cat, which means they developed without the need for human intervention. Fans of the breed recognize these felines as smart, energetic, and friendly companions.\r\n\r\nYou can find these cats in shelters and breed specific rescues, so remember to always adopt! Don’t shop if you’re looking to add one of these cats to your home!\r\nThe Aegean is a great family cat, with their social disposition credited to their history as one of the oldest ever domestic cat breeds around. They’re brave and intelligent kitties who get on well with kids. Although, as the breed isn’t afraid of water, it’s not normally a great idea to adopt a cat of this breed if you have a fish tank at home.', 0x313638383432363039325f61656765616e2d6361742d616c616d792d64796b7035372d3634352e6a7067, 5, 3, 4, 4, 1, 4, 3, 4, 5, 3, 'Greece', '9 to 10', '12 to 15.42', '3.18 to 4.54', 'small'),
(36, 'American Wirehair', 'Cat', 'This cat is an American original. It`s not unusual for natural mutations to pop up in cats in different places around the world, but so far the mutation for a wiry coat has appeared only in the United States. It was first seen in 1966, in a litter of kittens born to a domestic shorthair cat in upstate New York. The only kitten to survive from that litter was a red tabby and white male. Because of his unusual coat, the owners showed him to a local cat breeder, Joan O`Shea, who purchased the kinky-coated kitten for $50, named him Council Rock Adam of Hi-Fi and set about trying to reproduce him through crosses to American Shorthairs.', 0x313638383432373032305f416d65726963616e2d57697265686169722d4361742d42726565642d46616374732d616e642d54656d706572616d656e742e6a7067, 4, 3, 3, 4, 1, 4, 3, 3, 4, 2, 'United States', '14 to 18', '20.32 to 25.4', '3.62 to 6.8', 'small'),
(37, 'Australian Mist', 'Cat', 'The Australian Mist is a mixed breed cat–a cross between over 30 cat breeds that predominantly include the Burmese, Abyssinian, and Australian Shorthair breeds. Friendly, loving, and energetic, these cats inherited some of the best traits from all of their parents.\r\n\r\nAustralian Mists were originally known as Spotted Mist cats. You may find them in shelters and rescues, so remember to always adopt! Don`t shop if you`re looking to add one of these cats to your home!\r\n\r\n', 0x313638383432373231395f696d61676573202839292e6a706567, 4, 3, 3, 4, 2, 4, 2, 3, 5, 2, 'Australia', '15 to 18', '17.78 to 22.86', '3.63 to 6.8', 'small'),
(38, 'Brazilian Shorthair', 'Cat', 'The Brazilian Shorthair has roots going back to the everyday street cats of Brazil. This is a charismatic and outgoing feline who`s happy to engage in human interaction. These cats have lots of street smarts and are very curious creatures, so you`ll need to be able to provide a home environment that`s full of playtime with room to explore.', 0x313638383432373339355f4272617a696c69616e2d53686f7274686169722d6361742d6f7574646f6f72735f5769726573746f636b2d43726561746f72735f5368757474657273746f636b2e6a7067, 5, 4, 4, 4, 2, 4, 1, 5, 4, 3, 'Brazil', '14 to 20', '27 to 30', '4.54 to 9.98', 'small'),
(39, 'British Longhair', 'Cat', 'The British Longhair is a mixed breed cat–a cross between the British Shorthair and Persian cat breeds. Friendly, independent, and affectionate, these cats inherited some of the best traits from both of their parent breeds.\r\n\r\nYou may find these cats in shelters and breed specific rescues, so remember to always adopt! Don’t shop if you’re looking to add one of these kitties to your home!', 0x313638383432373534335f427269746973682d4c6f6e67686169722d50696374757265732e6a7067, 4, 3, 4, 4, 3, 3, 4, 5, 4, 4, 'United Kingdom', '15 to 17', '30.48 to 35.56', '4.08 to 8.16', 'medium'),
(40, 'British Shorthair', 'Cat', 'Full of British reserve, the British Shorthair cat has a quiet voice and is an undemanding companion.\r\n\r\nWhile not overly affectionate, the British Shorthair tends to get along just fine with everyone. They’re mellow and will tolerate other pets, and even though they may not seek out snuggles at every opportunity, they’re happy to be scooped up for a good cuddle.\r\nWhile some cats get a reputation for being high-strung and jumpy, the British Shorthair is anything but. If you’re looking for a best buddy who stays calm as a cucumber and won’t do much pestering, this might just be the feline for you.', 0x313638383432373733305f6d616c652d6c696c61632d627269746973682d73686f7274686169722d6361742d6f7574646f6f725f527574696e612d5368757474657273746f636b2d65313637303934323437333133382e6a7067, 4, 5, 4, 4, 2, 2, 3, 5, 3, 3, 'United Kingdom', '12 to 17', '30 to 35.5', '3.18 to 7.71', 'medium'),
(41, 'Chantilly-Tiffany', 'Cat', 'The Chantilly-Tiffany is a cat breed that started with a pair of chocolate-colored kittens of unknown origin. These felines are known for being affectionate, social, and talkative.\r\n\r\nThis breed originally went by the name Foreign Longhair. You may find these cats in shelters and rescues, so remember to always adopt! Don’t shop if you’re looking to add a feline to your home!', 0x313638383432373837335f7468652d4368616e74696c6c792d54696666616e792e6a7067, 4, 3, 2, 4, 3, 4, 3, 3, 4, 2, 'United States', '7 to 16', '40.64 to 50.8', '2.72 to 5.44', 'medium'),
(42, 'Cornish Rex', 'Cat', 'Cornwall is a sort of magical corner of Great Britain. It was the birthplace of King Arthur, and it was the birthplace of one of the most unusual and interesting cat breeds in existence: the curly-coated Cornish Rex. A curly-coated kitten was born in 1950 to a shorthaired tortoiseshell and white pet cat named Serena, who belonged to Nina Ennismore and Winifred Macalister. The other four kittens in the litter had short hair, so Kallibunker, as he was named, stood out for his odd coat, the result of a spontaneous natural mutation. As is so often the case, the father of the litter was unidentified, although he was suspected to be Ginger, a shorthaired red tabby who was Serena’s litter brother.', 0x313638383432383030365f696d6167657320283130292e6a706567, 5, 5, 5, 4, 1, 5, 2, 5, 5, 5, 'United Kingdom', '11 to 15', '20.32 to 30.48', '2.72 to 4.54', 'small'),
(43, 'Chinese Li Hua', 'Cat', 'The unofficial cat of China, the Li Hua (pronounced “lee-wah”) is thought to be one of the earliest known domestic cats. Based on their mention in old books, they have probably existed throughout China for centuries, but it is only recently that they have been developed as a breed. This is a natural breed, meaning it was not developed through crosses of other breeds. The Chinese Li Hua was accepted into the Cat Fanciers Association’s Miscellaneous Class in February 2010.\r\n\r\nThe Chinese Li Hua cat is also known as China Li Hua, Dragon Li, Li Hua, Lu Hua Mao, Li Hua Mau, and Li Mao.', 0x313638383432383133325f6361742d647261676f6e2d6c692e6a7067, 4, 4, 4, 4, 2, 4, 3, 2, 3, 1, 'China', '9 to 16', '25.4 to 35.56', '4.08 to 5.44', 'medium'),
(44, 'Devon Rex', 'Cat', 'The Devon Rex is a distinctive and charming breed of cat that stands out for its unique appearance and playful personality. Known for its curly coat, large ears, and captivating eyes, the Devon Rex has won the hearts of many cat enthusiasts worldwide.\r\n\r\nOriginating in England during the 1960s, the Devon Rex breed was the result of a natural mutation. A stray kitten named Kirlee, with a curly coat, was discovered in Devon, England. Breeders recognized the uniqueness of this kitten’s appearance and began a deliberate breeding program to further develop the breed.', 0x313638383432383236345f696d6167657320283131292e6a706567, 5, 4, 5, 4, 1, 4, 1, 3, 5, 2, 'Buckfastleigh', '9 to 15', '25.4 to 27.94', '2.27 to 4.53', 'small'),
(45, 'Manx', 'Cat', 'Is it really a cat if it doesn’t have a tail? It is if it’s a Manx. There are lots of cats with short tails or no tails, but the Manx (and his sister breed the longhaired Cymric) is the only one specifically bred to be tail-free. Sometimes jokingly said to be the offspring of a cat and a rabbit (however cute the idea, a “cabbit” is biologically impossible), the tailless Manx is the result of a genetic mutation that was then intensified by the cats’ remote location on the Isle of Man, off the coast of Britain.\r\n\r\nThe cats are thought to date to 1750 or later, but whether a tailless cat was born there or arrived on a ship and then spread its genes throughout the island cat population is unknown. The island became known for tailless cats, and that is how the breed got its name of Manx.', 0x313638383432383530385f646f776e6c6f616420283133292e6a706567, 2, 2, 3, 4, 2, 3, 3, 2, 4, 4, 'United Kingdom', '8 to 14', '40.64 to 43.18', '3.63 to 5.44', 'large'),
(46, 'Pixie-Bob', 'Cat', 'The Pixie-Bob breed is thought to have started from the unplanned litter of a bobcat and a barn cat in 1985. The barn cat belonged to Carol Ann Brewer, and she named a female kitten Pixie. Pixie became the foundation mother for this breed. While there is no hard proof that Pixie’s father was actually a wildcat, it is widely believed and accepted by breeders. \r\n\r\nThe International Cat Association (TICA) officially recognized the Pixie-Bob as a breed in 1994. It took the American Cat Fanciers Association (ACFA) up until 2005 to follow suit and accept the Pixie-Bob as a recognized breed. Breeders are still hoping that the Cat Fanciers Association (CFA) will soon start accepting the Pixie-Bob as a breed as well.', 0x313638383432383636345f50697869652d426f622d342d3634356d6b3036323331312e6a7067, 5, 4, 3, 4, 3, 4, 4, 3, 5, 2, 'United States', '13 to 15', '50.8 to 60.96', '3.63 to 7.71', 'large'),
(47, 'Somali', 'Cat', 'Showing cats was all the rage in the late Victorian era. One of the unusual breeds exhibited at the Crystal Palace Cat Show in 1871 was an Abyssinian—“captured in the late Abyssinian War”—who took third place. The report on the cat show, published in the January 27, 1872, issue of Harper’s Weekly, was the first known mention in print of the breed. Unfortunately, no records exist regarding the cats’ origins, although myths and speculation abound, including claims that it was the cat of the pharaohs, and that it was created in Britain by crossing silver and brown tabbies with cats that had “ticked” coats.\r\n\r\nToday, genetic evidence suggests that the cats came from Indian Ocean coastal regions and parts of Southeast Asia.', 0x313638383432383831355f4765747479496d616765732d3531343933373234382d33363363666666633632343134616130616565366166623736343865393032372e6a7067, 5, 5, 4, 5, 2, 5, 4, 3, 5, 3, 'United States', '11 to 16', '27.94 to 40.64', '2.8 to 4.56', 'medium'),
(48, 'Toyger', 'Cat', 'The Toyger is a mixed breed cat–a cross between the Bengal breed and Domestic Shorthair tabbies. Affectionate, energetic and playful, these kitties inherited some of the best qualities from both of their parents.\r\n\r\nYou may find these mixed breed cats in shelters and breed specific rescues, so remember to always adopt! Don’t shop if you’re looking to add one of these kitties to your home!', 0x313638383432383936335f39326265356564356665613434373266363538633031346136666139633662322e6a7067, 4, 4, 4, 4, 4, 4, 1, 5, 5, 5, 'United States', '10 to 15', '22.86 to 33.02', '3.18 to 6.8', 'small'),
(49, 'California Spangled', 'Cat', 'The California Spangled is a mixed breed cat–a cross between the Angora, Siamese, American Shorthair, Abyssinian, Manx, and British Shorthair breeds. Energetic, loyal, and loving, these kitties inherited some of the best traits from all of their parent breeds.\r\n\r\nYou can find California Spangleds in shelters and breed specific rescues, so adopt! Don’t shop if you’re looking to add one of these kitties to your home!', 0x313638383432393134305f646f776e6c6f616420283134292e6a706567, 4, 4, 4, 4, 1, 4, 2, 2, 4, 2, 'United States', '9 to 16', '38.1 to 45.72', '3.63 to 5.90', 'large'),
(50, 'Cymric', 'Cat', 'Is it really a cat if it doesn’t have a tail? It is if it’s a Cymric (pronounced kim-rick). There are lots of cats with short tails or no tails, but the Cymric (and his sister breed the shorthaired Manx) is the only one specifically bred to be tail-free. Sometimes jokingly said to be the offspring of a cat and a rabbit (however cute the idea, a “cabbit” is biologically impossible), these particular tailless cats are the result of a natural genetic mutation that was then intensified by their remote location on the Isle of Man, off the coast of Britain.', 0x313638383432393238375f30303639663963396531626364303261636164643466303065306566663666312d2d63796d7269632d66756e2d6c6f76696e672e6a7067, 3, 3, 4, 4, 3, 2, 3, 4, 5, 4, 'United Kingdom', '8 to 14', '38.1 to 45.72', '4.56 to 5.89', 'large'),
(51, 'Colorpoint Shorthair', 'Cat', 'The Colorpoint Shorthair is a Siamese of a different color—non-traditional colors, that is.  The breed was developed using Siamese as the foundation and then crossing it with a red American Shorthair to bring in a new color. That was successful and attractive, and the cats became the basis for a new breed: the Colorpoint Shorthair.  Eventually, other non-traditional colors were created. The breed was recognized by the Cat Fanciers Association in 1964. The International Cat Association considers the Colorpoint a variety of Siamese, not a separate breed.', 0x313638383432393430335f646f776e6c6f616420283135292e6a706567, 4, 4, 4, 4, 2, 5, 2, 3, 5, 2, 'United Kingdom', '12 to 17', '12.7 to 30.48', '2.57 to 4.53', 'small'),
(52, 'Cyprus', 'Cat', 'According to feline lore, the Cyprus cat is an ancient breed that has been living in the mountains of the Mediterranean island of Cyprus for so long that they actually predate Egyptian cats by around 4,000 years!\r\n\r\nBack in the 4th Century, the Cyprus cat breed was said to be imported to a Byzantine monastery in a bid to get on top of an infestation of snakes and vermin. Due to the breed’s history of originating from mountainous regions, it’s rare to see a Cyprus living closer to the water.', 0x313638383432393538345f646f776e6c6f616420283135292e6a706567, 4, 4, 3, 4, 2, 5, 2, 5, 4, 5, 'Cyprus', '12 to 15', '33.02 to 35.56', '3.67 to 7.26', 'medium'),
(53, 'American Curl', 'Cat', 'The American Curl is one of the youngest cat breeds. It was born of a natural genetic mutation that first appeared in Shulamith, a stray black kitten with long, silky hair and, strangely, ears that curled backward. She found her way to the welcoming door of Joe and Grace Ruga in Lakewood, California. The Rugas named her Shulamith after the “black and comely” princess in the Old Testament book the Song of Solomon.', 0x313638383432393730365f616d65726963616e2d6375726c2d66756c6c2d70726f66696c652d686973746f72792d616e642d636172652d343730353937322d6865726f2d32633962646366626133643834313330623865656432333363343663313964332e6a7067, 4, 4, 4, 4, 3, 4, 4, 4, 5, 2, 'United States', '12 to 16', '22.86 to 30.48', '2.27 to 4.54', 'small');
INSERT INTO `breed` (`breedID`, `name`, `type`, `description`, `breed_image`, `kid_friendly`, `pet_friendly`, `stranger_friendly`, `affection`, `grooming`, `playfulness`, `shedding`, `energy_level`, `intelligence`, `vocality`, `origin`, `life_span`, `length`, `weight`, `size`) VALUES
(54, 'Himalayan', 'Cat', 'The Himalayan, or Himmie for short, is a Persian in Siamese drag. Unlike its parent breeds the Persian and the Siamese, which are considered natural breeds, meaning they weren’t created through human intervention, the Himalayan is a man-made breed developed by crossing Persians with Siamese to bring in the color points and blue eyes of the Siamese. Breeders began to work toward this goal in 1931, at first simply to determine how the colorpoint gene was passed on. Through selective breeding over a period of years, cat breeder Virginia Cobb and Harvard Medical School researcher Clyde Keeler developed longhaired cats with the distinctive colorpoints of the Siamese. The first kitten to be called a Himalayan was named Newton’s Debutante.', 0x313638383432393835315f6361742d6272656564732d68696d616c6179616e2d77686974652d30322d363030783634382e6a70672e6f7074696d616c2e6a7067, 2, 2, 2, 3, 4, 1, 5, 4, 4, 2, 'United States', '9 to 15', '43.18 to 48.26', '3.18 to 5.44', 'large'),
(55, 'Napoleon', 'Cat', 'The Napoleon cat is a mixed breed cat–a cross between the Munchkin and Persian cat breeds. Loving, playful, and sweet, these felines inherited some of the best traits from their parents.\r\n\r\nThis mixed breed is also sometimes known as the Minuet cat. You can find these cats in shelters and breed specific rescues, so remember to always adopt! Don’t shop if you’re looking to add one of these kitties to your home!', 0x313638383432393938335f64353931663136662d643032392d313165622d623664382d3537303561393131306539322e6a7067, 5, 4, 4, 3, 3, 4, 3, 3, 4, 4, 'United States', '9 to 15', '17.78 to 22.86', '2.27 to 4.08', 'small'),
(56, 'Thai', 'Cat', 'The Thai cat is a natural breed of cat, which means they developed without the need for human intervention. These felines are known for being sociable, talkative, and friendly.\r\n\r\nThai cats are also called Wichienmaat or Old-Style Siamese cats. You may find them in shelters and rescues, so remember to always adopt! Don’t shop if you’re looking to add a Thai to your home!', 0x313638383433303131325f646f776e6c6f616420283136292e6a706567, 4, 4, 4, 4, 1, 4, 2, 3, 4, 2, 'Thailand', '12 to 16', '27.94 to 35.56', '3.63 to 6.8', 'medium'),
(57, 'LaPerm', 'Cat', 'When a brown tabby barn cat named Speedy produced a litter of kittens in The Dalles, Oregon, in 1982, one of them was bald, with tabby markings on her skin, and big ears that were spaced wide apart. She looked like a little alien from outer space. When her coat began to develop, she looked even more different: it was curly. And that was the name she was given by owner Linda Koehl.\r\n\r\nCurly eventually produced her own kittens by various males in the area, including a Siamese and a Manx. All of her kittens shared their mother’s curly coat, the result of a dominant mutation.', 0x313638383433303232325f646f776e6c6f616420283137292e6a706567, 4, 4, 4, 4, 2, 5, 2, 3, 4, 4, 'United States', '10 to 15', '30.48 to 34.29', '3.62 to 4.99', 'medium'),
(58, 'American Bobtail', 'Cat', 'Bobtailed cats, the result of a natural genetic mutation that causes a shortened tail, have appeared in various places over the centuries, from Japan to the Isle of Man. Sometimes they get noticed by the right people, and voila! A new breed is born. Such was the case with the American Bobtail, which descends from a short-tailed kitten acquired by John and Brenda Sanders during a vacation to Arizona. They named him Yodi, and he became the father of the breed in the swinging ‘60s when he had his way with the Sanders’ female, Mishi, once they arrived back home in Iowa.', 0x313638383433303333355f616d65726963616e2d626f627461696c2d6361742d62726565642d39663332646132373133333634376462393266346465636339336137316536642e6a7067, 4, 4, 4, 4, 2, 4, 4, 3, 4, 4, 'Canada', '11 to 15', '38.1 to 43.18', '3.63 to 6.36', 'large'),
(59, 'Norwegian Forest', 'Cat', 'The gentle and friendly Norwegian Forest Cat — Wegie, for short — is fond of family members but does not demand constant attention and petting.\r\n\r\nThis cat tolerates being left home alone, but make sure they have plenty of places to climb and survey their domain. They’ll do a fairly good job of keeping themselves busy.', 0x313638383433303435395f332d436f6c6f7265645f4e6f7277656769616e5f466f726573745f4361742e6a7067, 2, 4, 4, 3, 3, 3, 4, 4, 2, 3, 'Norway', '12 to 16', '43.18 to 48.26', '5.90 to 9.98', 'large'),
(60, 'Desert Lynx', 'Cat', 'The Desert Lynx is a mixed breed cat–a cross between a number of other breeds including the American Lynx, Maine Coon, and Pixie Bob, and possibly even the bobcat. These felines are known for being outgoing, playful, and social.\r\n\r\nYou may find these cats in shelters and breed specific rescues, so if possible, remember to adopt! Don’t shop if you’re looking to add one of these cats to your home!', 0x313638383433303536325f6465736572742d636174686c656e652e6a7067, 4, 4, 3, 4, 2, 4, 1, 5, 4, 3, 'United States', '13 to 15', '30.48 to 35.56', '3.63 to 5.44', 'medium'),
(61, 'Maine Coon', 'Cat', 'The Maine Coon, a native New Englander, originates from the state of Maine, where they actively served as popular mousers, farm cats, and very likely even served as ship’s cats dating back to the early 19th century.\r\n\r\nOne striking feature that immediately catches your attention is the sheer size of the breed —they are truly massive! Fun fact: a Maine Coon holds the record for being the world’s longest house cat, measuring over four feet in length.', 0x313638383433303730335f65762d626c6f672d6d61696e65636f6f6e2d6865616465722d31303234783638332e6a7067, 5, 5, 2, 3, 2, 4, 4, 3, 3, 2, 'United States', '9 to 15', '76.2 to 101.6', '4.08 to 8.16', 'large'),
(62, 'Sokoke', 'Cat', 'The Sokoke is a natural cat breed cat, which means they developed without the need for human intervention These felines are known for being athletic, intelligent, and sociable.\r\n\r\nThe breed’s name comes from the Arabuko Sokoke Forest in Kenya. You may find these cats in shelters and rescues, so remember to always adopt! Don’t shop if you’re looking to add one of these cats to your home!', 0x313638383433303834375f536f6b6f6b652d4361742d383030783530302e6a706567, 5, 4, 3, 4, 2, 4, 1, 4, 4, 3, 'Kenya', '9 to 15', '43.18 to 47', '4.72 to 5.54', 'large'),
(63, 'Savannah', 'Cat', 'A hybrid of a domestic feline and a medium-size African wild cat, the Savannah is a challenging and rewarding companion.\r\n\r\nIf you want a low-energy cat to snuggle all day while you binge on Netflix, think twice about adopting a Savannah cat. This breed has lots of energy and needs physical and mental stimulation.', 0x313638383433303938305f536176616e6e61685f6361742d5f392e6a7067, 4, 5, 5, 5, 2, 5, 3, 4, 4, 5, 'United States', '17 to 20', '38.1 to 48.26', '3.63 to 9.1', 'large'),
(64, 'Aphrodite Giant', 'Cat', 'The Aphrodite Giant is a natural cat breed, which means they developed without the need for human intervention. These felines are known for being gentle, loving, and intelligent.\r\n\r\nYou may find these cats in shelters and breed specific rescues, so remember to always adopt! Don’t shop if you’re looking to add one of these sweet kitties to your home!', 0x313638383433313038385f646f776e6c6f616420283138292e6a706567, 5, 4, 4, 4, 3, 4, 4, 4, 4, 3, 'Cyprus', '12 to 15', '30.48 to 40.64', '2.72 to 6.8', 'medium'),
(65, 'dog1', 'Dog', 'dog', 0x313638383435343033385f64312e6a706567, 3, 3, 3, 3, 3, 4, 4, 5, 1, 4, 'American Samoa', '1 to 2', '1 to 2', '1 to 2', 'small');

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `clinicID` int(20) NOT NULL,
  `name` varchar(70) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `area` varchar(40) NOT NULL,
  `address` varchar(60) NOT NULL,
  `clinic_image` mediumblob DEFAULT NULL,
  `cover` mediumblob DEFAULT NULL,
  `work_day` varchar(80) NOT NULL,
  `open_time` varchar(70) NOT NULL,
  `close_time` varchar(70) NOT NULL,
  `discount_percent` float NOT NULL DEFAULT 0,
  `description` varchar(1000) NOT NULL,
  `no_of_patient` int(5) NOT NULL DEFAULT 0,
  `vetID` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`clinicID`, `name`, `phone`, `email`, `state`, `area`, `address`, `clinic_image`, `cover`, `work_day`, `open_time`, `close_time`, `discount_percent`, `description`, `no_of_patient`, `vetID`) VALUES
(1, 'Clinic UTeM', '07124214124', 'b032010100@student.utem.edu.my', 'Kelantan', 'Tanah Merah', '23,jalan abcdef', 0x313638383433343939375f696d6167657320283137292e6a706567, 0x313638383433353032315f696d6167657320283138292e6a706567, 'Monday,Tuesday,Wednesday', '11:00,10:30,10:30', '23:30,22:30,22:30', 10, 'This is clinic 1 in Kelantan', 6, 1),
(2, 'Clinic UTM', '07124214124', 'b032010100@student.utem.edu.my', 'Kedah', 'Baling', '23,jalan abcdef', 0x313639303939363238385f646f776e6c6f616420283234292e6a706567, 0x313638383435363333305f636c69322e6a706567, 'Sunday,Monday,Tuesday', '20:30,08:28,16:38', '22:28,20:28,21:38', 10, 'this is clinic', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_appointment`
--

CREATE TABLE `clinic_appointment` (
  `appointmentID` int(20) NOT NULL,
  `clinicID` int(20) NOT NULL,
  `adopterID` int(20) DEFAULT NULL,
  `petID` int(20) DEFAULT NULL,
  `vetID` int(20) DEFAULT NULL,
  `date` date NOT NULL,
  `time` varchar(30) NOT NULL,
  `booking_date` datetime NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_appointment`
--

INSERT INTO `clinic_appointment` (`appointmentID`, `clinicID`, `adopterID`, `petID`, `vetID`, `date`, `time`, `booking_date`, `description`, `status`) VALUES
(1, 2, NULL, 1, 3, '2023-07-10', '08:28 am - 09:13 am', '2023-07-04 15:34:17', 'i want vaccine', 'Completed'),
(2, 1, NULL, 4, 1, '2023-08-15', '12:45 pm - 01:30 pm', '2023-08-03 09:23:05', 'vaccine needed', 'Completed'),
(3, 1, NULL, 7, 1, '2023-08-21', '11:00 am - 11:45 am', '2023-08-17 04:27:42', '', 'Completed'),
(5, 1, NULL, 15, 1, '2023-08-29', '12:00 pm - 12:45 pm', '2023-08-23 16:43:33', 'qwqwq', 'Completed'),
(8, 1, 4, NULL, 1, '2023-08-28', '04:15 pm - 05:00 pm', '2023-08-23 17:09:46', 'yyy', 'Completed'),
(9, 1, NULL, 13, 1, '2023-08-29', '09:45 pm - 10:30 pm', '2023-08-23 17:31:20', 'sell', 'Completed'),
(11, 1, NULL, 18, 2, '2024-05-29', '12:00 pm - 12:45 pm', '2024-05-17 01:47:05', 'vaccine', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_payment`
--

CREATE TABLE `clinic_payment` (
  `paymentID` int(20) NOT NULL,
  `transactionID` varchar(30) NOT NULL,
  `recordID` int(20) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic_payment`
--

INSERT INTO `clinic_payment` (`paymentID`, `transactionID`, `recordID`, `amount`, `date`) VALUES
(1, '93G81686RL266704M', 1, 1170, '2023-07-04'),
(2, '61D120018W273743W', 2, 495, '2023-08-03'),
(3, '5SD36303WE4128414', 5, 550, '2023-08-23'),
(4, '4P068748MX8762435', 4, 405, '2023-08-23'),
(5, '6DC777172A376041M', 6, 650, '2023-08-23'),
(6, '16U429024S254562F', 7, 1080, '2024-05-17');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `inquiryID` int(20) NOT NULL,
  `petID` int(20) NOT NULL,
  `adopterID` int(20) NOT NULL,
  `question1` varchar(150) NOT NULL,
  `question2` varchar(60) NOT NULL,
  `question3` varchar(200) NOT NULL,
  `question4` varchar(10) NOT NULL,
  `question5` varchar(10) NOT NULL,
  `question6` varchar(100) NOT NULL,
  `question7` varchar(10) NOT NULL,
  `question8` varchar(10) NOT NULL,
  `question9` varchar(10) NOT NULL,
  `question10` varchar(400) DEFAULT NULL,
  `submit_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`inquiryID`, `petID`, `adopterID`, `question1`, `question2`, `question3`, `question4`, `question5`, `question6`, `question7`, `question8`, `question9`, `question10`, `submit_date`, `status`) VALUES
(2, 1, 4, 'yes', 'doctor', 'working', 'yes', 'own', 'house', 'yes', 'yes', 'yes', 'i want adopt', '2023-07-04', 'Complete'),
(3, 4, 4, 'Yes', 'Doctor', 'working', 'yes', 'own', 'house', 'yes', 'yes', 'yes', 'i love this pet', '2023-08-03', 'Complete'),
(4, 7, 4, 'Yes', 'Doctor', 'Working', 'yes', 'own', 'Condominium', 'yes', 'yes', 'yes', 'This jindo so cute', '2023-08-11', 'Complete'),
(5, 12, 4, 'yes', 'student', 'study', 'yes', 'own', 'house', 'yes', 'yes', 'yes', 'This dog so cute', '2023-08-21', 'Rejected'),
(6, 14, 4, 'Yes', 'Doctor', 'Work', 'yes', 'own', 'House', 'yes', 'yes', 'yes', 'I love this', '2023-08-23', 'Rejected'),
(7, 15, 4, 'yes', 'doctor', 'work', 'yes', 'own', 'House', 'yes', 'yes', 'yes', 'I love this pet', '2023-08-23', 'Complete'),
(8, 12, 4, 'qwe', 'qwe', 'qwe', 'yes', 'own', 'qwe', 'yes', 'yes', 'yes', 'qweqw', '2023-09-20', 'Rejected'),
(9, 16, 4, 'qwe', 'qwe', 'qwe', 'yes', 'own', 'qwe', 'yes', 'yes', 'yes', 'qweqw', '2023-09-20', 'Complete'),
(10, 12, 4, 'qwe', 'qwe', 'qwe', 'yes', 'own', 'qwe', 'yes', 'yes', 'yes', 'qweqwe', '2023-09-20', 'Rejected'),
(11, 3, 4, 'yes', 'doctor', 'work', 'yes', 'own', 'house', 'yes', 'yes', 'yes', 'i want adopt', '2023-09-20', 'Rejected'),
(12, 18, 5, 'yes', 'doctor', 'good', 'yes', 'own', 'house', 'yes', 'yes', 'yes', '', '2024-05-17', 'Rejected'),
(13, 18, 5, 'yes', 'yes', 'yes', 'yes', 'own', 'house', 'yes', 'yes', 'yes', '', '2024-05-17', 'Complete'),
(14, 19, 5, 'yes', 'doctor', 'good', 'yes', 'own', 'apartment', 'yes', 'yes', 'yes', '', '2024-05-17', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageID` int(20) NOT NULL,
  `adopterID` int(7) DEFAULT NULL,
  `sellerID` int(7) DEFAULT NULL,
  `shopID` int(7) DEFAULT NULL,
  `vetID` int(7) DEFAULT NULL,
  `content` varchar(200) NOT NULL,
  `time` datetime DEFAULT NULL,
  `sender` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `adopterID`, `sellerID`, `shopID`, `vetID`, `content`, `time`, `sender`) VALUES
(1, 1, NULL, 1, NULL, 'Hi , im benjamin', '2023-07-04 09:11:58', 'user'),
(2, 1, NULL, 1, NULL, 'im shop1', '2023-07-04 09:12:14', 'non-user'),
(3, 1, 1, NULL, NULL, 'im ben', '2023-07-04 09:19:17', 'user'),
(4, 1, 1, NULL, NULL, 'im seller1', '2023-07-04 09:19:28', 'non-user'),
(5, 1, NULL, NULL, 1, 'im benjamin', '2023-07-04 09:44:29', 'user'),
(6, 1, NULL, NULL, 1, 'im clinic admin 1', '2023-07-04 09:44:39', 'non-user'),
(7, 1, 1, NULL, NULL, 'hi', '2023-07-04 12:09:31', 'non-user'),
(8, 1, 1, NULL, NULL, 'hi', '2023-07-04 12:09:35', 'user'),
(9, 4, 1, NULL, NULL, 'hi im adopter', '2023-07-04 15:09:20', 'user'),
(10, 1, 1, NULL, NULL, 'hi', '2023-07-04 15:09:32', 'non-user'),
(11, 4, 1, NULL, NULL, 'hi', '2023-07-04 15:09:49', 'non-user'),
(12, 4, 1, NULL, NULL, 'hi', '2023-08-03 09:12:37', 'user'),
(13, 4, 1, NULL, NULL, 'ok', '2023-08-03 09:12:41', 'non-user'),
(14, 4, 1, NULL, NULL, '....', '2023-08-23 16:31:44', 'non-user'),
(15, 4, 1, NULL, NULL, '?', '2023-08-23 16:31:49', 'user'),
(17, 5, NULL, NULL, 1, 'hihi', '2024-05-16 23:37:48', 'user'),
(18, 5, NULL, NULL, 1, 'aaa', '2024-05-16 23:38:33', 'user'),
(19, 5, NULL, NULL, 1, 'bbb', '2024-05-16 23:38:36', 'user'),
(20, 5, NULL, NULL, 1, 'qwe', '2024-05-16 23:50:38', 'user'),
(21, 5, NULL, NULL, 1, 'qwe', '2024-05-16 23:50:39', 'user'),
(22, 5, NULL, NULL, 1, 'qwe', '2024-05-16 23:50:44', 'user'),
(23, 5, NULL, NULL, 1, 'a', '2024-05-16 23:50:56', 'user'),
(24, 5, NULL, NULL, 1, '111', '2024-05-16 23:52:44', 'user'),
(25, 5, NULL, NULL, 1, 'a', '2024-05-17 00:02:26', 'user'),
(26, 5, NULL, NULL, 4, 'ermmm', '2024-05-17 00:07:35', 'user'),
(27, 5, NULL, NULL, 4, 'hi', '2024-05-17 00:08:34', 'user'),
(28, 0, NULL, NULL, 2, '', '2024-05-17 01:01:30', 'non-user'),
(29, 0, NULL, NULL, 2, '', '2024-05-17 01:01:30', 'non-user'),
(30, 5, 1000, NULL, NULL, 'hi', '2024-05-17 01:24:23', 'user'),
(31, 5, 1000, NULL, NULL, 'helo', '2024-05-17 01:24:33', 'non-user'),
(32, 5, 1000, NULL, NULL, 'i', '2024-05-17 01:28:22', 'non-user'),
(33, 5, NULL, NULL, 1, '..', '2024-05-17 01:42:14', 'non-user');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `oID` int(20) NOT NULL,
  `oname` varchar(50) NOT NULL,
  `url` varchar(400) NOT NULL,
  `logo` mediumblob NOT NULL,
  `category` varchar(70) NOT NULL,
  `description` varchar(1500) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_method` varchar(70) NOT NULL,
  `minimum` int(5) NOT NULL,
  `adminID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`oID`, `oname`, `url`, `logo`, `category`, `description`, `payment_type`, `payment_method`, `minimum`, `adminID`) VALUES
(1, 'World Wildlife Fund (WWF)', 'https://www.wwf.org.my/how_you_can_help/donate_now/', 0x313638383433313439365f646f776e6c6f61642e706e67, 'Conservation Efforts', 'The WWF is one of the largest and most well-known conservation organizations in the world. They work to protect endangered species and their habitats, promote sustainable development, and combat climate change.', 'Monthly Payment & One-Time Payment', 'Card,Bank,Paypal,Others', 50, 1),
(2, 'IUCN', 'https://www.iucn.org/get-involved', 0x313638383433313636325f5468652d496e7465726e6174696f6e616c2d556e696f6e2d666f722d436f6e736572766174696f6e2d6f662d4e61747572652e706e67, 'Conservation Efforts', 'The IUCN is a global organization that assesses the conservation status of species, identifies conservation priorities, and provides scientific expertise to guide conservation efforts worldwide. They maintain the IUCN Red List, which is a comprehensive inventory of the conservation status of species.', 'Monthly Payment & One-Time Payment', 'Card,Bank,Paypal,Others', 40, 1),
(3, 'Wildlife Conservation Society (WCS)', 'https://malaysia.wcs.org/', 0x313638383433313833305f5743535f4c4f474f545950455f3430307833303070782e6a7067, 'Conservation Efforts', 'The WCS is dedicated to conserving the world`s largest wild places in 14 priority regions, focusing on protecting endangered species and their habitats. They also work to promote wildlife research, education, and sustainable development.', 'Monthly Payment & One-Time Payment', 'Card,Bank,Paypal,Others', 50, 1),
(4, 'Sea Shepherd Conservation Society', 'https://seashepherd.org/', 0x313638383433313931375f5365615f53686570686572645f436f6e736572766174696f6e5f536f63696574795f4c6f676f2e6a7067, 'Conservation Efforts,Animal Rescue and Adoption', 'Sea Shepherd is an international marine conservation organization that focuses on protecting and preserving marine ecosystems and wildlife. They are known for their direct action campaigns to stop illegal fishing, poaching, and other threats to marine life.', 'One-Time Payment', 'Card,Bank,Paypal', 200, 1),
(5, 'International Fund for Animal Welfare (IFAW)', 'https://www.ifaw.org/international', 0x313638383433323030365f646f776e6c6f616420283139292e6a706567, 'Conservation Efforts,Animal Rescue and Adoption', 'The IFAW works to improve the welfare of animals around the world through rescue and rehabilitation efforts, advocating for stronger animal protection laws, and supporting community-based conservation initiatives.', 'Monthly Payment & One-Time Payment', 'Card,Paypal', 240, 1),
(6, 'The Jane Goodall Institute', 'https://janegoodall.org/', 0x313638383433323134335f313633363937333733393139372e6a706567, 'Conservation Efforts,Animal Rescue and Adoption', 'Founded by renowned primatologist Dr. Jane Goodall, this organization is dedicated to wildlife research, conservation, and animal welfare, with a particular focus on chimpanzees and their habitats. They work to protect endangered species, support community-based conservation initiatives, and promote animal welfare and environmental education.', 'Monthly Payment & One-Time Payment', 'Card,Bank,Paypal', 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `petID` int(20) NOT NULL,
  `type` varchar(5) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` date DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `description` varchar(800) NOT NULL,
  `pet_image` mediumblob DEFAULT NULL,
  `img1` mediumblob DEFAULT NULL,
  `img2` mediumblob DEFAULT NULL,
  `img3` mediumblob DEFAULT NULL,
  `img4` mediumblob DEFAULT NULL,
  `img5` mediumblob DEFAULT NULL,
  `img6` mediumblob DEFAULT NULL,
  `video` longblob DEFAULT NULL,
  `vaccinated` varchar(10) DEFAULT NULL,
  `spayed` varchar(10) DEFAULT NULL,
  `price` float NOT NULL,
  `purpose` varchar(30) NOT NULL,
  `availability` char(1) NOT NULL,
  `return_date` date DEFAULT NULL,
  `breedID` int(20) DEFAULT NULL,
  `sellerID` int(20) DEFAULT NULL,
  `shopID` int(20) DEFAULT NULL,
  `adopterID` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`petID`, `type`, `gender`, `birthday`, `color`, `description`, `pet_image`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `video`, `vaccinated`, `spayed`, `price`, `purpose`, `availability`, `return_date`, `breedID`, `sellerID`, `shopID`, `adopterID`) VALUES
(1, 'Dog', 'Male', '2023-04-11', 'white', 'Find a potential adopter...', 0x313638383433323931315f486f6b6b6169646f2d48756e642e6a7067, 0x313638383433323931315f50433032303332352e6a7067, 0x313638383433323934315f646f776e6c6f616420283230292e6a706567, NULL, NULL, NULL, NULL, 0x313638383433323931315f, 'Yes', 'Yes', 200, 'Rehome', 'Y', NULL, 21, NULL, 1, 4),
(2, 'Cat', 'Male', '2023-06-06', 'Brown And White', 'Selling this cat', 0x313638383433333034335f32323070782d41656765616e5f6361742e6a7067, 0x313638383433333037355f696d6167657320283133292e6a706567, 0x313638383433333037355f3336305f465f3530313338383036305f7670444853454553596b3364424561504a3661685a69555850365a506d4146692e6a7067, NULL, NULL, NULL, NULL, 0x313638383433333034335f, 'Yes', 'Yes', 2000, 'Sell', 'Y', '0000-00-00', 35, NULL, 1, NULL),
(3, 'Dog', 'Female', '2023-06-13', 'Black And White', 'Selling this alaskan klee kei', 0x313638383433333730315f616c61736b616e2d6b6c65652d6b61692d312e6a706567, 0x313638383433333730315f696d6167657320283135292e6a706567, 0x313638383433333730315f646f776e6c6f616420283232292e6a706567, NULL, NULL, NULL, NULL, 0x313638383433333730315f, 'No', 'No', 3000, 'Rehome', 'Y', '0000-00-00', 6, 1, NULL, NULL),
(4, 'Dog', 'Male', '2023-05-16', 'brown', 'Find a adopter for my bulldog', 0x313638383433333831355f646f776e6c6f616420283233292e6a706567, 0x313638383433333831355f696d6167657320283136292e6a706567, 0x313639303939363834385f646f776e6c6f616420283235292e6a706567, 0x313639303939363834385f6765747479696d616765732d3135343330363938372d313636373331353838332e6a7067, NULL, NULL, NULL, 0x313638383433333831355f, 'Yes', 'Yes', 50, 'Rehome', 'Y', NULL, 11, 1, NULL, 4),
(7, 'Dog', 'Male', '2023-05-24', 'Golden', 'This is JINDO!!!', 0x313639313638393932365f6a696e646f342e6a706567, 0x313639313638393932365f6a696e646f332e6a7067, 0x313639313638393932365f6a696e646f322e6a7067, 0x313639313638393932365f4a696e646f446f674a696e646f735075726562726564446f6773416e67656c612e6a706567, NULL, NULL, NULL, 0x313639313638393932365f, 'Yes', 'Yes', 100, 'Rehome', 'Y', NULL, 24, 1, NULL, 4),
(12, 'Dog', 'Female', '2023-06-05', 'Black And White', 'This is Toy Fox Terrier', 0x313639323535363137395f746f792d666f782d746572726965722d70726f66696c652d67726173732d3435363538323130362d323030302d64343164363736353361363234393837396537383166623430643035623735622e6a7067, 0x313639323535363137395f546f79466f78546572726965724765747479496d616765732d313137383138303136335365726765795279756d696e2d3862386362333461363430363435343138356464656561393762386130633435202831292e6a7067, 0x313639323535363137395f746f792d666f782d746572726965722d636172642d6c617267652e6a7067, NULL, NULL, NULL, NULL, 0x313639323535363137395f, 'Yes', 'Yes', 300, 'Rehome', 'Y', '0000-00-00', 33, 1, NULL, NULL),
(13, 'Cat', 'Male', '2023-06-18', 'Silver', 'This is british shorthair cat', 0x313639323535363335355f696d6167657320283233292e6a706567, 0x313639323535363335355f313238342e6a706567, 0x313639323535363335355f696d6167657320283234292e6a706567, NULL, NULL, NULL, NULL, 0x313639323535363335355f, 'Yes', 'Yes', 3000, 'Sell', 'Y', '0000-00-00', 40, 1, NULL, 4),
(14, 'Cat', 'Female', '2023-04-05', 'Brown And White', 'This is America Wirehair', 0x313639323535363437375f416d65726963616e2057697265686169722e312e6a7067, 0x313639323535363437375f677261792b616e642b77686974652b416d65726963616e2b776972656861697265642b6361742b6c79696e672b6f6e2b77686974652b7265666c6563746976652b7461626c652d6d696e2e6a7067, NULL, NULL, NULL, NULL, NULL, 0x313639323535363437375f, 'Yes', 'Yes', 1500, 'Rehome', 'Y', '0000-00-00', 36, 1, NULL, NULL),
(15, 'Cat', 'Male', '2023-08-15', 'W', 'qw', 0x313639323737353135395f50433032303332352e6a7067, NULL, NULL, NULL, NULL, NULL, NULL, 0x313639323737353135395f, 'Yes', 'Yes', 1, 'Lodging', 'N', '2023-08-30', 35, 1, NULL, 4),
(16, 'Cat', 'Female', '2023-09-12', 'Black And White', 'Cornish rex for lodging', 0x313639353134333231335f646f776e6c6f616420283237292e6a706567, NULL, NULL, NULL, NULL, NULL, NULL, 0x313639353134333231335f, 'Yes', 'Yes', 20, 'Lodging', 'N', '2023-10-19', 42, 1, NULL, 4),
(17, 'Cat', 'Male', '2024-05-01', 'Black And White', 'qqq', 0x313731353838303233305f696d6167657320283235292e6a706567, 0x313731353838303233305f696d6167657320283235292e6a706567, NULL, NULL, NULL, NULL, NULL, 0x313731353837363337395f, 'Yes', 'Yes', 1, 'Sell', 'Y', '0000-00-00', 42, 1000, NULL, 5),
(18, 'Dog', 'Female', '2024-05-07', 'White', 'testing\r\n', 0x313731353838303631395f696d6167657320283236292e6a706567, 0x313731353838303631395f696d6167657320283236292e6a706567, NULL, NULL, NULL, NULL, NULL, 0x313731353838303631395f, 'Yes', 'Yes', 100, 'Rehome', 'Y', '0000-00-00', 31, 1000, NULL, 5),
(19, 'Cat', 'Male', '2024-05-01', 'Brown', 'test\r\n', 0x313731353933333237385f3132303070782d4361745f4175677573745f323031302d342e6a7067, 0x313731353933333237385f3132303070782d4361745f4175677573745f323031302d342e6a7067, NULL, NULL, NULL, NULL, NULL, 0x313731353933333237385f, 'Yes', 'Yes', 100, 'Rehome', 'Y', '0000-00-00', 50, 1000, NULL, NULL);

--
-- Triggers `pet`
--
DELIMITER $$
CREATE TRIGGER `InsertColorUpperCase` BEFORE INSERT ON `pet` FOR EACH ROW BEGIN
    DECLARE str VARCHAR(255);
    DECLARE new_color VARCHAR(255);
    DECLARE i INT DEFAULT 1;
    DECLARE space_found BOOL DEFAULT FALSE;

    SET str = NEW.color;
    SET new_color = '';

    WHILE i <= LENGTH(str) DO
        IF MID(str, i, 1) = ' ' THEN
            SET space_found = TRUE;
            SET new_color = CONCAT(new_color, MID(str, i, 1));
        ELSE
            IF space_found OR i = 1 THEN
                SET new_color = CONCAT(new_color, UPPER(MID(str, i, 1)));
            ELSE
                SET new_color = CONCAT(new_color, LOWER(MID(str, i, 1)));
            END IF;
            
            SET space_found = FALSE;
        END IF;

        SET i = i + 1;
    END WHILE;

    SET NEW.color = new_color;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateColorUpperCase` BEFORE UPDATE ON `pet` FOR EACH ROW BEGIN
    DECLARE str VARCHAR(255);
    DECLARE new_color VARCHAR(255);
    DECLARE i INT DEFAULT 1;
    DECLARE space_found BOOL DEFAULT FALSE;

    SET str = NEW.color;
    SET new_color = '';

    WHILE i <= LENGTH(str) DO
        IF MID(str, i, 1) = ' ' THEN
            SET space_found = TRUE;
            SET new_color = CONCAT(new_color, MID(str, i, 1));
        ELSE
            IF space_found OR i = 1 THEN
                SET new_color = CONCAT(new_color, UPPER(MID(str, i, 1)));
            ELSE
                SET new_color = CONCAT(new_color, LOWER(MID(str, i, 1)));
            END IF;
            
            SET space_found = FALSE;
        END IF;

        SET i = i + 1;
    END WHILE;

    SET NEW.color = new_color;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pet_payment`
--

CREATE TABLE `pet_payment` (
  `paymentID` int(20) NOT NULL,
  `transactionId` varchar(70) DEFAULT NULL,
  `adopterID` int(20) NOT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_time` varchar(30) DEFAULT NULL,
  `book_date` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `complete_date` datetime DEFAULT NULL,
  `petID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_payment`
--

INSERT INTO `pet_payment` (`paymentID`, `transactionId`, `adopterID`, `visit_date`, `visit_time`, `book_date`, `status`, `complete_date`, `petID`) VALUES
(1, '9Y326578543840311', 4, '2023-07-18', '03:45 pm - 04:30 pm', '2023-07-04 15:13:37', 'Complete', '2023-07-04 15:21:06', 1),
(2, '15B22533PE168880V', 4, '2023-08-15', '11:00 am - 11:45 am', '2023-08-03 09:17:10', 'Complete', '2023-08-03 09:18:38', 4),
(5, '6HA24612L3296670S', 4, '2023-08-21', '02:15 pm - 03:00 pm', '2023-08-12 01:20:54', 'Complete', '2023-08-12 01:34:24', 7),
(6, '817654262P9292322', 4, '2023-08-28', '02:15 pm - 03:00 pm', '2023-08-23 16:30:31', 'Complete', '2023-08-23 16:37:37', 15),
(7, '64N56258AC471622F', 4, '2023-08-29', '11:45 am - 12:30 pm', '2023-08-23 16:51:51', 'complete', '2023-08-23 16:52:57', 13),
(8, '7AN05297A1344925V', 4, '2023-09-26', '11:00 am - 11:45 am', '2023-09-20 01:07:48', 'Complete', '2023-09-20 01:12:10', 16),
(10, '6UJ69343A3671824U', 5, '2024-05-19', '06:29 am - 07:14 am', '2024-05-17 01:27:30', 'complete', '2024-05-17 01:29:03', 17),
(12, '81761481CE3705830', 5, '2024-05-26', '03:29 am - 04:14 am', '2024-05-17 01:36:28', 'Complete', '2024-05-17 01:37:20', 18);

-- --------------------------------------------------------

--
-- Table structure for table `pet_shop`
--

CREATE TABLE `pet_shop` (
  `shopID` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `shopname` varchar(40) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `state` varchar(30) NOT NULL,
  `area` varchar(40) NOT NULL,
  `address` varchar(60) NOT NULL,
  `shop_image` mediumblob DEFAULT NULL,
  `work_day` varchar(80) NOT NULL,
  `open_time` varchar(70) NOT NULL,
  `close_time` varchar(70) NOT NULL,
  `email` varchar(30) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `cover` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_shop`
--

INSERT INTO `pet_shop` (`shopID`, `username`, `password`, `shopname`, `phone`, `state`, `area`, `address`, `shop_image`, `work_day`, `open_time`, `close_time`, `email`, `description`, `cover`) VALUES
(1, 'shop1', '202cb962ac59075b964b07152d234b70', 'Shop UTeM', '0108020455', 'Melaka', 'Alor Gajah', '23,jalan abcdef', 0x313638383433323733325f696d6167657320283132292e6a706567, 'Sunday,Monday,Tuesday,Thursday', '10:00,10:00,12:00,10:00', '20:00,19:00,19:00,20:00', 'ONGPEIKANG57@HOTMAIL.COM', 'This is pet shop in Melaka', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `recordID` int(20) NOT NULL,
  `appointmentID` int(20) NOT NULL,
  `pet_name` varchar(30) DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `comment` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `extra` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`recordID`, `appointmentID`, `pet_name`, `discount`, `comment`, `date`, `extra`) VALUES
(1, 1, 'oyen', 10, 'this pet ', '2023-07-04', 'dental check^1000^1^check'),
(2, 2, 'Oyen', 10, 'This pet so cute', '2023-08-03', 'cleaning^100^1^clean'),
(3, 3, 'cat1', 10, 'OK.', '2023-08-21', 'Dental Cleaning^70^1^Clean mouth'),
(4, 5, 'Ong PK', 10, 'wwww', '2023-08-23', NULL),
(5, 8, 'alex tan', 0, 'no dis', '2023-08-23', 'cc^100^1^cc'),
(6, 9, 'sell', 0, 'sell', '2023-08-23', 'cccc^100^2^cccc'),
(7, 11, 'qiwawa', 10, 'good good', '2024-05-17', 'Check^100^1^body check');

--
-- Triggers `record`
--
DELIMITER $$
CREATE TRIGGER `increment_patient_count` AFTER INSERT ON `record` FOR EACH ROW BEGIN
    UPDATE clinic
    SET no_of_patient = no_of_patient + 1
    WHERE clinicID = (SELECT clinicID FROM vet WHERE vetID = (SELECT ca.vetID FROM record r,clinic_appointment ca WHERE ca.appointmentID=r.appointmentID AND recordID = NEW.recordID));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `sellerID` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `state` varchar(30) NOT NULL,
  `area` varchar(40) NOT NULL,
  `address` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `available` varchar(80) NOT NULL,
  `start` varchar(70) NOT NULL,
  `end` varchar(70) NOT NULL,
  `image` mediumblob DEFAULT NULL,
  `cover` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`sellerID`, `username`, `password`, `firstName`, `lastName`, `dob`, `state`, `area`, `address`, `phone`, `email`, `description`, `available`, `start`, `end`, `image`, `cover`) VALUES
(1, 'seller1', '202cb962ac59075b964b07152d234b70', 'Ali', 'Ahmad', '2004-06-07', 'Johor', 'Batu Pahat', '1B,Jalan Dato Syed Esa,Taman Pantai', '010802344', 'ongpeikang57@hotmail.com', 'Im seller1', 'Monday,Tuesday,Wednesday', '12:00,10:15,10:15', '20:00,21:15,21:15', 0x313638383433333439305f696d6167657320283134292e6a706567, 0x313638383433333531365f646f776e6c6f616420283231292e6a706567),
(1000, 'ssss', '202cb962ac59075b964b07152d234b70', 'Sell', 'Sell', '2024-04-30', 'Terengganu', 'Dungun', '100,Jalan Esa,', '0108020433', 'ongpeikang57@hotmail.com', 'hihi', 'Sunday', '01:14', '18:14', NULL, NULL),
(1001, 'aaaa', '202cb962ac59075b964b07152d234b70', 'Alice', 'Alice', '2024-05-05', 'Putrajaya', 'Putrajaya', '100,Jalan Esa,', '0108020433', 'ongpeikang57@hotmail.com', 'test', 'Sunday', '06:33', '20:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `treatmentID` int(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `unit_price` float NOT NULL,
  `clinicID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatmentID`, `name`, `description`, `unit_price`, `clinicID`) VALUES
(1, 'Vaccinations', 'Routine vaccinations are crucial for preventing various infectious diseases in pets. Vaccines help build immunity and protect animals against common viruses and bacteria.', 50, 1),
(2, 'Dental Cleaning', 'Dental cleanings involve a thorough examination and professional cleaning of a pet`s teeth to remove tartar, plaque, and treat dental issues. It helps maintain oral health and prevent dental diseases.', 300, 1),
(3, 'Spay/Neuter Surgery', 'Spaying (for females) and neutering (for males) are surgical procedures to sterilize pets, preventing unwanted pregnancies and reducing certain health risks. It is a common procedure performed in vete', 400, 1),
(4, 'vaccine', 'give vaccine', 100, 2),
(5, 'Dental Cleaning and Polishing', 'This treatment includes a thorough dental examination, cleaning of tartar and plaque, and polishing to maintain your pet`s oral health and hygiene.', 250, 2),
(6, 'Spaying or Neutering', 'This surgical procedure helps control pet overpopulation and offers health benefits by preventing certain diseases. Spaying is for females, while neutering is for males.', 300, 2);

-- --------------------------------------------------------

--
-- Table structure for table `treatment_record`
--

CREATE TABLE `treatment_record` (
  `recordID` int(20) NOT NULL,
  `treatmentID` int(20) NOT NULL,
  `quantity` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_record`
--

INSERT INTO `treatment_record` (`recordID`, `treatmentID`, `quantity`) VALUES
(1, 4, 3),
(2, 1, 1),
(2, 3, 1),
(3, 1, 1),
(3, 3, 1),
(4, 1, 1),
(4, 3, 1),
(5, 1, 1),
(5, 3, 1),
(6, 1, 1),
(6, 3, 1),
(7, 2, 1),
(7, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vet`
--

CREATE TABLE `vet` (
  `vetID` int(20) NOT NULL,
  `clinicID` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `ic` varchar(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `apc` varchar(200) NOT NULL,
  `education` varchar(1800) DEFAULT NULL,
  `experience` varchar(1800) DEFAULT NULL,
  `area` varchar(150) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vet`
--

INSERT INTO `vet` (`vetID`, `clinicID`, `username`, `password`, `ic`, `name`, `email`, `apc`, `education`, `experience`, `area`, `phone`, `image`) VALUES
(1, 1, 'clinic1', '202cb962ac59075b964b07152d234b70', '000123456789', 'Ong PeiKang', 'ONGPEIKANG57@HOTMAIL.COM', '1688434032_1682965283_Enterpre-week5.pdf', '2021-2023^Master`s Degree^UTeM$2017-2021^Bachelor`s Degree^UTM', NULL, 'Prevention Care,Nutrition and diet,End-of-life care', '0108020455', 0x313638383433343936315f34313830383433335f6c2d373035783437302e6a7067),
(2, 1, 'vet1', '202cb962ac59075b964b07152d234b70', '000123654789', 'Tan Ah Beng', 'ONGPEIKANG57@HOTMAIL.COM', '1688434386_1682965283_Enterpre-week5.pdf', NULL, NULL, 'Surgery,End-of-life care,Diagnostic services,Rehabilitation', '0708020455', NULL),
(3, 2, 'clinic2', '202cb962ac59075b964b07152d234b70', '000719010657', 'OngPeiKang', 'ONGPEIKANG57@HOTMAIL.COM', '1688455708_1682965283_Enterpre-week5.pdf', '2000-2004^phd^UTeM$2005-2008^abc^UTM(JB)', NULL, 'Prevention Care,Surgery,Nutrition and diet,Emergency and critical care,End-of-life care,Diagnostic services,Rehabilitation', '0108020455', NULL),
(4, 2, 'vet2', '202cb962ac59075b964b07152d234b70', '000719453628', 'Ong Pei kk', 'ongpeikang57@hotmail.com', '1688455873_1682965283_Enterpre-week5.pdf', NULL, NULL, 'Prevention', '0108203455', NULL),
(5, 1, 'PeiK', '202cb962ac59075b964b07152d234b70', 'C.000879627483', 'OngPeiKang', 'ongpeikang57@hotmail.com', '1691776202_Reply_Form-ong pei kang.pdf', NULL, NULL, 'Prevention', '012142242', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vet_treatment`
--

CREATE TABLE `vet_treatment` (
  `vetID` int(20) NOT NULL,
  `treatmentID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vet_treatment`
--

INSERT INTO `vet_treatment` (`vetID`, `treatmentID`) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 3),
(3, 4),
(3, 5),
(3, 6),
(4, 4),
(4, 5),
(4, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `adopter`
--
ALTER TABLE `adopter`
  ADD PRIMARY KEY (`adopterID`);

--
-- Indexes for table `breed`
--
ALTER TABLE `breed`
  ADD PRIMARY KEY (`breedID`);

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`clinicID`);

--
-- Indexes for table `clinic_appointment`
--
ALTER TABLE `clinic_appointment`
  ADD PRIMARY KEY (`appointmentID`),
  ADD KEY `clinicID` (`clinicID`),
  ADD KEY `adopterID` (`adopterID`),
  ADD KEY `petID` (`petID`),
  ADD KEY `vetID` (`vetID`);

--
-- Indexes for table `clinic_payment`
--
ALTER TABLE `clinic_payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `FK_clinic_payment3` (`recordID`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`inquiryID`),
  ADD KEY `petID` (`petID`),
  ADD KEY `adopterID` (`adopterID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`oID`),
  ADD KEY `FK_organization` (`adminID`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`petID`),
  ADD KEY `FK_pet1` (`breedID`),
  ADD KEY `FK_pet2` (`sellerID`),
  ADD KEY `FK_pet3` (`adopterID`),
  ADD KEY `FK_pet4` (`shopID`);

--
-- Indexes for table `pet_payment`
--
ALTER TABLE `pet_payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `FK_pet_payment2` (`adopterID`),
  ADD KEY `FK_pet_payment3` (`petID`);

--
-- Indexes for table `pet_shop`
--
ALTER TABLE `pet_shop`
  ADD PRIMARY KEY (`shopID`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `appointmentID` (`appointmentID`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`sellerID`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`treatmentID`),
  ADD KEY `clinicID` (`clinicID`);

--
-- Indexes for table `treatment_record`
--
ALTER TABLE `treatment_record`
  ADD PRIMARY KEY (`recordID`,`treatmentID`),
  ADD KEY `FK_treatment_record1` (`recordID`),
  ADD KEY `FK_treatment_record2` (`treatmentID`);

--
-- Indexes for table `vet`
--
ALTER TABLE `vet`
  ADD PRIMARY KEY (`vetID`),
  ADD KEY `FK_vet` (`vetID`);

--
-- Indexes for table `vet_treatment`
--
ALTER TABLE `vet_treatment`
  ADD PRIMARY KEY (`vetID`,`treatmentID`),
  ADD KEY `FK_vet_treatment1` (`vetID`),
  ADD KEY `FK_vet_treatment2` (`treatmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adopter`
--
ALTER TABLE `adopter`
  MODIFY `adopterID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `breed`
--
ALTER TABLE `breed`
  MODIFY `breedID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `clinicID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clinic_appointment`
--
ALTER TABLE `clinic_appointment`
  MODIFY `appointmentID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `clinic_payment`
--
ALTER TABLE `clinic_payment`
  MODIFY `paymentID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `inquiryID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `oID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `petID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pet_payment`
--
ALTER TABLE `pet_payment`
  MODIFY `paymentID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pet_shop`
--
ALTER TABLE `pet_shop`
  MODIFY `shopID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3000;

--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `recordID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `sellerID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `treatmentID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vet`
--
ALTER TABLE `vet`
  MODIFY `vetID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5000;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clinic_appointment`
--
ALTER TABLE `clinic_appointment`
  ADD CONSTRAINT `clinic_appointment_ibfk_1` FOREIGN KEY (`clinicID`) REFERENCES `clinic` (`clinicID`),
  ADD CONSTRAINT `clinic_appointment_ibfk_2` FOREIGN KEY (`adopterID`) REFERENCES `adopter` (`adopterID`),
  ADD CONSTRAINT `clinic_appointment_ibfk_3` FOREIGN KEY (`petID`) REFERENCES `pet` (`petID`),
  ADD CONSTRAINT `clinic_appointment_ibfk_4` FOREIGN KEY (`vetID`) REFERENCES `vet` (`vetID`);

--
-- Constraints for table `clinic_payment`
--
ALTER TABLE `clinic_payment`
  ADD CONSTRAINT `FK_clinic_payment3` FOREIGN KEY (`recordID`) REFERENCES `record` (`recordID`);

--
-- Constraints for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD CONSTRAINT `inquiry_ibfk_1` FOREIGN KEY (`petID`) REFERENCES `pet` (`petID`),
  ADD CONSTRAINT `inquiry_ibfk_2` FOREIGN KEY (`adopterID`) REFERENCES `adopter` (`adopterID`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `FK_organization` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`);

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `FK_pet1` FOREIGN KEY (`breedID`) REFERENCES `breed` (`breedID`),
  ADD CONSTRAINT `FK_pet2` FOREIGN KEY (`sellerID`) REFERENCES `seller` (`sellerID`),
  ADD CONSTRAINT `FK_pet3` FOREIGN KEY (`adopterID`) REFERENCES `adopter` (`adopterID`),
  ADD CONSTRAINT `FK_pet4` FOREIGN KEY (`shopID`) REFERENCES `pet_shop` (`shopID`);

--
-- Constraints for table `pet_payment`
--
ALTER TABLE `pet_payment`
  ADD CONSTRAINT `FK_pet_payment2` FOREIGN KEY (`adopterID`) REFERENCES `adopter` (`adopterID`),
  ADD CONSTRAINT `fk_pp_pet` FOREIGN KEY (`petID`) REFERENCES `pet` (`petID`) ON DELETE CASCADE;

--
-- Constraints for table `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `record_ibfk_1` FOREIGN KEY (`appointmentID`) REFERENCES `clinic_appointment` (`appointmentID`);

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`clinicID`) REFERENCES `clinic` (`clinicID`);

--
-- Constraints for table `treatment_record`
--
ALTER TABLE `treatment_record`
  ADD CONSTRAINT `FK_treatment_record1` FOREIGN KEY (`recordID`) REFERENCES `record` (`recordID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_treatment_record2` FOREIGN KEY (`treatmentID`) REFERENCES `treatment` (`treatmentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vet_treatment`
--
ALTER TABLE `vet_treatment`
  ADD CONSTRAINT `FK_vet_treatment1` FOREIGN KEY (`vetID`) REFERENCES `vet` (`vetID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_vet_treatment2` FOREIGN KEY (`treatmentID`) REFERENCES `treatment` (`treatmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vet_treatment_ibfk_1` FOREIGN KEY (`vetID`) REFERENCES `vet` (`vetID`),
  ADD CONSTRAINT `vet_treatment_ibfk_2` FOREIGN KEY (`treatmentID`) REFERENCES `treatment` (`treatmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
