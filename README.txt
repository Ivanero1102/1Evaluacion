El proyecto se basa en el manejo de una base de datos dependiendo del tipo de usuario 
El presidente puede acceder a todas las tablas mas el log y el informe
Los manager pueden acceder a lo mismo que el presidente menos al informe
Los usuarios normales solo puden acceder a clientes


el index consiste en el sistema de login donde se le pide al usuario su id y una contraseña la cual es admin para todos los usuarios
El proyecto lo dividi en secciones con un case para poder manejarlo casi todo en un unico archivo, lo cual me ha conllevado un gran uso
de condicionales y de echo para realizar la mayor parte del html, ademas de emplear muchos formularios con hidden para poder pasas
informacion sin que el usuario lo sepa. 