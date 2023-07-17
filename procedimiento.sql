use actividad_segura;
call info_producto(20001);
delimiter //
create procedure info_producto (in idprod int )
select productos.id,articulos.id,talla_numerica.talla,talla_ropa.talla,colores.color,articulos.cantidad from productos
inner join articulos 
on articulos.producto=productos.id
inner join talla_numerica
on talla_numerica.id=articulos.talla_numerica
inner join talla_ropa
on talla_ropa.id=articulos.talla_ropa
inner join colores
on colores.id=articulos.color
where productos.id=idprod;
end