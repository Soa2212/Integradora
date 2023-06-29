create database actividad_segura;
use actividad_segura;


create table CATEGORIAS(id  int primary key auto_increment,
catagoria varchar(50));
alter table CATEGORIAS auto_increment='?????';


create table PRODUCTOS(id  int primary key auto_increment,
nombre varchar(50),
precio decimal (10,3),
imagen1 Blob,imagen2 Blob,imagen3 Blob,imagen4 Blob,imagen5 Blob,
descripcion varchar(1000),
categoria int,
CONSTRAINT FK_productos_categoria FOREIGN KEY (categoria) REFERENCES CATEGORIAS(id));
alter table PRODUCTOS auto_increment='?????';

create table TALLA_CALZADO(id int primary key auto_increment,
talla varchar(10));
insert into TALLA_CALZADO(talla)values('Ninguna');
alter table TALLA_CALZADO auto_increment='?????';

create table TALLA_ROPA(id int primary key auto_increment,
talla varchar(10));
insert into TALLA_ROPA(talla)values('Ninguna');
alter table TALLA_ROPA auto_increment='?????';

create table COLORES(id int primary key auto_increment,
talla varchar(16));
insert into TALLA_ROPA(talla)values('Ninguno');
alter table COLORES auto_increment='?????';

create table ARTICULOS(id int primary key auto_increment,cantidad int,
talla_calzado int,
talla_ropa int,
color int,
CONSTRAINT FK_articulos_talla_calzado FOREIGN KEY (talla_calzado) REFERENCES TALLA_CALZADO(id),
CONSTRAINT FK_articulos_talla_ropa FOREIGN KEY (talla_ropa) REFERENCES TALLA_ROPA(id),
CONSTRAINT FK_articulos_colores FOREIGN KEY (color) REFERENCES COLORES(id));
alter table ARTICULOS auto_increment='?????';

create table CLIENTES(id int primary key auto_increment,
nombre varchar(25) not null,
apellido varchar(25) not null,
email varchar(50) not null,
contraseña varchar(30) not null);
alter table CLIENTES auto_increment='?????';

create table ORDEN_VENTA(id int,
fecha_orden_venta date,
articulo int,
cantidad int,
cliente int,
CONSTRAINT FK_orden_venta_clientes FOREIGN KEY (cliente) REFERENCES CLIENTES(id),
CONSTRAINT FK_orden_venta_articulos FOREIGN KEY (articulo) REFERENCES ARTICULOS(id));

create table DETALLE_ORDEN_VENTA(id int primary key auto_increment,
orden_venta int,
fecha_detalle_orden_venta date,
tipo_de_pago varchar(30));
alter table DETALLE_ORDEN_VENTA auto_increment='??????';







