use actividad_segura;

-- FALLOS
-- El proceso para que no se repitan los correos y las categorias son con la propiedad unique a la hora de crear las tablas, no un proceso

-- Mostrar los productos de las primeras 3 categorias
delimiter //
create procedure trescat()
begin
select productos.nombre, productos.precio, productos.descripcion, categorias.categoria
from categorias
inner join productos
on categorias.id=productos.categoria
where categorias.id= 1 or 2 or 3;
end //
delimiter ;

-- Proceso que seleccione todo lo relacionado a la tabla articulos
delimiter //
create procedure proc()
begin 
select talla_ropa.talla, talla_numerica.talla, colores.color, productos.* 
from productos
inner join articulos
on productos.id=articulos.producto
inner join talla_ropa
on talla_ropa.id=articulos.talla_ropa
inner join talla_numerica
on talla_numerica.id=articulos.talla_numerica
inner join colores
on colores.id=articulos.color;
end //
delimiter ;

-- Verificar que la categoria recien ingresada no exista ya
delimiter //
create trigger vercategoria 
after insert on categorias
for each row
begin
    declare categoria_count int;

    select count(*) into categoria_count
    from categorias
    where categoria = new.categoria;

    if categoria_count > 0 then
        signal sqlstate '45000'
		set message_text = 'La categoría ya existe.';
    end if;
end //
delimiter ;

-- Procedimiento para insertar productos
delimiter //
create procedure insprod 
(in cod_barr bigint(20),in nom varchar(100), in prec decimal(10,3),
in descr varchar(100), in cat int(11))
 begin
 insert into productos ( codigo_barras, nombre, precio, descripcion, categoria)
 values (cod_barr, nom, prec, descr, cat);
 end //
 delimiter ;
 
 
 -- Procedimiento para crear categorias
 delimiter //
 create procedure inscat
 (in cat varchar(100))
 begin
 insert into categorias(categoria)
 values (cat);
 end //
 delimiter ;
 
 -- Proceso que permita modificar productos
 delimiter //
 create procedure modprod(in codbarr bigint(20),in nvnom varchar(100),in nvprecio decimal(10, 3),in nvimagen1 blob,in nvimagen2 blob,in nvimagen3 blob,in nvimagen4 blob,in nvimagen5 blob,
 in nvdescr varchar(100),in nvcat int (11))
 begin 
  DECLARE old_nom VARCHAR(100);
  DECLARE old_precio DECIMAL(10, 3);
  DECLARE old_imagen1 BLOB;
  DECLARE old_imagen2 BLOB;
  DECLARE old_imagen3 BLOB;
  DECLARE old_imagen4 BLOB;
  DECLARE old_imagen5 BLOB;
  DECLARE old_descr VARCHAR(100);
  DECLARE old_cat INT(11);
  
  IF nvnom <> old_nom THEN
    UPDATE products SET nom = nvnom WHERE codbarr = codbarr;
  END IF;
  
  IF nvprecio <> old_precio THEN
    UPDATE products SET precio = nvprecio WHERE codbarr = codbarr;
  END IF;
  
  IF nvimagen1 <> old_imagen1 THEN
    UPDATE products SET imagen1 = nvimagen1 WHERE codbarr = codbarr;
  END IF;
  
  IF nvimagen2 <> old_imagen2 THEN
    UPDATE products SET imagen2 = nvimagen2 WHERE codbarr = codbarr;
  END IF;
  
  IF nvimagen3 <> old_imagen3 THEN
    UPDATE products SET imagen3 = nvimagen3 WHERE codbarr = codbarr;
  END IF;
  
  IF nvimagen4 <> old_imagen4 THEN
    UPDATE products SET imagen4 = nvimagen4 WHERE codbarr = codbarr;
  END IF;
  
  IF nvimagen5 <> old_imagen5 THEN
    UPDATE products SET imagen5 = nvimagen5 WHERE codbarr = codbarr;
  END IF;
  
  IF nvdescr <> old_descr THEN
    UPDATE products SET descr = nvdescr WHERE codbarr = codbarr;
  END IF;
  
  IF nvcat <> old_cat THEN
    UPDATE products SET cat = nvcat WHERE codbarr = codbarr;
  END IF;
  
END //

DELIMITER ;

-- Proceso que permita dormir categorias
delimiter //
create procedure dormcat(in idcat int(11))
begin
update categorias
set estado='inactivo'
where categorias.id=idcat;
end //
delimiter ;

-- Trigger que ponga los productos en inactivo si su categoria es inactiva
delimiter //
create trigger estprod
after update on categorias for each row
begin
if categorias.estado='inactivo' then
update productos
set productos.estado='inactivo'
where categoria=old.id;
end if ;
end //
delimiter ;