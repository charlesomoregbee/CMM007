-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2024 at 12:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chef`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `description`, `ingredients`, `instructions`, `image_url`) VALUES
(1, 'Food recipe for today', 'the meal is made by cup of rice and oat meal and plantain', 'rice, plantain and oatmeal', 'cook with cold water and stryfry', 'uploads/one-skillet-Mediterranean-chicken-recipe-6.jpg'),
(2, 'Prawn fried rice', 'Make this easy Asian-inspired dish in just 30 minutes. It\'s healthy and low in calories but big on flavour, making it perfect for a speedy family supper\n\n', 'Ingredients\n250g long-grain brown rice\n150g frozen peas\n100g mangetout\n1½ tbsp rapeseed oil\n1 onion, finely chopped\n2 garlic cloves, crushed\nthumb-sized piece of ginger, finely grated\n150g raw king prawns\n3 medium eggs, beaten\n2 tsp sesame seeds\n1 tbsp low-salt soy sauce\n½ tbsp rice or white wine vinegar\n4 spring onions, trimmed and sliced', 'Method\nSTEP 1\nCook the rice following pack instructions. Boil a separate pan of water and blanch the peas and mangetout for 1 min, then drain and set aside with the rice.\n\nSTEP 2\nMeanwhile, heat the oil in a large non-stick frying pan or wok over a medium heat and fry the onion for 10 mins or until golden brown. Add the garlic and ginger and fry for a further minute. Tip in the blanched vegetables and fry for 5 mins, then the prawns and fry for a further 2 mins. Stir the rice into the pan then push everything to one side. Pour the beaten eggs into the empty side of the pan and stir to scramble them. Fold everything together with the sesame seeds, soy and vinegar, then finish with the spring onions scattered over.', 'uploads/prawn_fried_rice-2481925.jpg'),
(3, 'Eve\'s pudding', 'Eve\'s pudding is a deliciously comforting combination of stewed apples and sponge. Serve with plenty of custard or cream.', 'Ingredients\r\nFor the filling\r\n2 large cooking apples (about 500g/1lb2oz in total)\r\n1 tbsp lemon juice\r\n20g/¾oz butter\r\n2 tbsp caster sugar\r\nFor the topping\r\n75g/3oz butter\r\n100g/3½oz caster sugar\r\n100g/3½oz self-raising flour\r\n2 free-range eggs, lightly beaten\r\n1 tbsp boiling water\r\nTo serve\r\ncream or custard', 'How-to-videos\r\nMethod\r\nPreheat the oven to 180C/160C Fan/Gas 4.\r\n\r\nPeel, core and roughly chop the apples. Add the apples to a saucepan with the lemon juice and 2 tablespoons water. Stir, cover and cook briskly for five minutes until the apples are soft.\r\n\r\nAdd the butter and caster sugar and stir. Then transfer to a 900ml/1½ pint capacity ceramic gratin dish, about 5cm/2in deep. Leave to cool while you prepare the topping.\r\n\r\nFor the topping, cream together the butter and caster sugar until fluffy and light.\r\n\r\nFold the flour and egg in alternate spoonfuls into the sugar mixture until blended, being careful to keep folding rather than stirring energetically - this will keep air in the mixture and fold in. Add a spoonful of boiling water to the mix.\r\n\r\nSpoon the mixture over the apples. Cook in the oven for 30-35 minutes or until the topping is puffy and golden. Serve with cream or custard.', 'uploads/evespudding_83911_16x9.jpg'),
(4, 'Tuna, caper & chilli spaghetti', 'Throw together tuna, capers and rocket with garlic, chilli and spaghetti to make this easy and healthy supper. It takes just 25 minutes to make', 'Ingredients\r\n150g spaghetti or linguine\r\n1 tbsp olive oil\r\n1 garlic clove, sliced\r\n1 red chilli, deseeded and finely chopped, plus extra to serve (optional)\r\n1 tbsp drained capers\r\nsmall bunch of parsley, finely chopped (stalks included)\r\n145g tuna in spring water, drained\r\n90g rocket or baby spinach leaves\r\n½ lemon, juiced', 'Method\r\nSTEP 1\r\nCook the spaghetti for 9-11 mins in a large pan of well-salted water until al dente.\r\n\r\nSTEP 2\r\nHeat the oil in a wide frying pan over a very low heat, and gently cook the garlic and chilli to infuse the oil. Remove from the heat if the garlic is turning past light golden, as this will make it bitter.\r\n\r\nSTEP 3\r\nDrain the pasta, keeping a cupful of the cooking water, and tip the spaghetti into the frying pan. Toss the pasta in the oil over a low heat, adding a little of the pasta water to emulsify into a sauce that coats the pasta, then fold in the capers, parsley, tuna and some seasoning. Don’t stir too vigorously – you want to keep larger chunks of tuna. Toss the rocket and lemon juice through the spaghetti, and serve with extra chilli scattered over, if you like.', 'uploads/Chow-Mein-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` enum('recipe_seeker','cook','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_role`) VALUES
(1, 'abvictorbassey', 'abvictorbassey@gmail.com', '$2y$10$3.XxlMEsv29mV8qsfCjPkupbIuI5S.3GXw4O5sQ.fBE68ntO1vZUS', 'cook');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
