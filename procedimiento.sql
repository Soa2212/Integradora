
call info_producto();

delimiter //
create procedure info_producto ()
select productos.id as'id producto',articulos.id as'id articulo',talla_numerica.tallaas'talla_numerica',talla_ropa.tallaas'talla_ropa',colores.color,articulos.cantidad from productos
inner join articulos 
on articulos.producto=productos.id
inner join talla_numerica
on talla_numerica.id=articulos.talla_numerica
inner join talla_ropa
on talla_ropa.id=articulos.talla_ropa
inner join colores
on colores.id=articulos.color;
end;
