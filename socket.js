const express = require('express');
const app = express();
const server = require("http").Server(app);

var fs = require('fs'),
    ini = require('ini');

var config = ini.parse(fs.readFileSync(__dirname + '/tools/functions/setting.ini', 'utf8'));

const io = require('socket.io')(server, {
  cors: {
    origin: `http://localhost:${config.SOCKET.PORT}`,
    methods: ["GET", "POST"],
    allowedHeaders: ["my-custom-header"],
    credentials: true
  }
});

const mariadb = require('mariadb/callback');
const conn  = mariadb.createConnection({
     host: config.DATABASE.HOST,
     user: config.DATABASE.USER,
     password: config.DATABASE.PASS,
     database: config.DATABASE.NAME,
});

let chat = io.of('/chat');

chat.on('connection', function(socket) {

  console.log("Успешное соединение");

  socket.on('joinRoom',(data) =>{

      socket.join(data.id, function(){
        console.error('room ' + data.id);
      });

      chat.in(data.id).emit('joinRoom', data);

  });

  socket.on('message',(data) =>{

    console.log(data);

    let date = new Date();

    let date1 = date.getFullYear() +"-"+ date.getMonth() +"-"+ date.getDate();

    let time = date.getHours() +":"+ date.getMinutes();

    conn.query(`INSERT INTO chat (id_push, id_pull, message, date, time, activity, type_message) VALUES('${data.id_push}', '${data.id_pull}', '${data.mes}', '${date1}', '${time}', 0, '${data.type_message}')`, (err, row) => {
      console.log(err);
    });

    chat.in(data.id_pull).emit(data.type_message, data);

    chat.in(data.id_push).emit(data.type_message, data);

  });

  socket.on('disconnect',() =>{

    console.log('Соединение разорвано')

  });

});

server.listen(config.SOCKET.PORT, function () {
  console.log("Start server");
});