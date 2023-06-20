### 1. Instalaciones requeridas:

- PHP 8:
    `apt-get update`
    `apt-get install --no-install-recommends php8.1`
    `apt-get install -y php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath`

    `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
    `php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"`
    `php composer-setup.php`
    `php -r "unlink('composer-setup.php');"`

- [Composer]: (https://getcomposer.org/download/)

- MySQL: `apt-get install php-mysql`


### 2. Creacion de proyecto (Laravel):

- Para crear el proyecto se utiliza `composer create-project laravel/laravel nombre_proyecto`

### 3. Generar clave de cifrado unica para el proyecto:

- Para crear una clave de cifrado para el proyecto se utiliza: `php artisan key:generate`

La clave generada se utiliza para cifrar datos sensibles de la aplicacion, como las cookies y las contrasenas, Laravel genera una nueva clave de cifrado y la establece automaticamente en el archivo '.env' del proyecto.

### 4. Crear un usuario y una base de datos para MySQL:

- Ingresar a MySQL por consola con el comando `sudo mysql -u root -p`.
- Crear un usuario en el sistema de la base de datos MySQL con el comando `CREATE USER 'nombre_usuario'@'localhost' IDENTIFIED BY 'contrasena_usuario';`
- Establecer una contrasena para el usuario que se acaba de crear con el comando `SET PASSWORD FOR 'nombre_usuario'@'localhost' IDENTIFIED BY 'contrasena_usuario';`
- Otorgarle privilegios al usuario con el comando `GRANT ALL ON . TO 'nombre_usuario'@'localhost';`
- Crear una base de datos con el comando `CREATE DATABASE nombre_baseDeDatos;


### 4.1 Configuracion en DBeaver

- En la pestana 'General' completar con el nombre de usuario y contrasena creados en el paso anterior.
- En la pestana 'Driver Properties' cambiar `allowPublicKeyRetrieval` con el valor `TRUE`.

### 5. Configuraracion de base de datos en el proyecto:

En el archivo '.env' del proyecto configurar los siguientes parametros:
- DB_DATABASE=`nombre_base_de_datos`
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_USERNAME=`nombre_usuario`
- DB_PASSWORD=`contrasena_usuario`

### 6. Comienzo de proyecto:

 1. Creacion un modelo:
 Un modelo representa una tabla en la base de datos y define la estructura y comportamiento de los datos, para crear un model se utiliza el comando `php artisan make:model nombre_modelo -m` donde '-m' se utiliza para generar una migracion junto con el modelo.

 2. Configurar migraciones:
 En una migracion se configura la estructura de la tabla relacionada, los atributos que tiene y su tipo.

 3. Ejecutar migraciones pendientes a la base de datos MySQL:
 El comando anterior crea un modelo y una migracion para la tabla relacionada en la base de datos, pero solo crea los archivos en el proyecto, no realiza automaticamente la migracion en la base de datos, por lo cual se debe ejecutar `php artisan migrate`.

 Nota: Cuando se trata de modificacion de una tabla o una creacion de esta, se debe ejecutar el comando para aplicar los cambios en la base de datos.

 4. Creacion de un controlador del modelo:
 Un controlador se utiliza para recibir las solicitudes del usuario, procesar los datos y enviar una respuesta adecada, para crear un controlador se utiliza el comando `php artisan make:controller 'nombre_modeloControler`.

    En el controlador, se importa: 
    - use App\Models\modelo_del_controller
    - use Illuminate\Http\Response;
    - use Exception;
    - use modeloRequest

 Luego crear el CRUD Basico


5. Configurar solicitud(Request):
Se utiliza para manejar y validar los datos de entrada de una solicitud HTTP y se crea con el comando `php artisan make:request 'nombre_modeloRequest'`

Nota: Comentar funcion de autorizacion o no funcionara

Importar:
    - use Illuminate\Foundation\Http\FormRequest;
    - use Illuminate\Http\Response;
    - use Illuminate\Http\Exceptions\HttpResponseException;
    - use Illuminate\Contracts\Validation\Validator;

6. Configurar rutas en el archivo 'routes/api':
 Importar:
  - El controler del modelo.


7. Echar andar el proyecto
`php artisan serve` 
