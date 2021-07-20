
USE matiasj1_geome7ric;
drop table IF EXISTS movimientos;
CREATE TABLE movimientos
(
		id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(45),
        descripcion VARCHAR(43),
        fecha_creacion VARCHAR(45),
        user VARCHAR(45),
		monto VARCHAR(45), 
        monto_cuota VARCHAR(45),       
        categoria VARCHAR(45),   
        es_pago_cuotas VARCHAR(45),     
        cantidad_cuotas VARCHAR(45),
        cantidad_cuotas_pagas VARCHAR(45),
        CONSTRAINT PK_id PRIMARY KEY (id)
) ENGINE= InnoDB;

CREATE TABLE estado
(
		id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
		monto_actual VARCHAR(45) NOT NULL, 
        monto_ahorro VARCHAR(45),       
        monto_deuda VARCHAR(45),
        CONSTRAINT PK_id PRIMARY KEY (id)
) ENGINE= InnoDB;