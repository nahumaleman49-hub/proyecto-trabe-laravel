CREATE TABLE Ordenes
(
	ID_Orden INTEGER NOT NULL,
	fk_id_proyecto INTEGER NOT NULL,
	no_orden INTEGER NOT NULL,
	fecha DATE NOT NULL,
	PRIMARY KEY (ID_Orden),
	KEY (fk_id_proyecto)
) 
;


CREATE TABLE DetallesOrden
(
	ID_Detalle_orden INTEGER NOT NULL,
	fk_id_orden INTEGER NOT NULL,
	fk_id_detalle_cotiza INTEGER NOT NULL,
	estado BOOL NOT NULL,
	PRIMARY KEY (ID_Detalle_orden),
	KEY (fk_id_detalle_cotiza),
	KEY (fk_id_orden)
) 
;


CREATE TABLE Clientes
(
	ID_cliente INTEGER NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	telefono INTEGER NOT NULL,
	direccion VARCHAR(80) NOT NULL,
	PRIMARY KEY (ID_cliente)
) 
;


CREATE TABLE ManoObraContac
(
	ID_mano_obra_contac INTEGER NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	telefono INTEGER NOT NULL,
	direccion VARCHAR(80) NOT NULL,
	PRIMARY KEY (ID_mano_obra_contac)
) 
;


CREATE TABLE DetalleManoObra
(
	ID_mano_obra INTEGER NOT NULL,
	fk_id_mano_obra_contac INTEGER NOT NULL,
	precio_unit FLOAT(2) NOT NULL,
	cantidad INTEGER NOT NULL,
	tipo_trabajo VARCHAR(30) NOT NULL,
	PRIMARY KEY (ID_mano_obra),
	KEY (fk_id_mano_obra_contac)
) 
;


CREATE TABLE Proyecto
(
	ID_proyecto INTEGER NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	fk_id_cliente INTEGER NOT NULL,
	estado BOOL NOT NULL,
	fecha_ini DATE NOT NULL,
	fecha_fin DATE,
	presupuesto FLOAT(2) NOT NULL,
	PRIMARY KEY (ID_proyecto),
	KEY (fk_id_cliente)
) 
;


CREATE TABLE Cotizacion
(
	ID_cotizacion INTEGER NOT NULL,
	fk_id_proyecto INTEGER NOT NULL,
	fecha DATE NOT NULL,
	estado BOOL NOT NULL,
	total FLOAT(2) NOT NULL,
	PRIMARY KEY (ID_cotizacion),
	KEY (fk_id_proyecto)
) 
;


CREATE TABLE DetalleCotizacion
(
	ID_DetalleCotiza INTEGER NOT NULL,
	fk_id_material INTEGER NOT NULL,
	fk_id_proveedor INTEGER NOT NULL,
	fk_id_cotizacion INTEGER NOT NULL,
	cantidad INTEGER NOT NULL,
	precio_unit FLOAT(2) NOT NULL,
	tiempo_entrega_dias INTEGER,
	fk_id_mano_obra INTEGER NOT NULL,
	PRIMARY KEY (ID_DetalleCotiza),
	KEY (fk_id_cotizacion),
	KEY (fk_id_mano_obra),
	KEY (fk_id_material),
	KEY (fk_id_proveedor)
) 
;


CREATE TABLE Categoria
(
	ID_Categoria INTEGER NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	descripcion TEXT,
	PRIMARY KEY (ID_Categoria)
) 
;


CREATE TABLE Proveedores
(
	ID_proveedor INTEGER NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	nombre_contacto VARCHAR(40) NOT NULL,
	telefono INTEGER NOT NULL,
	correo_e VARCHAR(30) NOT NULL,
	direccion VARCHAR(50) NOT NULL,
	PRIMARY KEY (ID_proveedor)
) 
;


CREATE TABLE PrecioHistorico
(
	ID_preciohist INTEGER NOT NULL,
	precio FLOAT(2) NOT NULL,
	fk_id_material INTEGER NOT NULL,
	fk_id_proveedor INTEGER NOT NULL,
	fecha_ini DATE NOT NULL,
	fecha_fin DATE,
	PRIMARY KEY (ID_preciohist),
	KEY (fk_id_material),
	KEY (fk_id_proveedor)
) 
;


CREATE TABLE Materiales
(
	ID_Material INTEGER NOT NULL,
	nombre VARCHAR(60) NOT NULL,
	codigo VARCHAR(30) NOT NULL,
	medidas VARCHAR(20) NOT NULL,
	fk_id_categoria INTEGER NOT NULL,
	ficha_tecnica TEXT,
	PRIMARY KEY (ID_Material),
	KEY (fk_id_categoria)
) 
;





ALTER TABLE Ordenes ADD CONSTRAINT FK_Ordenes_Proyecto 
	FOREIGN KEY (fk_id_proyecto) REFERENCES Proyecto (ID_proyecto)
;

ALTER TABLE DetallesOrden ADD CONSTRAINT FK_DetallesOrden_DetalleCotizacion 
	FOREIGN KEY (fk_id_detalle_cotiza) REFERENCES DetalleCotizacion (ID_DetalleCotiza)
;

ALTER TABLE DetallesOrden ADD CONSTRAINT FK_DetallesOrden_Ordenes 
	FOREIGN KEY (fk_id_orden) REFERENCES Ordenes (ID_Orden)
;

ALTER TABLE DetalleManoObra ADD CONSTRAINT FK_DetalleManoObra_ManoObraContac 
	FOREIGN KEY (fk_id_mano_obra_contac) REFERENCES ManoObraContac (ID_mano_obra_contac)
;

ALTER TABLE Proyecto ADD CONSTRAINT FK_Proyecto_Clientes 
	FOREIGN KEY (fk_id_cliente) REFERENCES Clientes (ID_cliente)
;

ALTER TABLE Cotizacion ADD CONSTRAINT FK_Cotizacion_Proyecto 
	FOREIGN KEY (fk_id_proyecto) REFERENCES Proyecto (ID_proyecto)
;

ALTER TABLE DetalleCotizacion ADD CONSTRAINT FK_DetalleCotizacion_Cotizacion 
	FOREIGN KEY (fk_id_cotizacion) REFERENCES Cotizacion (ID_cotizacion)
;

ALTER TABLE DetalleCotizacion ADD CONSTRAINT FK_DetalleCotizacion_DetalleManoObra 
	FOREIGN KEY (fk_id_mano_obra) REFERENCES DetalleManoObra (ID_mano_obra)
;

ALTER TABLE DetalleCotizacion ADD CONSTRAINT FK_DetalleCotizacion_Materiales 
	FOREIGN KEY (fk_id_material) REFERENCES Materiales (ID_Material)
;

ALTER TABLE DetalleCotizacion ADD CONSTRAINT FK_DetalleCotizacion_Proveedores 
	FOREIGN KEY (fk_id_proveedor) REFERENCES Proveedores (ID_proveedor)
;

ALTER TABLE PrecioHistorico ADD CONSTRAINT FK_PrecioHistorico_Materiales 
	FOREIGN KEY (fk_id_material) REFERENCES Materiales (ID_Material)
;

ALTER TABLE PrecioHistorico ADD CONSTRAINT FK_PrecioHistorico_Proveedores 
	FOREIGN KEY (fk_id_proveedor) REFERENCES Proveedores (ID_proveedor)
;

ALTER TABLE Materiales ADD CONSTRAINT FK_Materiales_Categoria 
	FOREIGN KEY (fk_id_categoria) REFERENCES Categoria (ID_Categoria)
;
