-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-02-2017 a las 20:22:34
-- Versión del servidor: 5.5.53-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `2daw16_crisdo01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(10) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `oculto` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `cod`, `nombre`, `descripcion`, `oculto`) VALUES
(1, 'port', 'Ordenadores portátiles', 'Ordenadores portátiles para todas las necesidades. Tanto si eres un jugón empedernido, como si lo necesitas para el trabajo.', 0),
(2, 'sma', 'Smartphones', 'Los smartphones son una herramienta indispensable en nuestro día a día. La cantidad de aplicaciones que abarcan nos hacen la vida mucho más fácil.', 0),
(3, 'con', 'Consolas', 'No importa si eres de Sony o de Microsoft. Lo importante es que te diviertas, y que lo hagas en tu videoconsola favorita al mejor precio.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE IF NOT EXISTS `linea_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_producto`,`id_pedido`),
  KEY `fk_linea_pedido_productos1_idx` (`id_producto`),
  KEY `fk_linea_pedido_pedidos1_idx` (`id_pedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Volcado de datos para la tabla `linea_pedido`
--

INSERT INTO `linea_pedido` (`id`, `id_producto`, `id_pedido`, `cantidad`, `precio`) VALUES
(68, 11, 65, 3, 278.00),
(69, 1, 65, 1, 337.00),
(70, 6, 65, 2, 319.00),
(71, 6, 66, 1, 319.00),
(72, 6, 67, 1, 319.00),
(73, 6, 68, 1, 319.00);

--
-- Disparadores `linea_pedido`
--
DROP TRIGGER IF EXISTS `Reduce_Stock`;
DELIMITER //
CREATE TRIGGER `Reduce_Stock` AFTER INSERT ON `linea_pedido`
 FOR EACH ROW update productos
set stock = stock - new.cantidad
where id = new.id_producto
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_usuarios1_idx` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `nombre`, `apellidos`, `direccion`, `email`, `cp`, `estado`, `id_provincia`, `fecha`) VALUES
(65, 4, 'nombre de prueba', 'apellidos de prueba', 'direccion de prueba', 'cristobaldominguez95@hotmail.com', '66666', 'pe', 17, '2017-02-28'),
(66, 4, 'nombre de prueba', 'apellidos de prueba', 'direccion de prueba', 'cristobaldominguez95@hotmail.com', '66666', 'pe', 17, '2017-02-28'),
(67, 4, 'nombre de prueba', 'apellidos de prueba', 'direccion de prueba', 'cristobaldominguez95@hotmail.com', '66666', 'ca', 17, '2017-02-28'),
(68, 4, 'nombre de prueba', 'apellidos de prueba', 'direccion de prueba', 'cristobaldominguez95@hotmail.com', '66666', 'ca', 17, '2017-02-28');

--
-- Disparadores `pedidos`
--
DROP TRIGGER IF EXISTS `Fecha_Pedido`;
DELIMITER //
CREATE TRIGGER `Fecha_Pedido` BEFORE INSERT ON `pedidos`
 FOR EACH ROW set new.fecha = curdate()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(10) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL,
  `descuento` int(2) DEFAULT NULL,
  `imagen` varchar(256) DEFAULT NULL,
  `iva` int(2) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `fecha_ini` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `oculto` tinyint(1) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_categoria`),
  KEY `fk_productos_categorias2_idx` (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `cod`, `nombre`, `precio`, `descuento`, `imagen`, `iva`, `descripcion`, `id_categoria`, `stock`, `fecha_ini`, `fecha_fin`, `oculto`, `destacado`) VALUES
(1, 'B50-50', 'Lenovo Essential B50-50', 278.51, NULL, 'port1', 21, 'Lenovo te presenta si gama Essential B50-50, un portátil con un procesador Intel Core i3 con una resolución de pantalla de 1366 x 768 píxeles y tecnología Wifi con 500GB de almacenamiento interno, para que en un solo portátil tengas todo lo que necesitas para trabajar al alcance de tu mano.', 1, 11, NULL, NULL, 0, 0),
(2, 'P259M', 'Acer TravelMate P259M', 412.40, NULL, 'port2', 21, 'Te presentamos la gama Acer TravelMate . Estos portátiles, que tienen un refinado acabado textil con una apariencia y un tacto excepcionales, incorporan los últimos procesadores Intel® Core™ y unas discretas opciones gráficas para que logre la máxima productividad en todo momento.', 1, 4, NULL, NULL, 0, 1),
(3, 'GL62', 'MSI GL62 6QF-1230XES', 698.35, NULL, 'port3', 21, 'Te presentamos el GL62 6QF-1230XES de MSI, un portátil gaming con procesador Intel Core i5, 8GB de RAM, 1TB de disco duro y gráca Nvidia GeForce GTX 960M.', 1, 0, NULL, NULL, 0, 0),
(4, 'RED3S', 'Xiaomi Redmi 3S Prime 4G 32Gb', 164.46, NULL, 'sma1', 21, 'Con la llegada del Xiaomi Redmi 3S ya tenemos otro smartphone barato en la gama media con un diseño fantástico y especificaciones más que interesantes. Desde que Xiaomi llegó al mercado, nuestra percepción de los teléfonos móviles baratos está cambiando, para bien, y este Redmi 3S es una prueba de ello.', 2, 9, NULL, NULL, 0, 0),
(5, 'P8', 'Huawei P8 Lite', 142.15, NULL, 'sma2', 21, 'Huawei P8 Lite es sinónimo de diseño y tecnología. Este P8 Lite es un buen ejemplo de que los móviles baratos pueden combinar un diseño genial con la mejor tecnología del momento sin que el precio se resienta.', 2, 0, NULL, NULL, 0, 0),
(6, 'IPH5S', 'Apple iPhone 5S', 263.64, NULL, 'sma3', 21, 'iPhone 5s coge todas las cualidades del iPhone anterior, las amplía y las mejora. Así es el nuevo móvil de Apple.\r\n\r\nApple vuelve a la carga y PcComponentes te pone en bandeja este iphone 5s barato como él solo.', 2, 14, NULL, NULL, 0, 1),
(7, 'SAMJ5', 'Samsung Galaxy J5', 164.46, NULL, 'sma4', 21, 'Samsung Galaxy J5 2016 es lo nuevo en móviles Samsung. La serie J apuesta por unas especificaciones realmente atractivas a un precio muy ajustado, sobre todo en el modelo J5. Algo que parece haberle salido bien a la compañía a tenor de los resultados del Samsung J5 2016 y las opiniones tan positivas que está cosechando.', 2, 0, NULL, NULL, 0, 0),
(8, 'MG4', 'Motorola Moto G4', 147.93, NULL, 'sma5', 21, 'Con 5,5 pulgadas y resolución Full HD (1920x1080), este teléfono hará las delicias de quienes disfrutan consumiendo contenido multimedia, vídeos, fotografías, animaciones y juegos, también para aquellos a los que les guste navegar y echar un rápido vistazo a una página web sin apenas hacer uso del scroll para recorrer la web.', 2, 4, NULL, NULL, 0, 1),
(9, 'LGK8', 'LG K8 4G 8GB', 103.30, NULL, 'sma6', 21, 'LG presenta al LG K8, un móvil libre barato con el que pretende competir en la gama baja con un precio irresistible y unas especificaciones muy interesantes que sitúan a este teléfono como uno de los mejores en cuanto a calidad/precio.', 2, 1, NULL, NULL, 0, 0),
(10, 'NEX5X', 'Google Nexus 5X 16GB', 222.31, NULL, 'sma7', 21, 'Nexus 5X es un smartphone que equilibra a la perfección diseño, especificaciones y precio. Al comprar Nexus 5X estás adquiriendo la más avanzada tecnología al mejor precio. Un dispositivo ligero y compacto que te acompañará durante todo el día ofreciéndote una experiencia de uso sin igual.', 2, 0, NULL, NULL, 0, 0),
(11, 'PS4', 'PlayStation 4 Slim 500GB', 229.75, NULL, 'con1', 21, 'Disfruta de una PS4 más estilizada y compacta con la misma potencia de juego.Disfruta de colores increíblemente vivos y brillantes con asombrosos gráficos HDR.Organiza tus juegos y aplicaciones y comparte todo con tus amigos a través de una nueva interfaz intuitiva.', 3, 7, NULL, NULL, 0, 0),
(12, 'XBOXFI', 'Xbox One S 500GB + Fifa 17', 247.11, NULL, 'con2', 21, 'Reserva el pack Xbox One S 1 TB: Fifa 17 , que contiene una consola Xbox One S de 500GB y el Mando Inalámbrico Xbox One y de Fifa 17, sin duda uno de los juegos más esperados del año.', 3, 6, NULL, NULL, 0, 0),
(13, '3DS', 'Nintendo New 3DS XL', 161.16, NULL, 'con3', 21, 'New 3DS XL supone una vuelta de tuerca en el mundo de las consolas. Un golpe sobre la mesa de Nintendo para demostrar que, desde la Game Boy, sigue siendo la reina de la diversión portátil. Y es que la Nintendo New 3DS XL supone un gran avance con respecto a la Nintendo 3DS.', 3, 7, NULL, NULL, 0, 0),
(14, 'GL752VW', 'Asus GL752VW-T4065D', 825.62, 15, 'port4', 21, 'Comprar Asus GL752VW es una sabia decisión si buscas potencia para jugar a tus videojuegos favoritos en cualquier parte. Su potente procesador Intel Core i7 a 2.6GHz overclokeable hasta  3.5 junto con la tarjeta gráfica Nvidia GTX960M aportan la potencia necesaria para mover los juegos más novedosos en calidades ultra y altísimas resoluciones.', 1, 0, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `nombre`) VALUES
(0, '- Seleccione -'),
(1, 'Alava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almería'),
(5, 'Ávila'),
(6, 'Badajoz'),
(7, 'Islas Baleares'),
(8, 'Barcelona'),
(9, 'Burgos'),
(10, 'Cáceres'),
(11, 'Cádiz'),
(12, 'Castellón'),
(13, 'Ciudad Real'),
(14, 'Córdoba'),
(15, 'A Coruña'),
(16, 'Cuenca'),
(17, 'Girona'),
(18, 'Granada'),
(19, 'Guadalajara'),
(20, 'Guipzcoa'),
(21, 'Huelva'),
(22, 'Huesca'),
(23, 'Jaén'),
(24, 'León'),
(25, 'Lleida'),
(26, 'La Rioja'),
(27, 'Lugo'),
(28, 'Madrid'),
(29, 'Málaga'),
(30, 'Murcia'),
(31, 'Navarra'),
(32, 'Ourense'),
(33, 'Asturias'),
(34, 'Palencia'),
(35, 'Las Palmas'),
(36, 'Pontevedra'),
(37, 'Salamanca'),
(38, 'S. Cruz de Tenerife'),
(39, 'Cantabria'),
(40, 'Segovia'),
(41, 'Sevilla'),
(42, 'Soria'),
(43, 'Tarragona'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Vizcaya'),
(49, 'Zamora'),
(50, 'Zaragoza'),
(51, 'Ceuta'),
(52, 'Melilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) DEFAULT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `borrado` tinyint(1) DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_provincia`),
  KEY `fk_usuarios_provincias_idx` (`id_provincia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `email`, `nombre`, `apellidos`, `dni`, `direccion`, `cp`, `borrado`, `id_provincia`) VALUES
(1, 'cristobal', '5946db8e9b20ccb3866982fe9d9524ce', 'cristobaldominguez95@gmail.com', 'Cristóbal', 'Domínguez', '49086582M', 'Avenida de Rociana, nº 54', '21830', 0, 21),
(4, 'prueba', '7ad4109292636b7498a9f5042081becf', 'cristobaldominguez95@hotmail.com', 'nombre de prueba', 'apellidos de prueba', '49086582M', 'direccion de prueba', '66666', 0, 17);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `fk_linea_pedido_pedidos1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_linea_pedido_productos1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_provincias` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
