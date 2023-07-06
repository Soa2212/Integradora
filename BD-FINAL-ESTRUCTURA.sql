create database actividad_segura;
use actividad_segura;

create table CATEGORIAS(
    id  int primary key auto_increment,
    categoria varchar(100)
);


create table PRODUCTOS(
    codigo_barras bigint primary key,
    nombre varchar(100),
    precio decimal(10, 3),
    imagen1 Blob,
    imagen2 Blob,
    imagen3 Blob,
    imagen4 Blob,
    imagen5 Blob,
    descripcion varchar(1000),
    categoria int,
    constraint FK_productos_categoria foreign key (categoria) references CATEGORIAS(id)
);

create table TALLA_NUMERICA(
    id int primary key auto_increment,
    talla varchar(10)
);


create table TALLA_ROPA(
    id int primary key auto_increment,
    talla varchar(10)
);



create table COLORES(
    id int primary key auto_increment,
    talla varchar(16)
);



create table ARTICULOS(
    id varchar(10) primary key,
    producto bigint,
    cantidad int,
    talla_numerica int,
    talla_ropa int,
    color int,
    constraint FK_articulos_productos foreign key (producto) references PRODUCTOS(codigo_barras),
    constraint FK_articulos_talla_numerica foreign key (talla_numerica) references TALLA_NUMERICA(id),
    constraint FK_articulos_talla_ropa foreign key (talla_ropa) references TALLA_ROPA(id),
    constraint FK_articulos_colores foreign key (color) references COLORES(id)
);


create table CLIENTES(
    id int primary key auto_increment,
    nombre varchar(100) not null,
    apellido varchar(25) not null,
    email varchar(50) not null,
    contraseña varchar(30) not null
);

create table orden_venta(
id int primary key auto_increment,
FechaOrden  date,
ClienteID int,
constraint FK_ordenventa_cliente foreign key (ClienteID) references clientes(id));

create table detalle_orden(
OrdenID int,
ArticuloID varchar(10),
CantidadProducto int,
constraint FK_detalleorden_articulo foreign key (ArticuloID) references articulos(id),
constraint FK_detalleorden_orden_venta foreign key (OrdenID) references  orden_venta(id)
);