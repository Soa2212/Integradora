create database actividad_segura;

use actividad_segura;

create table categorias(
CategoriaID int primary key auto_increment,
CategoriaDescripcion varchar(50));
alter table categorias auto_increment=0000;

create table productos(
ProductoID int primary key auto_increment,
ProductoNombre varchar(50),
ProductoDescripcion varchar(100),
CategoriaID int,
constraint FK_producto_categoria foreign key (CategoriaID) references categorias(CategoriaID));
alter table productos auto_increment=0000;

create table talla_calzado(
TallaCalzadoID int primary key auto_increment,
TallaCalzado varchar(10));
alter table talla_calzado auto_increment=0000;

create table talla_ropa(
TallaRopaID int primary key auto_increment,
TallaRopa varchar(20));
alter table talla_ropa auto_increment=0000;

create table colores(
ColoresID int primary key auto_increment,
Color varchar(16));
alter table colores auto_increment=0000;

create table articulos(
ArticuloID int primary key auto_increment,
Stock int,
PrecioUnitario decimal(10,2),
TallaCalzadoID int,
TallaRopaID int,
ColoresID int,
ProductoID int,
CONSTRAINT FK_articulos_talla_calzado FOREIGN KEY (TallaCalzadoID) REFERENCES talla_calzado(TallaCalzadoID),
CONSTRAINT FK_articulos_talla_ropa FOREIGN KEY (TallaRopaID) REFERENCES talla_ropa(TallaRopaID),
CONSTRAINT FK_articulos_colores FOREIGN KEY (ColoresID) REFERENCES colores(ColoresID),
CONSTRAINT FK_articulos_productos FOREIGN KEY (ProductoID) REFERENCES productos(ProductoID));
alter table ARTICULOS auto_increment=0000;

create table detalle_orden(
DetalleOrdenID int primary key auto_increment,
FechaDetalle date,
CantidadProducto int,
ArticuloID int,
constraint FK_detalleorden_articulo foreign key (ArticuloID) references articulos(ArticuloID));
alter table detalle_orden auto_increment=0000;

create table clientes(
ClienteID int primary key auto_increment,
Nombre varchar(50) not null,
NombreContacto varchar(50),
Telefono nchar(12) not null,
Email varchar(50),
Contraseña varchar(30) not null);
alter table clientes auto_increment=0000;

create table orden_venta(
OrdenID int primary key auto_increment,
FechaOrden  date,
TipoPago varchar(50),
DetalleOrdenID int,
ClienteID int,
constraint FK_ordenventa_detalle foreign key (DetalleOrdenID) references detalle_orden(DetalleOrdenID),
constraint FK_ordenventa_cliente foreign key (ClienteID) references clientes(ClienteID));









