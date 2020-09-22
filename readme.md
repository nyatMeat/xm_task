For backend:
You have to configure file .env. In this file you need to change an email address in row

    MAILER_URL=gmail://randomemail@gmail.com:randompassword@localhost

You can use xampp, lamp to deploy on http server with port 80
Or you can run 
    
    php bin/console server:run
    
in the project directory
In that case you have to change file

    proxy.conf.json

and change port in row

    "target": "http://127.0.0.1:80",

For frontend you have to install npm packages before start the app

    npm install

and run project with command

    npm run start

Project will automatically start on localhost:4200
