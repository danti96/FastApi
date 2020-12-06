
# platzi-rest-api
## Eliminar datos a través de HTTP DELETE:
$ curl -X 'DELETE' http://localhost:8000/books/1
## Ejecutar archivo con punto de entrada de un servidor
php -S localhost:8000 <file.php>

GET
El método GET solicita una representación de un recurso específico. Las peticiones que usan el método GET sólo deben recuperar datos.
HEAD
El método HEAD pide una respuesta idéntica a la de una petición GET, pero sin el cuerpo de la respuesta.
POST
El método POST se utiliza para enviar una entidad a un recurso en específico, causando a menudo un cambio en el estado o efectos secundarios en el servidor.
PUT
El modo PUT reemplaza todas las representaciones actuales del recurso de destino con la carga útil de la petición.

DELETE
El método DELETE borra un recurso en específico.
CONNECT
El método CONNECT establece un túnel hacia el servidor identificado por el recurso.

OPTIONS
El método OPTIONS es utilizado para describir las opciones de comunicación para el recurso de destino.
TRACE
El método TRACE realiza una prueba de bucle de retorno de mensaje a lo largo de la ruta al recurso de destino.

PATCH
El método PATCH es utilizado para aplicar modificaciones parciales a un recurso.

##Realizadon con python y usando FLask
    from flask import Flask
    from flask_restful import Api, Resource, reqparse

    app = Flask(__name__)
    api = Api(app)

    malwares = [
        {
            "name" : "spyfocus.js",
            "type" : "adware",
            "media" : "url",
        },
        {
            "name" : "greencard.zip",
            "type" : "trojan",
            "media" : "zip",
        },
        {
            "name" : "credit_card.rar",
            "type" : "trojan",
            "media" : "zip",
        },    
        {
            "name" : "system35.dll",
            "type" : "virus",
            "media" : "exe",
        },  
        {
            "name" : "registry_mode.bat",
            "type" : "worm",
            "media" : "msi",
        }
    ]

    class Malware(Resource):
            def get (self, name):
                for malware in malwares:
                    if (name == malware["name"]):
                        return malware, 200
                return "Marlware not found", 404

            def post (self, name):
                parser = reqparse.RequestParser()
                parser.add_argument("type")
                parser.add_argument("media")
                args = parser.parse_args()

                for malware in malwares:
                    if(name == malware["name"]):
                        return"Malware with name {} already exits".format(name), 400
                malware = {
                    "name" : name,
                    "type" : args["type"],
                    "media" : args["media"]
                }

                malwares.append(malware)
                return malware, 201

            def put (self, name):
                parser = reqparse.RequestParser()
                parser.add_argument("type")
                parser.add_argument("media")
                args = parser.parse_args()

                for malware in malwares:
                    if (name==malware["name"]):
                        malware["type"] = args["type"]
                        malware["media"] = args["media"]
                        return malware, 200

                malware = {
                    "name" : name,
                    "type" : args["type"],
                    "media" : args["media"]
                }
        
                malwares.append(malware)
                return malware, 201

            def delete (self, name):
                global malwares
                malwares = [malware for malware in malwares if malware["name"] != name]
                return "{} is deleted.".format(name), 200
            
    api.add_resource(Malware, "/malware/<string:name>")
    app.run(debug = True) #enable flask to reload after a change, only develoing mode.

## ¿Que es un HASH?
Una función criptográfica hash- usualmente conocida como “hash”- es un algoritmo matemático de seguridad que transforma cualquier bloque arbitrario de datos en una nueva serie de caracteres, con la característica particular de siempre poseer una longitud fija. Esto quiere decir que, sin importar la longitud de los datos de entrada, la longitud del valor hash de salida siempre es la misma.

https://media.kasperskydaily.com/wp-content/uploads/sites/87/2014/04/05212159/Cryptographic-Hashing-Explained.png

Para más información sobre el tema puedes visitar este blog de kaspersky

## Autenticación vía HMAC
Para esta autenticación necesitamos 3 elementos:

Función Hash: Difícil de romper, que sea conocida por el cliente y servidor.
Clave secreta: Solamente la pueden saber el cliente y el servidor, será utilizada para corroborar el hash.
UID: El id del usuario, será utilizado dentro de la función hash junto con la clave secreta y un timestamp.
Es mucho más segura que la autenticación vía HTTP, por ello la información que se envía a través de este método no es muy sensible.

## Autenticación vía Access Tokens
Está forma es la más compleja de todas, pero también es la forma más segura utilizada para información muy sensible. El servidor al que le van a hacer las consultas se va a partir en dos:

Uno se va a encargar específicamente de la autenticación.
El otro se va a encargar de desplegar los recursos de la API.
El flujo de la petición es la siguiente:

Nuestro usuario hace una petición al servidor de autenticación para pedir un token.
El servidor le devuelve el token.
El usuario hace una petición al servidor para pedir recursos de la API.
El servidor con los recursos hace una petición al servidor de autenticación para verificar que el token sea válido.
Una vez verificado el token, el servidor le devuelve los recursos al cliente.

Los tokens de acceso se utilizan en la autenticación basada en tokens para permitir que una aplicación acceda a una API. La aplicación recibe un token de acceso después de que un usuario autentica y autoriza el acceso con éxito, luego pasa el token de acceso como una credencial cuando llama a la API de destino. El token pasado informa a la API que el portador del token ha sido autorizado para acceder a la API y realizar acciones específicas especificadas por el alcance otorgado durante la autorización.

Fuente: https://auth0.com/docs/tokens/access-tokens
https://static.platzi.com/media/user_upload/autenticacion%20access%20token-5f7f5bce-630b-4a9d-a6a8-76bbd9e9f823.jpg


https://aaronparecki.com/oauth-2-simplified/
https://platzi.com/cursos/autenticacion-oauth/

https://platzi.com/clases/1638-api-rest/21623-autenticacion-via-access-tokens/
https://httpstatuses.com/