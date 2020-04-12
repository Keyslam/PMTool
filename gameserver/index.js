const WebSocket = require("ws");

const wss = new WebSocket.Server({ port: 1500 });

let activeGame = null;

let commands = {
  "isGameActive": isGameActive,
  "newGameAdded": newGameAdded,

  "ping": ping,
  "repeat": repeat,
  "newUserJoins": newUserJoins,
}

function broadcast(data) {
  wss.clients.forEach(function each(client) {
    if (client.readyState === WebSocket.OPEN) {
      client.send(data);
    }
  });
}

function isGameActive(ws, data) {
  let response = {
    "value": activeGame ? true : false,
  };
  
  ws.send(JSON.stringify(response));
}

function newGameAdded(ws, data) {
  broadcast(JSON.stringify({
    "command": "newGameAdded",
  }));
}

function ping(ws, data) {
  ws.send(JSON.stringify({
    "value": "pong",
  }));
}

function newUserJoins(ws, data) {
  broadcast(JSON.stringify({
    "command": "newUserJoins",
  }))
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