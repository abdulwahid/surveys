SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `surveys` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'survey 1', 'dfvdfvdv dvdf ', NULL, NULL),
(2, 'survey 2', 'cvf fhdgfhfh ', NULL, NULL);



INSERT INTO `categories` (`id`, `name`, `description`, `sort_order`) VALUES
(1, 'category-1', 'CAT1', 1),
(2, 'category-2', 'CAT2', 1),
(3, 'category-3', 'CAT3', 1),
(4, 'category-4', 'CAT4', 1);


INSERT INTO `companies` (`id`, `name`, `description`, `country_id`, `city_id`) VALUES
(1, 'company-1', 'COMPANY1', 2, 1),
(2, 'company-2', 'COMPANY2', 2, 1);

INSERT INTO `departments` (`id`, `company_id`, `name`, `description`, `country_id`, `city_id`) VALUES
(6, 1, 'department-1', 'sadvcv dfg dsfg sfdg', 2, 1),
(7, 1, 'department-2', 'zv ffg f dgfg sg', 2, 1),
(8, 1, 'department-3', 'zv ffg f dgfg sg', 2, 1),
(9, 2, 'department-4', 'zv ffg f dgfg sg', 2, 1),
(10, 2, 'department-5', 'zv ffg f dgfg sg', 2, 1);

INSERT INTO `questions` (`id`, `category_id`, `text`, `sort_order`, `type`, `calculation_type`, `created_at`, `updated_at`) VALUES
(1, 1, 'This is question 1', 1, '', '', NULL, NULL),
(2, 1, 'This is question 2', 4, '', '', NULL, NULL),
(3, 1, 'This is question 3', 2, '', '', NULL, NULL),
(4, 1, 'This is question 4', 1, '', '', NULL, NULL),
(5, 1, 'This is question 5', 3, '', '', NULL, NULL),
(6, 2, 'This is question 6', 1, '', '', NULL, NULL),
(7, 2, 'This is question 7', 1, '', '', NULL, NULL),
(8, 2, 'This is question 8', 1, '', '', NULL, NULL),
(9, 2, 'This is question 9', 1, '', '', NULL, NULL),
(10, 2, 'This is question 10', 1, '', '', NULL, NULL),
(11, 3, 'This is question 11', 1, '', '', NULL, NULL),
(12, 3, 'This is question 12', 1, '', '', NULL, NULL),
(13, 3, 'This is question 13', 1, '', '', NULL, NULL),
(14, 3, 'This is question 14', 1, '', '', NULL, NULL),
(15, 3, 'This is question 15', 1, '', '', NULL, NULL),
(16, 4, 'This is question 16', 1, '', '', NULL, NULL),
(17, 4, 'This is question 17', 1, '', '', NULL, NULL),
(18, 4, 'This is question 18', 1, '', '', NULL, NULL),
(19, 4, 'This is question 19', 1, '', '', NULL, NULL),
(20, 4, 'This is question 20', 1, '', '', NULL, NULL);

INSERT INTO `question_survey` (`id`, `survey_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 4),
(10, 2, 5);

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'role-1', 'ROLE1'),
(2, 'role-2', 'ROLE2'),
(3, 'role-3', 'ROLE3'),
(4, 'role-4', 'ROLE4');

INSERT INTO `coupons` (`id`, `coupon`, `company_id`, `department_id`, `role_id`, `created_at`, `updated_at`) VALUES
(3, 'coupon1', 1, 6, NULL, NULL, NULL),
(4, 'coupon2', 1, 7, 3, NULL, NULL);

INSERT INTO `coupon_survey` (`id`, `coupon_id`, `survey_id`) VALUES
(1, 3, 1),
(2, 4, 2);

INSERT INTO `traits` (`id`, `category_id`, `name`, `description`) VALUES
(1, 1, 'trait-1', 'TRAIT1'),
(2, 1, 'trait-2', 'TRAIT2'),
(3, 2, 'trait-3', 'TRAIT3'),
(4, 2, 'trait-4', 'TRAIT4'),
(5, 2, 'trait-5', 'TRAIT5'),
(6, 3, 'trait-6', 'TRAIT6'),
(7, 3, 'trait-7', 'TRAIT7'),
(8, 4, 'trait-8', 'TRAIT8'),
(9, 4, 'trait-9', 'TRAIT9'),
(10, 4, 'trait-10', 'TRAIT10');

INSERT INTO `answers` (`id`, `question_id`, `trait_id`, `text`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'This is answer 1 for Question 1', 1, NULL, NULL),
(2, 1, 1, 'This is answer 2 for Question 1', 1, NULL, NULL),
(3, 1, 2, 'This is answer 3 for Question 1', 1, NULL, NULL),
(4, 1, 2, 'This is answer 4 for Question 1', 1, NULL, NULL),
(5, 1, NULL, 'This is answer 5 for Question 1', 1, NULL, NULL),
(6, 2, 1, 'This is answer 1 for Question 2', 1, NULL, NULL),
(7, 2, 1, 'This is answer 2 for Question 2', 1, NULL, NULL),
(8, 2, 2, 'This is answer 3 for Question 2', 1, NULL, NULL),
(9, 2, 2, 'This is answer 4 for Question 2', 1, NULL, NULL),
(10, 2, NULL, 'This is answer 5 for Question 2', 1, NULL, NULL),
(11, 3, 1, 'This is answer 1 for Question 3', 1, NULL, NULL),
(12, 3, 1, 'This is answer 2 for Question 3', 1, NULL, NULL),
(13, 3, 2, 'This is answer 3 for Question 3', 1, NULL, NULL),
(14, 3, 2, 'This is answer 4 for Question 3', 1, NULL, NULL),
(15, 3, NULL, 'This is answer 5 for Question 3', 1, NULL, NULL),
(16, 4, 1, 'This is answer 1 for Question 4', 1, NULL, NULL),
(17, 4, 1, 'This is answer 2 for Question 4', 1, NULL, NULL),
(18, 4, 2, 'This is answer 3 for Question 4', 1, NULL, NULL),
(19, 4, 2, 'This is answer 4 for Question 4', 1, NULL, NULL),
(20, 4, NULL, 'This is answer 5 for Question 4', 1, NULL, NULL),
(21, 5, 1, 'This is answer 1 for Question 5', 1, NULL, NULL),
(22, 5, 1, 'This is answer 2 for Question 5', 1, NULL, NULL),
(23, 5, 2, 'This is answer 3 for Question 5', 1, NULL, NULL),
(24, 5, 2, 'This is answer 4 for Question 5', 1, NULL, NULL),
(25, 5, NULL, 'This is answer 5 for Question 5', 1, NULL, NULL),
(26, 6, 3, 'This is answer 1 for Question 6', 1, NULL, NULL),
(27, 6, 4, 'This is answer 2 for Question 6', 1, NULL, NULL),
(28, 6, 5, 'This is answer 3 for Question 6', 1, NULL, NULL),
(29, 6, 6, 'This is answer 4 for Question 6', 1, NULL, NULL),
(30, 6, 7, 'This is answer 5 for Question 6', 1, NULL, NULL),
(31, 7, 3, 'This is answer 1 for Question 7', 1, NULL, NULL),
(32, 7, 4, 'This is answer 2 for Question 7', 1, NULL, NULL),
(33, 7, 5, 'This is answer 3 for Question 7', 1, NULL, NULL),
(34, 7, 6, 'This is answer 4 for Question 7', 1, NULL, NULL),
(35, 7, 7, 'This is answer 5 for Question 7', 1, NULL, NULL),
(36, 8, 3, 'This is answer 1 for Question 8', 1, NULL, NULL),
(37, 8, 4, 'This is answer 2 for Question 8', 1, NULL, NULL),
(38, 8, 5, 'This is answer 3 for Question 8', 1, NULL, NULL),
(39, 8, 6, 'This is answer 4 for Question 8', 1, NULL, NULL),
(40, 8, 7, 'This is answer 5 for Question 8', 1, NULL, NULL),
(41, 9, 8, 'This is answer 1 for Question 9', 1, NULL, NULL),
(42, 9, 8, 'This is answer 2 for Question 9', 1, NULL, NULL),
(43, 9, 9, 'This is answer 3 for Question 9', 1, NULL, NULL),
(44, 9, 9, 'This is answer 4 for Question 9', 1, NULL, NULL),
(45, 9, 10, 'This is answer 5 for Question 9', 1, NULL, NULL),
(46, 10, 8, 'This is answer 1 for Question 10', 1, NULL, NULL),
(47, 10, 8, 'This is answer 2 for Question 10', 1, NULL, NULL),
(48, 10, 9, 'This is answer 3 for Question 10', 1, NULL, NULL),
(49, 10, 10, 'This is answer 4 for Question 10', 1, NULL, NULL),
(50, 10, 10, 'This is answer 5 for Question 10', 1, NULL, NULL),
(51, 11, 8, 'This is answer 1 for Question 11', 1, NULL, NULL),
(52, 11, 9, 'This is answer 2 for Question 11', 1, NULL, NULL),
(53, 11, 9, 'This is answer 3 for Question 11', 1, NULL, NULL),
(54, 11, 10, 'This is answer 4 for Question 11', 1, NULL, NULL),
(55, 11, 10, 'This is answer 5 for Question 11', 1, NULL, NULL);


