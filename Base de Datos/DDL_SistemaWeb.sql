/*==================================================================
Database name:  Database
DBMS name:      MySQL Community 8.4.3
Created on:     04/06/202
Created by:     Maria Jackeline Córdova Sánchez
Project:		Desarrollo de una plataforma web para la gestión y venta de detalles personalizados para eventos especiales
/*==================================================================*/


-- 1. Configuración inicial
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- 2. Crear la base de datos
DROP SCHEMA IF EXISTS `sistema_detalles`;
CREATE SCHEMA `sistema_detalles` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistema_detalles`;

-- 3. Tabla de usuarios (para acceso al sistema)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `rol` ENUM('admin', 'empleado', 'cliente') NOT NULL DEFAULT 'cliente',
  `fecha_creacion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_login` DATETIME NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;

-- 4. Tabla de clientes (información adicional)
CREATE TABLE IF NOT EXISTS `clientes` (
  `cliente_id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(20) NULL,
  `direccion` TEXT NULL,
  `ciudad` VARCHAR(50) NULL,
  `codigo_postal` VARCHAR(20) NULL,
  `pais` VARCHAR(50) NULL DEFAULT 'México',
  `fecha_nacimiento` DATE NULL,
  PRIMARY KEY (`cliente_id`),
  INDEX `fk_clientes_usuarios_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_clientes_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`usuario_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 5. Tabla de categorías de productos
CREATE TABLE IF NOT EXISTS `categorias` (
  `categoria_id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `imagen_url` VARCHAR(255) NULL,
  `activa` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`categoria_id`))
ENGINE = InnoDB;

-- 6. Tabla de productos
CREATE TABLE IF NOT EXISTS `productos` (
  `producto_id` INT NOT NULL AUTO_INCREMENT,
  `categoria_id` INT NOT NULL,
  `codigo` VARCHAR(50) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `precio_descuento` DECIMAL(10,2) NULL,
  `imagen_url` VARCHAR(255) NULL,
  `fecha_creacion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`producto_id`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  INDEX `fk_productos_categorias_idx` (`categoria_id` ASC),
  CONSTRAINT `fk_productos_categorias`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `categorias` (`categoria_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 7. Tabla de inventario/stock
CREATE TABLE IF NOT EXISTS `inventario` (
  `inventario_id` INT NOT NULL AUTO_INCREMENT,
  `producto_id` INT NOT NULL,
  `cantidad_disponible` INT NOT NULL DEFAULT 0,
  `cantidad_minima` INT NOT NULL DEFAULT 5,
  `ubicacion` VARCHAR(50) NULL,
  `ultima_actualizacion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`inventario_id`),
  INDEX `fk_inventario_productos_idx` (`producto_id` ASC),
  CONSTRAINT `fk_inventario_productos`
    FOREIGN KEY (`producto_id`)
    REFERENCES `productos` (`producto_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 8. Tabla de pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `pedido_id` INT NOT NULL AUTO_INCREMENT,
  `cliente_id` INT NOT NULL,
  `fecha_pedido` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('pendiente', 'procesando', 'enviado', 'entregado', 'cancelado') NOT NULL DEFAULT 'pendiente',
  `total` DECIMAL(12,2) NOT NULL,
  `direccion_envio` TEXT NOT NULL,
  `metodo_pago` ENUM('tarjeta', 'transferencia', 'efectivo', 'paypal') NOT NULL,
  `notas` TEXT NULL,
  PRIMARY KEY (`pedido_id`),
  INDEX `fk_pedidos_clientes_idx` (`cliente_id` ASC),
  CONSTRAINT `fk_pedidos_clientes`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `clientes` (`cliente_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 9. Tabla de detalles de pedido
CREATE TABLE IF NOT EXISTS `detalles_pedido` (
  `detalle_id` INT NOT NULL AUTO_INCREMENT,
  `pedido_id` INT NOT NULL,
  `producto_id` INT NOT NULL,
  `cantidad` INT NOT NULL DEFAULT 1,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  `descuento` DECIMAL(10,2) NULL DEFAULT 0.00,
  PRIMARY KEY (`detalle_id`),
  INDEX `fk_detalles_pedido_pedidos_idx` (`pedido_id` ASC),
  INDEX `fk_detalles_pedido_productos_idx` (`producto_id` ASC),
  CONSTRAINT `fk_detalles_pedido_pedidos`
    FOREIGN KEY (`pedido_id`)
    REFERENCES `pedidos` (`pedido_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detalles_pedido_productos`
    FOREIGN KEY (`producto_id`)
    REFERENCES `productos` (`producto_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 10. Tabla de historial de precios
CREATE TABLE IF NOT EXISTS `historial_precios` (
  `historial_id` INT NOT NULL AUTO_INCREMENT,
  `producto_id` INT NOT NULL,
  `precio_anterior` DECIMAL(10,2) NOT NULL,
  `precio_nuevo` DECIMAL(10,2) NOT NULL,
  `fecha_cambio` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `razon` VARCHAR(100) NULL,
  `usuario_id` INT NULL,
  PRIMARY KEY (`historial_id`),
  INDEX `fk_historial_precios_productos_idx` (`producto_id` ASC),
  INDEX `fk_historial_precios_usuarios_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_historial_precios_productos`
    FOREIGN KEY (`producto_id`)
    REFERENCES `productos` (`producto_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_historial_precios_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`usuario_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 11. Restaurar configuraciones
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- 12. Mensaje de confirmación
SELECT 'Base de datos "sistema_detalles" creada exitosamente...' AS Mensaje;