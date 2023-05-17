-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2022 at 05:21 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scientia_library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `first_name`, `last_name`) VALUES
(2, 'Stephen', 'King'),
(3, 'Haruki', 'Murakami'),
(4, 'George', 'Orwell'),
(5, 'Marcus', 'Aurelius'),
(6, 'Mario', 'Puzo'),
(12, 'Ei', 'Maung'),
(13, 'Paula', 'Hawkins'),
(14, 'Anonymous', '');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `pages` int(11) NOT NULL,
  `edition` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `publication_year` int(11) NOT NULL,
  `description` text NOT NULL,
  `language` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cover` text NOT NULL,
  `e_file` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_title`, `isbn`, `pages`, `edition`, `author_id`, `publisher_id`, `genre_id`, `publication_year`, `description`, `language`, `quantity`, `cover`, `e_file`) VALUES
(2, '1984', '0141036141', 326, 2, 4, 1, 4, 1987, 'Winston Smith works for the Ministry of truth in London, chief city of Airstrip One. Big Brother stares out from every poster, the Thought Police uncover every act of betrayal. When Winston finds love with Julia, he discovers that life does not have to be dull and deadening, and awakens to new possibilities. Despite the police helicopters that hover and circle overhead, Winston and Julia begin to question the Party; they are drawn towards conspiracy. Yet Big Brother will not tolerate dissent - even in the mind. For those with original thoughts they invented Room 101 . . .', 'English', 1, 'Book Images/_1984.jpg', NULL),
(8, 'Kafka on the Shore', '1400079276', 505, 1, 3, 1, 5, 2005, 'Kafka on the Shore is powered by two remarkable characters: a teenage boy, Kafka Tamura, who runs away from home either to escape a gruesome oedipal prophecy or to search for his long-missing mother and sister; and an aging simpleton called Nakata, who never recovered from a wartime affliction and now is drawn toward Kafka for reasons that, like the most basic activities of daily life, he cannot fathom.\r\n\r\nAs their paths converge, and the reasons for that convergence become clear, Haruki Murakami enfolds readers in a world where cats talk, fish fall from the sky, and spirits slip out of their bodies to make love or commit murder. Kafka on the Shore displays one of the world\'s great storytellers at the peak of his powers.', 'English', 1, 'Book Images/_kafka-on-the-shore.jpg', NULL),
(9, 'Meditations', '0140449337', 112, 1, 5, 3, 1, 1997, 'Written in Greek by the only Roman emperor who was also a philosopher, without any intention of publication, the Meditations of Marcus Aurelius offer a remarkable series of challenging spiritual reflections and exercises developed as the emperor struggled to understand himself and make sense of the universe. While the Meditations were composed to provide personal consolation and encouragement, Marcus Aurelius also created one of the greatest of all works of philosophy: a timeless collection that has been consulted and admired by statesmen, thinkers and readers throughout the centuries.', 'English', 1, 'Book Images/_meditations.jpg', NULL),
(10, 'The Godfather', '0451167716', 576, 2, 6, 2, 6, 1983, 'When Mario Puzo\'s blockbuster saga, The Godfather, was first published in 1969, critics hailed it as one of the greatest novels of our time, and \"big, turbulent, highly entertaining.\" Since then, The Godfather has gone on to become a part of America\'s national culture, as well as a trilogy of landmark motion pictures. Now, in this newly-repackaged 30th Anniversary Edition, readers old and new can experience this timeless tale of crime for themselves.From the lavish opening scene where Don Corleone entertains guests and conducts business at his daughter\'s wedding...to his son, Michael, who takes his father\'s place to fight for his family...to the bloody climax where all family business is finished, The Godfather is an epic story of family, loyalty, and how \"men of honor\" live in their own world, and die by their own laws.', 'English', 1, 'Book Images/_Book-jacket-The-Godfather-Mario-Puzo.png', NULL),
(18, 'API', '1234879276', 114, 1, 12, 5, 8, 2020, 'Introduction to API', 'Burmese', 3, 'Book Images/_Screenshot 2022-08-10 111053.png', 'Book Files/_API-book-by-Ei-Maung.pdf'),
(19, 'The Girl on the Train', '978735219755', 395, 1, 13, 3, 9, 2015, 'The Girl on the Train is a 2015 psychological thriller novel by British author Paula Hawkins that gives narratives from three different women about relationship troubles and, for the main protagonist, alcoholism.', 'English', 5, 'Book Images/_images.jpg', NULL),
(20, 'Into the Water', '9780735211209', 400, 1, 13, 1, 3, 2017, '“Into the Water” is set in the rural British town of Beckford, an extremely unhealthy habitat for women. Beckford has cliffs, a bridge, a river and a drowning pool.', 'English', 4, 'Book Images/_images (1).jpg', NULL),
(21, 'Journal Writing Task 2', '5000000002', 130, 1, 14, 2, 1, 2015, 'The IELTS Academic/General Training Writing Test takes 60 minutes. You have\r\nto complete two writing tasks. In writing task 2 you must either argue, that is,\r\nyou must present an opinion and give reasons to support your opinions or\r\nexpress the causes or consequences of a situation. Sometimes you should\r\neither predict what might happen in the future or give solutions to a problem.', 'English', 4, 'Book Images/_Screenshot 2022-08-29 095616.png', 'Book Files/_Journal Writing Task2.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `borrow_id` varchar(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`borrow_id`, `member_id`, `issue_date`, `due_date`) VALUES
('BO-000001', 2, '2022-09-24', '2022-10-08'),
('BO-000002', 1, '2022-09-24', '2022-10-08'),
('BO-000003', 1, '2022-09-24', '2022-10-08'),
('BO-000004', 1, '2022-09-24', '2022-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_details`
--

CREATE TABLE `borrow_details` (
  `borrow_id` varchar(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrow_details`
--

INSERT INTO `borrow_details` (`borrow_id`, `book_id`, `status`) VALUES
('BO-000001', 18, 'borrowed'),
('BO-000002', 2, 'returned'),
('BO-000003', 10, 'returned'),
('BO-000004', 20, 'borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_title`) VALUES
(1, 'Non-Fiction'),
(2, 'Detective'),
(3, 'Mystery'),
(4, 'Science-Fiction'),
(5, 'Fantasy'),
(6, 'Crime'),
(7, 'Story'),
(8, 'Programming'),
(9, 'Thriller');

-- --------------------------------------------------------

--
-- Table structure for table `librarians`
--

CREATE TABLE `librarians` (
  `librarian_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `nrc_no` varchar(100) NOT NULL,
  `phone_no` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `librarians`
--

INSERT INTO `librarians` (`librarian_id`, `first_name`, `last_name`, `gender`, `nrc_no`, `phone_no`, `email`, `password`, `address`, `dob`, `role`) VALUES
(1, 'Admin', 'Man', 'Male', '12/LaMaTa(N)111333', '09777888999', 'admin@example.com', '0192023a7bbd73250516f069df18b500', 'Yangon', '1984-07-02', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `profile` text NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nrc_no` varchar(20) NOT NULL,
  `phone_no` varchar(11) NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `payment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `first_name`, `last_name`, `profile`, `gender`, `email`, `password`, `nrc_no`, `phone_no`, `dob`, `address`, `payment`) VALUES
(1, 'Milo', 'Wang', 'Profile/_viber_image_2021-08-04_11-54-03-215.jpg', 'Male', 'milo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '12/MaLaTa(N)437212', '09988784322', '2001-02-04', 'Yangon', 'Payment/_viber_image_2021-08-13_22-25-36-415.jpg'),
(2, 'Karry', 'Wang', 'Profile/_IWTEYP1.jpg', 'Male', 'karry@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '12/LaTaNa(N)437212', '09764290882', '1999-02-05', 'Yangon', 'Payment/_Wallpaper.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(11) NOT NULL,
  `publisher_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `publisher_name`, `address`, `phone_no`) VALUES
(1, 'Vintage International', 'United Kingdom', '09112334556'),
(2, 'Penguin Books', 'United Kingdom', '09345678901'),
(3, 'Dover Publications', 'United States', '431301304'),
(5, 'Fairway', 'Myanmar', '09988222222'),
(6, 'dd', 'dd', '09988222222');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `total_quntity` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `purchase_status` varchar(255) NOT NULL,
  `librarian_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `purchase_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `purchase_price` int(11) NOT NULL,
  `purchase_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `address`, `phone_no`) VALUES
(2, 'Sarpaylawka', 'Yangon', '09111222333'),
(3, 'Big Bad Wolf', 'Thailand', '09444555666'),
(5, 'dd', 'dd', '1231234523');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`borrow_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `librarians`
--
ALTER TABLE `librarians`
  ADD PRIMARY KEY (`librarian_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `librarians`
--
ALTER TABLE `librarians`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
