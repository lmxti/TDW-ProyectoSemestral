# TDW-ProyectoSemestral 2023-01

# Introducción del caso.
A ustedes, como ingeniero de la Universidad del Bio-Bio, llega la oportunidad para desarrollar
un sistema web para una PyME de "Bebidas Energeticas" que quiere gestionar el inventario de sus productos


# Problematicas del caso :
La empresa no cuenta con un sistema de inventario en sus bodegas, por lo cual realizan todo el papeleo
y gestion a mano.


- Llegada de productos:
Los productos llegan desde la fabrica hacia la bodega central, se reciben distintas cantidades
de producto en una guia de despacho, la cual se ingresa en un excel y se suma la cantidad que llego
a la cantidad que habia (stock).

- Traspaso de productos:

Cuando una bodega tiene un exceso o falta de productos, se traspasan entre bodegas para gestionar
de mejor forma los espacios que se tienen para almacenar todo.

Ejemplo:
La Bodega de Coronel tiene un bajo stock de bebida de naranja y la Bodega de Concepcion tiene suficiente
stock como para traspasar a la Bodega de Coronel, se realiza el envio de una cantidad "X" hacia ella, donde:

    - Se descuenta manualmente (Excel) de la bodega de Concepcion la cantidad enviada.
    - Se suma manualmente (Excel) a la bodega de Coronel la cantidad recibida.

- Salida de productos:
Cuando se realiza una venta, se debe descontar la cantidad de productos vendidos y deben ser
enviado a los negocios locales, una vez salido el producto se descuenta de la bodega en cuestion.


# Desarrollar un sistema que cuente con 4 modulos

### Modulo 1: CRUD de Bebidas
CRUD de Bebidas: podrá `registrar` nuevos sabores de bebidas, a su vez, `modificar` el nombre de estas y
sus presentaciones ( 1lt 1,5 lt etc)

    [Ponderación dificultad 1pt]

### Modulo 2: Ingreso de Bebidas
Se deberá registrar cada ingreso de bebidas desde la fabrica hacia las bodegas,
debe tener en claro que al ingresar un cargamento, este puede tener mas de una variedad de
bebestibles. 

    Ejemplo:
    100 unidades de bebida de naranja
    100 unidades de bebida de limon
    100 unidades de bebida de mango.

Esto se debe registrar en 1 ingreso unico y modificar los stocks disponibles en sistema.

    [ponderación dificultad 2pts]

### Modulo 3: Traspaso de Bebidas
Se debera registrar cada traspaso entre bodegas, si la bodega A
traspasa la bodega B cierta cantidad para cubrir demanda, se debe registrar en un solo movimiento,
al igual que el modulo de Ingreso de bebidas.

    [ponderación dificultad 3pts]

### Modulo 4: Egreso de Bebidas
Se deberá registrar cada egreso de bebidas, se puede registrar como una salida unica
o multiple siguiendo el paradigma de los modulos anteriores.

    [ponderación dificultad 2 pts.] 

Todo esto debe cumplir con las validaciones basicas, tanto de frontend como de backend que
utilizamos en la asignatura.

## Formato de presentación del sistema.

- Presentacion del sistema final 3 y 5 de Julio en horario de clases.
- Cada presentacion sera de 15 minutos, se preguntaran y revisaran funcionalidades basicas.
- Demostrar que las funcionalidades se ejecuten correctamente en N oportunidades (N = cantidad de integrantes del grupo, 40% Nota).
- Se solicitara una modificacion de manera individual y se debe realizar en un plazo de 10 minutos (60% Nota).
- La entrega final, no contempla tener todos los modulos 100% desarrollados, pero mientras mas completo y complejo sean los modulos que se tengan operativos, menor sera la exigencia de la modificacion a realizar.


Nota: Es importante destacar que cada grupo debe llevar su equipo personal para la presentacion o cordinar
con su compañero para evitar modificar codigo sobre el trabajo del resto.
