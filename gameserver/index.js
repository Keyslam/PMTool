const WebSocket = require("ws");

const wss = new WebSocket.Server({ port: 1500 });

let commands = {
  "gameAdded": gameAdded,
  "gameRemoved": gameRemoved,
  "userSignup": userSignup, 
  "userSignout": userSignout,
}

function heartbeat() {
  this.isAlive = true;
}

wss.on("connection", function connection(ws) {
  ws.isAlive = true;
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
  ws.on("pong", heartbeat);
});

const interval = setInterval(function ping() {
  let currentclients = 0;
  let terminatedclients = 0;

  wss.clients.forEach(function each(ws) {
    if (ws.isAlive === false) {
      terminatedclients++;
      ws.terminate();
    } else if(ws.isAlive) {
      currentclients++;
    }
    ws.isAlive = false;
    ws.ping(function(){});
  });
  console.log("terminated " + terminatedclients + " clients, " + currentclients + " clients connected.")
}, 60000);

wss.on("error", function error(error) {
  console.log(error);
})

function broadcast(data) {
  wss.clients.forEach(function each(client) {
    if (client.readyState === WebSocket.OPEN) {
      client.send(data);
    }
  });
}

function gameAdded(ws, data) {
  broadcast(JSON.stringify({
    "command": "gameAdded",
  }));
}

function gameRemoved(ws, data) {
  broadcast(JSON.stringify({
    "command": "gameRemoved",
  }));
}

function userSignup(ws, data) {
  broadcast(JSON.stringify({
    "command": "userSignup",
  }))
}

function userSignout(ws, data) {
  broadcast(JSON.stringify({
    "command": "userSignout",
  }))
}