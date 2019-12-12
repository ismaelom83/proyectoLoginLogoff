/**
 * Author:  Ismael Heras
 * Created: 27-nov-2019
 */
-- La contraseña de los usuarios, es el codUsuario concatenado con el password, en este caso paso. [$usuario . $pass]
-- Base de datos a usar
USE DAW209DBProyectoTema5;

-- Introduccion de datos dentro de la tabla creada
INSERT INTO Departamento(CodDepartamento,DescDepartamento,FechaCreacionDepartamento, VolumenNegocio) VALUES
    ('INF', 'Departamento de informatica',1574772123, 50),
    ('VEN', 'Departamento de ventas',1574772123, 800000),
    ('CON', 'Departamento de contabilidad',1574772123, 900000),
    ('MAT', 'Departamento de matematicas',1574772123, 80000000),
    ('CAT', 'Departamento de gatos',1574772123, 12584631268);
-- 1574772123 -> 26-nov-2019 ~13:45 --

-- El tipo de usuario es "usuario" como predeterminado, despues añado un admin --
INSERT INTO Usuario(CodUsuario, DescUsuario, Password,NumConexiones) VALUES
    ('daniel','Daniel Alcala',SHA2('danielpaso',256),0),
    ('nereaA','Nerea Alvarez',SHA2('nereaApaso',256),0),
    ('miguel','Miguel Aranda',SHA2('miguelpaso',256),0),
    ('alex','Alex Dominguez',SHA2('alexpaso',256),0),
    ('david','David Garcia',SHA2('davidpaso',256),0),
    ('ismael','Ismael Heras',SHA2('ismaelpaso',256),0),
    ('victor','Victor Martinez',SHA2('victorpaso',256),0),
    ('bea','Bea Merino',SHA2('beapaso',256),0),
    ('nereaN','Nerea Nuevo',SHA2('nereaNpaso',256),0),
    ('mateo','Mateo Rivera',SHA2('mateopaso',256),0),
    ('rodrigo','Rodrigo Robles',SHA2('rodrigopaso',256),0),
    ('ruben','Ruben Merino',SHA2('rubenpaso',256),0),
    ('heraclio','Heraclio Bourbujo',SHA2('heracliopaso',256),0),
    ('amor','Amor Rodriguez',SHA2('amorpaso',256),0),
    ('maria','Maria Casado',SHA2('mariapaso',256),0),
    ('antonio','Antonio Janez',SHA2('antoniopaso',256),0);

-- Usuario con el rol admin --
INSERT INTO Usuario(CodUsuario, DescUsuario, Password, NumConexiones,Perfil) VALUES ('admin','admin',SHA2('adminpaso',256),0, 'administrador');