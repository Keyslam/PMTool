const WebSocket = require("ws");

const wss = new WebSocket.Server({ port: 1500 });

let activeGame = null;

function isGameActive(ws, data) {
  let response = {
    "value": activeGame ? true : false,
  };
  
  ws.send(JSON.stringify(response));
}

function ping(ws, data) {
  ws.send(JSON.stringify({
    "value": "pong",
  }));
}

function repeat(ws, data) {
  let toRepeat = data.toRepeat;
  
  if (toRepeat === null) {
    return;
  }

  ws.send(JSON.stringify({
    "value": toRepeat,
  }));
}

let commands = {
  "isGameActive": isGameActive,

  "ping": ping,
  "repeat": repeat,
}

wss.on("connection", function connection(ws) {
  ws.on("message", function incoming(message) {
    console.log("Received: %s", message);

    let data = JSON.parse(message);

    if (data.command === null) {
      return;
    }

    if (commands[data.command]) {
      commands[data.command](ws, data);
    }
  });
});

wss.on("error", function error(error) {
  console.log(error);
})