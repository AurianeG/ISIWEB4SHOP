/*Jeu de test pour la base de données Web4Shop*/

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'john', '$2y$10$rJe4PMHnLhpg8/NxsHsXpeFgGx9ytQ1KUvjm58j0RkMkPRKozxaja');
/*mdp : azerty*/


INSERT INTO `customers` (`id`, `forname`, `surname`, `add1`, `phone`, `email`, `registered`) VALUES
(1, 'Sarah', 'Hamida', 47 , '0612345678', 's.hamida@gmail.com', 1);
INSERT INTO `customers` (`id`, `forname`, `surname`, `add1`, `add2`, `phone`, `email`, `registered`) VALUES
(2, 'Jean-Benoît', 'Delaroche', 48, 49, '0796321458', 'jb.delaroche@gmx.fr', 1);


INSERT INTO `delivery_addresses` (`id`, `firstname`, `lastname`, `add1`, `add2`, `city`, `postcode`, `pays`) VALUES
(47, 'Sarah', 'Hamida', '5 rue de jean', '', 'Meximieux', '01800', 'Espagne'),
(48, 'Jean-Benoît', 'Delaroche', '10 chemin petit', '', 'Lyon', '69009', 'France'),
(49, 'Louise', 'Delaroche', '12 rue du grand chemin', '2 eme etage', 'Lyon', '69009', 'France');


INSERT INTO `logins` (`id`, `customer_id`, `username`, `password`) VALUES
(1, 1, 'Hamidou', '$2y$10$rY9s9qjijhCtncH3pMztieyG1IhK/0nQEnn/WC6k1JmJLfLOxm3AW'),
(2, 2, 'Delaroche', '$2y$10$Kx4mS96pzqeJLdXbi7canOrQ8jG/v8JGeOkkss.bjD1lLZB0W1aZi');
/*hamidou : titi
delaroche : toto*/


INSERT INTO `orderitems` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(235, 63, 14, 1),
(236, 63, 17, 2),
(237, 63, 19, 1),
(238, 63, 11, 3),
(239, 64, 10, 1),
(240, 64, 18, 1),
(241, 64, 20, 1),
(242, 65, 9, 1),
(243, 65, 15, 2),
(244, 65, 16, 1),
(245, 66, 23, 1),
(246, 66, 24, 1);


INSERT INTO `orders` (`id`, `customer_id`, `registered`, `delivery_add_id`, `payment_type`, `date`, `status`, `session`, `total`) VALUES
(63, '1', 1, 47, 'cheque', '2020-01-23', 1, 'da8bcdf51121d96c71673295b825a010', 86.2),
(64, '1', 1, 47, 'paypal', '2020-01-23', 0, 'da8bcdf51121d96c71673295b825a010', 87),
(65, '2', 1, 48, 'cheque', '2020-01-23', 0, 'da8bcdf51121d96c71673295b825a010', 51.2),
(66, '2', 1, 48, 'cheque', '2020-01-23', 2, 'da8bcdf51121d96c71673295b825a010', 42.3);


INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `image`, `price`, `quantity_stock`) VALUES
(4, 2, 'Assortiment de biscuits secs', 'Boîte de 20 biscuits composée de galettes, cookies, crêpes dentelles et sablés', 'assortimentBiscuitsSecs.jpg', 12.90, 0),
(5, 2, 'Biscuits de Noël', 'De doux biscuits de Noël à la cannelle, au chocolat, et sablés pour assurer de belles et uniques fêtes de Noël', 'biscuitNoel.png', 10.50, 3),
(6, 2, 'Biscuits aux raisins ', 'De délicieux biscuits aux raisins secs pour éveiller les sens de toute la famille, des plus petits aux plus grands !', 'biscuitRaisin.jpeg', 6.90, 2),
(7, 3, 'Pruneaux secs bio ', 'Sachet de 500g. De délicieux pruneaux issus d agricultures biologiques et responsables ', 'pruneauxSecs.jpg', 7.90, 6),
(8, 3, 'Sachet d\'abricots secs ', 'Sachet d\'un kilogramme. Produit recommandé par de nombreux nutritionnistes. Authentique goût d\'abricot', 'abricotsSecs.jpg', 15.50, 17),
(9, 3, 'Plateau de fruits secs ', 'Plateau de 1kg composé d\'abricots secs, de noix de cajous, pruneaux secs, bananes sèches, copeaux de noix de coco...', 'plateauFruitsSecs.jpg', 32.00, 6),
(10, 3, 'Mélange de fruits secs', 'Composés de différents sachets de 250g : des marrons, des cacahouètes, des amandes grillés et des noisettes.', 'melangeMarrons.jpg', 25.00, 7),
(11, 3, 'Mélange de noisettes', 'Sachet de 500g composé de noisettes, noix et amandes grillées. Une fois goûtés, on ne peut plus s\'en passer', 'melangeNoisettes.png', 8.30, 4),
(12, 3, 'Sachet d\'amandes grillées', 'Sachet de 500g, grillées lentement au four pour plus de plaisir en bouche lors de la dégustation !', 'amandes.jpg', 9.90, 10),
(13, 1, 'Jus de citron', 'Bouteille d\'un litre de jus de citron frais issus d\'agricultures responsables et biologiques', 'jusCitron.jpg', 5.20, 3),
(14, 1, 'Jus de pommes', 'Pommes issues d\'agricultures biologiques.\r\nBouteille d\'un litre dans une bouteille en verre ', 'jusPomme.jpg', 3.20, 8),
(15, 1, 'Jus de pamplemousse', 'Bouteille d\'un litre et demi sans sucre et sans colorant ajoutés. 100% naturel au bon goût de pamplemousse', 'jusPamplemousse.jpg', 7.30, 7),
(16, 1, 'Jus d\'orange', 'Oranges provenant d\'agricultures locales et biologiques.\r\nCette bouteille d\'un litre permet de se réveiller en douceur le matin.', 'jusOrange.jpg', 4.60, 19),
(17, 1, 'Sachet de café en grain', 'sachet d\'un kilogramme de café en grain, pour garder l\'authentique goût du café pour bien commencer la journée', 'cafeGrain.jpg', 15.00, 10),
(18, 1, 'Capsules de café', 'Paquet de 50 capsules. Adaptable pour toute sortes de machines à café avec capsules', 'cafeCapsule.jpg', 45.00, 11),
(19, 1, 'Dosettes de café', 'Paquet de 30 dosettes de café. Longue date de conservation. Emballage recyclable respectant l\'environnement', 'dosetteCafe.png', 28.10, 20),
(20, 1, 'Sachets de thé à la canelle', '15 sachets à l\'authentique gout de thé à la cannelle. Nouveauté chez Web4Shop ! ', 'theCannelle.jpg', 10.50, 9),
(21, 1, 'Infusion à la verveine', 'Recommandé pour profiter de nuits calmes.\r\nVendus par paquet de 15 sachets.', 'infusionVerveine.jpg', 8.90, 4),
(22, 1, 'Thé vert', '20 sachets de thé vert. Les adeptes en raffolent et on comprend bien pourquoi ! ', 'theVert.jpg', 13.90, 13),
(23, 1, 'Infusion au citron', 'Paquet de 20 sachets d\'infusion au citron pour partager un moment unique avec les plus petits ou les plus grands', 'infusionCitron.jpg', 15.30, 15),
(24, 2, 'Macarons tout chocolat', 'Macarons uniques au chocolat. Vendus par 10 macarons dans une très belle boîte ', 'macaronChocolat.jpg', 20.50, 18),
(25, 2, 'Boules de neige', 'Boules aromatisées à la noix de coco.\r\nPlateau de 200g. Idée cadeau qui va plaire aux adeptes de la noix de coco !', 'bouleDeNeigeCoco.jpg', 10.80, 8),
(26, 2, 'Cookies au pépites de chocolat', 'Cookies croquants préparés avec de l\'avoine et des pépites de chocolat fondantes.\r\nPaquet de 15 cookies', 'cookiesChocolat.jpg', 12.30, 10),
(27, 2, 'Biscuits étoile à la cannelle', 'Biscuits secs pour noël à l\'authentique goût de la cannelle. L\'éveil des sens avec ces saveurs est assuré !', 'biscuitsCannelle.jpg', 13.50, 14),
(28, 2, 'Biscuits en forme de tortue', 'Paquet de 20 petits biscuits en forme de tortue. Goût chocolat vanille. Leur très jolie forme va séduire tout le monde !', 'biscuitsTortue.jpg', 25.30, 20);


INSERT INTO `reviews` (`id_product`, `id_user`, `photo_user`, `stars`, `title`, `description`) VALUES
(28, 1, 'homme.jpg', 5, 'Trop top', 'Trop beau et trop bon '),
(13, 2, 'femme.png', 3, 'super', 'cool'),
(4, 2, 'femme.png', 5, 'Excellent !', 'Ils sont trop bons, je recommande vraiment ces biscuits secs, je ne peux plus m\'en passer ! '),
(24, 1, 'femme.png', 4, 'Vraiment excellent ', 'Je recommande vivement ces macarons, ils ont un gout authentiques et en plus ils ne sont pas très chers '),
(26, 2, 'homme.jpg', 4, 'Très bon rapport qualité prix', 'Ils sont vraiment excellents. Je ne sais pas cuisiner alors je les achète et on dirait vraiment des cookies faits maison !'),
(26, 2, 'femme.png', 3, 'Je recommande !', 'Vraiment bons et très craquants, j\'en rachèterai '),
(16, 1, 'femme.png', 5, 'Tellement bon ! ', 'Ce jus est incroyablement bon c\'est un plaisir de déjeuner le matin avec un jus d\'orange si frais '),
(23, 2, 'homme.jpg', 3, 'Je suis fan', 'Moi qui suis fan d\'infusion, c\'est vraiment de la qualité ! peut être un peu cher mais vraiment le prix a payer pour bénéficier de si bonnes infusions'),
(15, 2, 'femme.png', 5, 'Tellement bon !!', 'Je recommande vivement, j\'achète toujours ce bon jus et il fait l\'unanimité à la maison'),
(25, 1, 'homme.jpg', 4, 'Bon goût de noix de coco', 'Vraiment bon, pour les fêtes de Noël, chaque années elles sont très appréciées'),
(11, 1, 'homme.jpg', 4, 'Trop bon et livraison rapide', 'Ces fruits secs sont vraiment à croquer, et ils sont très vite virés à la maison '),
(12, 1, 'femme.png', 3, 'Trop bon ! ', 'Les amandes sont vraiment bonnes, le paquet ne fait pas longtemps à la maison ! je recommande '),
(7, 1, 'femme.png', 4, 'Une qualité inégalable', 'Les pruneaux sont vraiment excellents je recommande'),
(21, 2, 'femme.png', 4, 'Des très bonnes infusions', 'Un goût intensément bon et une livraison rapide'),
(6, 1, 'femme.png', 3, 'De très bons biscuits ', 'Vraiment trop bon !! '),
(5, 1, 'femme.png', 4, 'Original', 'Ces biscuits sont excellents; testés récemment! un délice!'),
(4, 2, 'homme.jpg', 5, 'J\'adore', 'Ces biscuits secs sont très bons. ils sont variés et très parfumés; je recommande ce produit.'),
(6, 2, 'homme.jpg', 4, 'une tuerie!', 'les biscuits sont vraiment très bons; très garnis; à tester sans modération!'),
(28, 1, 'femme.png', 5, 'original!', 'si vous voulez opter pour des biscuits Originaux, vous ne serez pas déçus! et en plus, ils sont bons!'),
(27, 2, 'homme.jpg', 5, 'un délice', 'des biscuits très parfumés qui rappellent les biscuits de mon enfance avec ce bon parfum de cannelle! Je vous le recommande...'),
(25, 2, 'femme.png', 3, 'bon', 'Des biscuits assez parfumés, tendre et sucrés juste ce qu\'il faut. bon produit'),
(18, 1, 'homme.jpg', 5, 'très bien', 'des capsules de très bonne qualité; très bon rapport qualité prix; je recommande ce produit'),
(26, 1, 'femme.png', 5, 'comme à la maison', 'excellents biscuits; aussi bons que ceux que l\'on fait soi même!'),
(19, 1, 'femme.png', 5, 'très bon produit', 'des dosettes de très bonne qualité que je recommande'),
(23, 2, 'femme.png', 5, 'bon produit', 'Une infusion excellente pour la digestion. Un gout acidulé et un très bon rapport qualité prix. Je recommande ce produit'),
(21, 2, 'homme.jpg', 4, 'Parfumée', 'Une infusion très parfumée avec un gout authentique! très bon produit!'),
(16, 1, 'femme.png', 5, 'Bon produit', 'ce jus d\'orange est très parfumé. Peu c!alorique, et sans additif; naturel et sa pulpe est agréable. je vous le conseille'),
(13, 2, 'femme.png', 5, 'excellent', 'produit de qualité aussi bien en cuisine que pour désaltérer; je vous invite à l\'essayer!'),
(15, 2, 'femme.png', 4, 'désaltérant', 'très bon produit; sans additif donc très naturel; à essayer sans hésiter!'),
(14,14, 'homme.jpg', 5, 'excellent!', 'Un très bon produit; ce jus a un délicieux gout acidulé; parfait pour un gouter ou pour bien démarrer la journée!'),
(24, 1, 'femme.png', 4, 'savoureux', 'des macarons au top; un produit qui est de très bonne qualité; tendre et fondant dans la bouche; à consommer sans modération\r\n'),
(10, 2, 'femme.png', 4, 'à conseiller', 'un mélange idéal pour le petit déjeuner ou avant l\'effort; les amandes et les noisettes sont excellentes; je recommande'),
(11, 1, 'homme.jpg', 4, 'exquis!', 'des fruits secs de bonne qualité; je recommande ce produit sans hésiter'),
(9, 1, 'femme.png', 5, 'idée cadeau', 'ce plateau très garni et excellent est une très bonne idée cadeau; à savourer sans modération ; je vous invite à essayer!'),
(7, 1, 'homme.jpg', 5, 'avant l\'effort', 'des pruneaux d\'un gros calibre; idéal avant une activité sportive ou simplement en cas de petite faim! je recommande!'),
(8, 2, 'femme.png', 5, 'miam', 'Parfait pour commencer la journée: ces abricots sont excellents; le prix est raisonnable. Je recommande ce produit'),
(12, 2, 'femme.png', 3, 'très bon produit', 'je recommande ces amandes grillées; elles sont grillées à point et complètent agréablement une recette; à essayer!'),
(17, 2, 'femme.png', 5, 'à essayer', 'un café doux et savoureux dans un emballage de qualité. le prix est raisonnable; je recommande!'),
(20, 2, 'homme.jpg', 3, 'bon', 'un produit de qualité; ce thé est parfumé et on apprécie le gout délicat de la cannelle; je vous le recommande.'),
(22, 1, 'homme.jpg', 5, 'délicieux', 'une boisson très parfumée; idéale pour bien démarrer la journée; à essayer les yeux fermés.');

