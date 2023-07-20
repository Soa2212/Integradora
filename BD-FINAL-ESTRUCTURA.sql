create database actividad_segura;
use actividad_segura;

create table CATEGORIAS(
    id  int primary key auto_increment,
    categoria varchar(100) unique,
    estado enum('activo','inactivo')
);


create table PRODUCTOS(
    id bigint primary key,
    nombre varchar(100),
    precio decimal(10, 3),
    imagen1 varchar(1500),
    descripcion varchar(1000),
    categoria int,
    estado enum('activo','inactivo'),
    constraint FK_productos_categoria foreign key (categoria) references CATEGORIAS(id)
);

create table TALLA_NUMERICA(
    id int primary key auto_increment,
    talla varchar(10)unique
);


create table TALLA_ROPA(
    id int primary key auto_increment,
    talla varchar(10)unique
);



create table COLORES(
    id int primary key auto_increment,
    color varchar(16) unique
);



create table ARTICULOS(
    id int primary key auto_increment,
    producto bigint,
    cantidad int,
    talla_numerica int,
    talla_ropa int,
    color int,
    constraint FK_articulos_productos foreign key (producto) references PRODUCTOS(id),
    constraint FK_articulos_talla_numerica foreign key (talla_numerica) references TALLA_NUMERICA(id),
    constraint FK_articulos_talla_ropa foreign key (talla_ropa) references TALLA_ROPA(id),
    constraint FK_articulos_colores foreign key (color) references COLORES(id)
);


create table USUARIOS(
    id int primary key auto_increment,
    nombre varchar(100) not null,
    email varchar(50) not null unique,
    contraseña varchar(30) not null,
    tipo enum('normal','admin') not null
);

create table orden_venta(
id int primary key auto_increment,
FechaOrden  date,
Cliente int,
    Estado_Venta enum('En Proceso','Cancelada','Completada'),
    Estado_Envio enum('En Proceso','Entregada','Cancelada'),
constraint FK_ordenventa_cliente foreign key (Cliente) references usuarios(id));

create table detalle_orden(
Orden int,
Articulo int,
Cantidad int,
constraint FK_detalleorden_articulo foreign key (Articulo) references articulos(id),
constraint FK_detalleorden_orden_venta foreign key (Orden) references  orden_venta(id)
);


create table carrito(
Orden int,
Articulo varchar(10),
Cantidad int
);
