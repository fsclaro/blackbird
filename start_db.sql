-- MySQL dump 10.13  Distrib 8.0.18, for macos10.14 (x86_64)
--
-- Host: localhost    Database: blackbird
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (16,'App\\User',6,'avatars','avatar','avatar.png','image/png','public',61229,'[]','[]','[]',7,'2019-11-11 15:09:42','2019-11-11 15:09:42'),(17,'App\\User',1,'avatars','super_admin','super_admin.png','image/png','public',22446,'[]','[]','[]',8,'2019-11-11 15:10:12','2019-11-11 15:10:12'),(18,'App\\User',15,'avatars','avatar_022','avatar_022.jpg','image/jpeg','public',5908,'[]','[]','[]',9,'2019-11-14 22:57:22','2019-11-14 22:57:22');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,22),(2,22),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES
(1,'Acesso ao Cadastro de Usuários','user_management_access','2019-10-22 22:57:05','2019-10-24 16:26:53',NULL),
(2,'Criação de permissões','permission_create','2019-10-22 22:57:05','2019-10-24 16:29:49',NULL),
(3,'Edição de Permissões','permission_edit','2019-10-22 22:57:05','2019-10-24 16:31:24',NULL),
(4,'Exibir Detalhes de uma Permissão','permission_show','2019-10-22 22:57:05','2019-10-24 16:33:19',NULL),
(5,'Exclusão de Permissões','permission_delete','2019-10-22 22:57:05','2019-10-24 16:32:52',NULL),
(6,'Acesso ao Cadastro de Permissões','permission_access','2019-10-22 22:57:05','2019-10-24 16:32:34',NULL),
(7,'Criação de Papéis','role_create','2019-10-22 22:57:05','2019-10-24 18:55:35',NULL),
(8,'Edição de Papéis','role_edit','2019-10-22 22:57:05','2019-10-24 18:55:48',NULL),
(9,'Exibir Detalhes do Papel','role_show','2019-10-22 22:57:05','2019-10-24 18:56:07',NULL),
(10,'Exclusão de Papéis','role_delete','2019-10-22 22:57:05','2019-10-24 18:56:26',NULL),
(11,'Acesso ao Cadastro de Papéis','role_access','2019-10-22 22:57:05','2019-10-24 18:56:45',NULL),
(12,'Pode cadastrar um novo usuário','user_create','2019-10-22 22:57:05','2019-10-29 22:39:52',NULL),
(13,'Pode editar os dados de um usuário','user_edit','2019-10-22 22:57:05','2019-10-29 22:40:12',NULL),
(14,'Pode exibir os detalhes de um usuário','user_show','2019-10-22 22:57:05','2019-10-29 22:40:30',NULL),
(15,'Pode excluir um usuário','user_delete','2019-10-22 22:57:05','2019-10-29 22:40:43',NULL),
(16,'Pode acessar o cadastro de usuários','user_access','2019-10-22 22:57:05','2019-10-29 22:40:58',NULL),
(22,'Usuário pode editar o seu perfil','user_profile','2019-10-29 22:38:54','2019-10-29 22:38:54',NULL),
(24,'Acessar a opção de Logs do Site','support_access','2019-10-31 22:07:21','2019-11-01 18:25:31',NULL),
(25,'Acessar o Log-Viewer','log_viewer_access','2019-10-31 22:08:11','2019-10-31 22:08:28',NULL),
(26,'Acessar a listagem de rotas','access_routes','2019-11-01 18:34:11','2019-11-01 18:34:11',NULL),
(27,'Permite acesso ao Route Viewer','route_viewer_access','2019-11-01 21:22:17','2019-11-01 21:22:17',NULL),
(28,'Permite acesso ao Telescope','telescope_viewer_access','2019-11-04 15:06:51','2019-11-04 15:06:51',NULL),
(29,'Acesso ao Cadastro de Parâmetros','parameter_access','2019-11-11 18:12:03','2019-11-11 18:12:03',NULL),
(30,'Criação de Parâmetros','parameter_create','2019-11-11 18:12:42','2019-11-11 18:14:49',NULL),
(31,'Edição de Parâmetros','parameter_edit','2019-11-11 18:13:02','2019-11-11 18:15:10',NULL),
(32,'Exibir Detalhes do Parâmetro','parameter_show','2019-11-11 18:13:39','2019-11-11 18:13:39',NULL),
(33,'Exclusão de Parâmetros','parameter_delete','2019-11-11 18:14:06','2019-11-11 18:14:06',NULL),
(34,'Define os Valores dos Parâmetros','parameter_content','2019-11-13 16:01:42','2019-11-13 22:16:51',NULL),
(35,'Acesso à Administração do Site','site_management','2019-11-22 22:55:59','2019-11-22 22:55:59',NULL),
(36,'Gestão de Acesso','access_management','2019-11-22 22:56:22','2019-11-22 22:56:22',NULL);

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1),(2,2),(5,2),(7,2),(9,1),(8,1),(10,2),(14,1),(13,1),(12,1),(11,1),(15,2),(16,2),(6,2);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','2019-10-22 22:57:05','2019-10-22 22:57:05',NULL),(2,'User','2019-10-22 22:57:05','2019-10-31 18:18:32',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (10,'Brand do Sistema','brand_sistema','blackbird','text',NULL,'Brand que será utilizado na tela de login e acima da barra de menu.','2019-11-14 22:27:36','2019-11-14 22:30:34',NULL),(11,'Brand Curto do Sistema','brand_short','Vul','text',NULL,'Brand que será utilizado quando o menu estiver contraído. Máximo de 3 caracteres.','2019-11-14 22:28:03','2019-11-14 22:30:34',NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `social_identities`
--

LOCK TABLES `social_identities` WRITE;
/*!40000 ALTER TABLE `social_identities` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@blackbird.com',NULL,'$2y$10$imU.Hdz7VauIT3LIMCMbsOXvaaTQg6luVqkhfkBcsUd.SJW2XSRKO',1,'blue',NULL,'2019-10-22 22:57:05','2019-11-20 22:46:55',NULL),(2,'User','user@blackbird.com',NULL,'$2y$10$imU.Hdz7VauIT3LIMCMbsOXvaaTQg6luVqkhfkBcsUd.SJW2XSRKO',1,'blue',NULL,'2019-10-22 22:57:05','2019-11-20 22:47:45',NULL),(5,'Usuário Padrão','usuario@gmail.com',NULL,'$2y$10$1QUIvEGdiX5y2LON.gxEKO7rietz/x2k2pixWjVsnNJuwplc/sYCu',1,'blue',NULL,'2019-10-25 16:38:27','2019-11-20 22:59:35',NULL),(6,'Fernando','fsclaro@gmail.com',NULL,'$2y$10$jYNW8BOA0k82xaqZ1x0X..RnVBiGxHf.Xo1rNbwf3XYm7CLQxBGtS',1,'blue',NULL,'2019-10-25 18:46:53','2019-11-20 22:59:35',NULL),(7,'Juliano da Silva Sauro','sauro@gmail.com',NULL,'$2y$10$Nds/42FKotSHcQy4cX6vkujAaQV7HxA.cIp/LglpGSgLa1QLeZYTW',1,'blue',NULL,'2019-10-26 17:40:48','2019-11-20 22:59:35',NULL),(8,'Pedro','pedro@gmail.com',NULL,'$2y$10$SIL04ea7z/zbBLlYv6sXY.JcbW1HPE1.q9/uLAgXDW6y/9uGFdlgS',1,'blue',NULL,'2019-10-31 15:34:22','2019-11-20 22:59:35',NULL),(9,'Luiza','luiza@gmail.com',NULL,'$2y$10$AZ/PvYxTVDSm2N1diIk0fOG8UtbWVkG1GVfmnlm.v0RdOVplDlw1W',1,'blue',NULL,'2019-10-31 15:55:16','2019-11-20 22:59:35',NULL),(10,'Pedro','pedro1@gmail.com',NULL,'$2y$10$snCVIXBk5RZ8fRYI.76be.pKcja0MKFKWrEsikI9NIvsPrSFMzy6q',1,'blue',NULL,'2019-11-05 17:11:55','2019-11-20 22:59:35',NULL),(11,'Antonio','antonio@gmail.com',NULL,'$2y$10$J0ynVVmdO9WP7ddmWPED/edUe/19SndLNvgqQbUMYWlS4Uqya4pbi',1,'green',NULL,'2019-11-05 17:20:34','2019-11-05 18:09:04',NULL),(12,'Luiz','luiza2@gmail.com',NULL,'$2y$10$IFjuslFodrZTpPi9u7KhOer8DvfgXxV8CxP.K5j/XvotwB/tz.1g.',1,'yellow',NULL,'2019-11-05 17:27:15','2019-11-20 22:59:35',NULL),(13,'Marcio','marcio@gmail.com',NULL,'$2y$10$CUGJ3JwIvVbSCxeJII8rw.WWb3UjOJYpb5BGDBnEg0iULCIhavOFa',1,'blue',NULL,'2019-11-05 17:32:09','2019-11-05 18:07:30',NULL),(14,'Humberto','humberto@gmail.com',NULL,'$2y$10$RmBVmFdxx.Ky29dELBj2Gue2/rwE.MieDaqSk/YkBD9X35ytCnzyu',1,'red',NULL,'2019-11-05 17:33:16','2019-11-05 18:07:13',NULL),(15,'Luiz Carlos','luiz@ead.unitau.com.br',NULL,'$2y$10$pS/c7Ouwr8RBwn6HFLDgHuNRFkYgo3oKQuRn8NhRYMBtrAUtmFvWW',1,'blue',NULL,'2019-11-14 22:57:22','2019-11-20 22:53:14',NULL),(16,'Usuário 8','usuario8@gmail.com',NULL,'$2y$10$DLqyqnm/sDoxPkM8XDbJ2OVQsS1rM.wVxZEbDjG9aqxn8Iz.xEzy2',1,'blue',NULL,'2019-11-22 17:01:24','2019-11-22 17:01:24',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'blackbird'
--

--
-- Dumping routines for database 'blackbird'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-27 21:14:36
