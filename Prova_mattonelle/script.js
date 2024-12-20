const canvas = document.getElementById("tileCanvas");
const ctx = canvas.getContext("2d");

// console.log(JSON.stringify(localStorage).length);
// console.log(localStorage);

// Definire le dimensioni della mappa e delle mattonelle
const MAP_SIZE = 1000;
const TILE_SIZE = 2; // Dimensione di ogni mattonella (in pixel)
const VISIBLE_TILES_X = Math.ceil(window.innerWidth / TILE_SIZE - 180);
const VISIBLE_TILES_Y = Math.ceil(window.innerHeight / TILE_SIZE);
var reverted = false;

// Crea una matrice per memorizzare i tipi di mattonelle
const mapTiles = Array.from(
  {
    length: MAP_SIZE,
  },
  () => Array(MAP_SIZE).fill("default")
);

// for (let $i = 0; $i < 50; $i++) {
//   localStorage.setItem(`riga${$i}`, mapTiles[$i]);
// }

// for (let $i = 0; $i < 1000; $i++) {
//   localStorage.removeItem(`riga${$i}`, mapTiles[$i]);
// }

// localStorage.removeItem("riga1");
// console.log(localStorage);
// console.log(localStorage.getItem("riga1"));

// Imposta la dimensione del canvas pari alla dimensione dello schermo
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let isDrawing = false; // Variabile per tracciare se il mouse è premuto

// Variabile per memorizzare il tipo di mattonella selezionata
let selectedTileType = "ICS";

// Inizializzo come icona selezionata = ICS
document.querySelector(".description").textContent =
  selectedTileType + " " + (reverted ? "Girato" : "Normale");
document.querySelector("#selectedIcon i").className = "fa-solid fa-x";

// Imposta una posizione di partenza per il "caricamento" della mappa
let offsetX = 0;
let offsetY = 0;
const scrollSpeed = 30;

// E per recuperare i dati successivamente
// window.onload = function () {
//   const compressedMapState = localStorage.getItem("mapState");
//   if (compressedMapState) {
//     mapTiles = JSON.parse(LZString.decompress(compressedMapState));
//     drawMap(); // Ridisegna la mappa
//   } else {
//     // Disegna la mappa inizialmente
//     drawMap(offsetX, offsetY);
//   }
// };

drawMap(offsetX, offsetY);

const isABuilding = {
  FACTORY: "yes",
  HOUSE: "yes",
  HUT: "yes",
};

// Oggetto per definire le dimensioni degli edifici
const buildingSizes = {
  FACTORY: {
    width: 220,
    height: 90,
  },
  HOUSE: {
    width: 75,
    height: 30,
  },
  ROAD: {
    width: 15,
    height: 15,
  },
  GRASS: {
    width: 15,
    height: 15,
  },
  HUT: {
    width: 15,
    height: 15,
  },
  WATER: {
    width: 10,
    height: 10,
  },
  CANCEL: {
    width: 5,
    height: 5,
  },
  ICS: {
    width: 0,
    height: 0,
  },
};

// Funzione per ottenere il colore in base al tipo di mattonella
function getTileColor(type) {
  switch (type) {
    case "WATER":
      return "#00BFFF"; // Azzurro
    case "ROAD":
      return "#7F7F7F"; // Grigio
    case "GRASS":
      return "#00FF00"; // Verde
    case "FACTORY":
      return "#FF6600"; // Arancione
    case "HOUSE":
      return "#FFFF00"; // Giallo
    case "HUT":
      return "#996600"; // Marrone
    case "CANCEL":
      return "#6DCF40"; // Bianco
    case "ICS":
      return "transparent"; // Bianco
    default:
      return "#6DCF40"; // Verde
  }
}

// Gestisce la selezione del tipo di mattonella dai bottoni
document.getElementById("ics").addEventListener("click", () => {
  selectedTileType = "ICS";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("cancel").addEventListener("click", () => {
  selectedTileType = "CANCEL";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("factory").addEventListener("click", () => {
  selectedTileType = "FACTORY";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("house").addEventListener("click", () => {
  selectedTileType = "HOUSE";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("hut").addEventListener("click", () => {
  selectedTileType = "HUT";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("road").addEventListener("click", () => {
  selectedTileType = "ROAD";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("water").addEventListener("click", () => {
  selectedTileType = "WATER";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("grass").addEventListener("click", () => {
  selectedTileType = "GRASS";
  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");
});

document.getElementById("rotate").addEventListener("click", () => {
  // Cambia la classe dell'icona
  reverted ? (reverted = false) : (reverted = true);

  document.querySelector(".description").textContent =
    selectedTileType + " " + (reverted ? "Girato" : "Normale");

  const icon = document.querySelector("#rotate i");
  icon.classList.toggle("fa-arrow-right-long");
  icon.classList.toggle("fa-arrow-down-long");

  // Inverte larghezza e altezza per ogni tipo di edificio
  for (let building in buildingSizes) {
    const temp = buildingSizes[building].width;
    buildingSizes[building].width = buildingSizes[building].height;
    buildingSizes[building].height = temp;
  }
});

// Aggiunge funzionalità di scroll per navigare la mappa
window.addEventListener("keydown", function (e) {
  switch (e.key) {
    case "ArrowUp":
      offsetY = Math.max(0, offsetY - 80);
      break;
    case "ArrowDown":
      offsetY = Math.min(MAP_SIZE - VISIBLE_TILES_Y, offsetY + 80);
      break;
    case "ArrowLeft":
      offsetX = Math.max(0, offsetX - 80);
      break;
    case "ArrowRight":
      offsetX = Math.min(MAP_SIZE - VISIBLE_TILES_X, offsetX + 80);
      break;
  }

  // Ricalcola e ridisegna la mappa basata sul nuovo offset
  drawMap(offsetX, offsetY);
});

// Script per fare class injection
document.querySelectorAll(".controls button").forEach((button) => {
  button.addEventListener("click", function () {
    if (this.id !== "ICS") {
      const selectedIcon = document.querySelector("#selectedIcon i");
      const iconClass = this.querySelector("i").className; // Ottieni la classe dell'icona del bottone cliccato
      selectedIcon.className = iconClass; // Imposta la classe dell'icona selezionata
    } else {
      const selectedIcon = document.querySelector("#selectedIcon i");
      selectedIcon.className = "ICS"; // Imposta la classe dell'icona selezionata
    }
  });
});

// Gestione del disabilitato
let previousButton = null; // Memorizza il pulsante precedentemente cliccato
document.querySelectorAll(".controls button").forEach((button) => {
  button.addEventListener("click", function () {
    // Se c'è un pulsante precedentemente cliccato, lo abilita
    if (previousButton) {
      previousButton.disabled = false;
    }
    // Disabilita il pulsante appena cliccato
    if (this.id !== "ICS") {
      this.disabled = true;
      previousButton = this; // Aggiorna il pulsante precedente
      // Aggiorna l'icona selezionata
      const selectedIcon = document.querySelector("#selectedIcon i");
      const iconClass = this.querySelector("i").className; // Ottieni la classe dell'icona
      selectedIcon.className = iconClass; // Imposta la classe dell'icona selezionata
    }
  });
});

// Inizia il disegno al mousedown
canvas.addEventListener("mousedown", function (e) {
  isABuilding[selectedTileType] ? (isDrawing = false) : (isDrawing = true);
  drawTileAtPosition(e.clientX, e.clientY); // Disegna la prima mattonella
});

// Ferma il disegno quando il mouse viene rilasciato
window.addEventListener("mouseup", function () {
  isDrawing = false;
});

// Disegna durante il trascinamento del mouse (se il mouse è premuto)
canvas.addEventListener("mousemove", function (e) {
  if (isDrawing) {
    drawTileAtPosition(e.clientX, e.clientY);
  }
});

function updateClock() {
  const now = new Date(); // Ottieni la data e l'orario correnti
  let year = now.getFullYear().toString().padStart(2, "0"); // Anno
  let month = now.getMonth().toString().padStart(2, "0"); // Mese
  let day = now.getDate().toString().padStart(2, "0"); // Giorno
  let hour = now.getHours().toString().padStart(2, "0"); // Ore
  let minute = now.getMinutes().toString().padStart(2, "0"); // Minuti
  let second = now.getSeconds().toString().padStart(2, "0"); // Secondi

  document.querySelector(".year").textContent = year;
  document.querySelector(".month").textContent = month;
  document.querySelector(".day").textContent = day;

  document.querySelector(".hour").textContent = hour;
  document.querySelector(".minute").textContent = minute;
  document.querySelector(".second").textContent = second;

  // Qui si possono implementare funzionalità per gli eventi a seconda dell'orario. Esempio ogni tot secondi possiamo richiamare una funzione,
  // se l'orario raggiunge un determinato minutaggio richiamo un'altra funzione ecc.
  if (now.getSeconds() % 10 === 0) {
    // Stampa il messaggio ogni volta che il secondo è multiplo di 10
    // console.log("Commenta alla riga 241 per non vedere questo");
  }
}
setInterval(updateClock, 1000);
// Chiamata iniziale per mostrare subito l'orario quando la pagina viene caricata
updateClock();

// Funzione per disegnare la mappa
function drawMap(offsetX, offsetY) {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  for (let x = 0; x < VISIBLE_TILES_X; x++) {
    for (let y = 0; y < VISIBLE_TILES_Y; y++) {
      const tileX = x + offsetX;
      const tileY = y + offsetY;

      if (tileX < 0 || tileY < 0 || tileX >= MAP_SIZE || tileY >= MAP_SIZE)
        continue;

      const tileType = mapTiles[tileX][tileY]; // Ottiene il tipo di mattonella
      const color = getTileColor(tileType);

      // Disegna la mattonella
      ctx.fillStyle = color;
      ctx.fillRect(x * TILE_SIZE, y * TILE_SIZE, TILE_SIZE, TILE_SIZE);

      // Verifica le celle vicine
      const leftTile = tileX > 0 ? mapTiles[tileX - 1][tileY] : null;
      const rightTile =
        tileX < MAP_SIZE - 1 ? mapTiles[tileX + 1][tileY] : null;
      const topTile = tileY > 0 ? mapTiles[tileX][tileY - 1] : null;
      const bottomTile =
        tileY < MAP_SIZE - 1 ? mapTiles[tileX][tileY + 1] : null;

      // Disegna il bordo solo agli estremi della sequenza di celle dello stesso tipo
      ctx.strokeStyle = "#000000";

      function shouldDrawBorder(adjTile) {
        return (
          adjTile !== "GRASS" && adjTile !== "default" && adjTile !== "CANCEL"
        );
      }

      // Bordo a sinistra
      if (leftTile !== tileType && shouldDrawBorder(leftTile)) {
        ctx.beginPath();
        ctx.moveTo(x * TILE_SIZE, y * TILE_SIZE);
        ctx.lineTo(x * TILE_SIZE, (y + 1) * TILE_SIZE);
        ctx.stroke();
      }

      // Bordo a destra
      if (rightTile !== tileType && shouldDrawBorder(rightTile)) {
        ctx.beginPath();
        ctx.moveTo((x + 1) * TILE_SIZE, y * TILE_SIZE);
        ctx.lineTo((x + 1) * TILE_SIZE, (y + 1) * TILE_SIZE);
        ctx.stroke();
      }

      // Bordo superiore
      if (topTile !== tileType && shouldDrawBorder(topTile)) {
        ctx.beginPath();
        ctx.moveTo(x * TILE_SIZE, y * TILE_SIZE);
        ctx.lineTo((x + 1) * TILE_SIZE, y * TILE_SIZE);
        ctx.stroke();
      }

      // Bordo inferiore
      if (bottomTile !== tileType && shouldDrawBorder(bottomTile)) {
        ctx.beginPath();
        ctx.moveTo(x * TILE_SIZE, (y + 1) * TILE_SIZE);
        ctx.lineTo((x + 1) * TILE_SIZE, (y + 1) * TILE_SIZE);
        ctx.stroke();
      }
    }
  }

  // Per salvare tutte le mattonelle
  // const compressedMapState = LZString.compress(JSON.stringify(mapTiles));
  // localStorage.setItem("mapState", compressedMapState);
}

// Funzione per gestire la logica di disegno
function drawTileAtPosition(canvasX, canvasY) {
  canvasX = canvasX - 159; // Abbasso il valore del canvasX per via del margine sinistro di 160px
  const clickedTileX = Math.floor(canvasX / TILE_SIZE + offsetX);
  const clickedTileY = Math.floor(canvasY / TILE_SIZE + offsetY);
  // selectedTileType !== 'CANCEL' ? console.log("L'angolo dove hai disegnato è: ", clickedTileX, clickedTileY) : "";

  if (selectedTileType === "FACTORY") {
    if (clickedTileX > 9720 || clickedTileY > 9910) {
      return;
    }
  }
  if (selectedTileType === "HOUSE") {
    if (clickedTileX > 9945 || clickedTileY > 9970) {
      return;
    }
  }
  if (
    selectedTileType === "ROAD" ||
    selectedTileType === "GRASS" ||
    selectedTileType === "HUT"
  ) {
    if (clickedTileX > 9985 || clickedTileY > 9985) {
      return;
    }
  }
  if (selectedTileType === "WATER") {
    if (clickedTileX > 9990 || clickedTileY > 9990) {
      return;
    }
  }

  if (
    selectedTileType === "CANCEL" &&
    isABuilding[mapTiles[clickedTileX][clickedTileY]]
  ) {
    // Controlla dove inizia la struttura
    let x = 0,
      y = 0;
    // console.log("Dove hai cliccato ora è: ", clickedTileX, clickedTileY);

    // Trovo il punto più a sinistra
    for (x = clickedTileX; isABuilding[mapTiles[x][clickedTileY]]; x--) {}
    let left = x;

    // Trovo il punto più in alto
    for (y = clickedTileY; isABuilding[mapTiles[clickedTileX][y]]; y--) {}
    let top = y;

    // Trovo il punto più a destra
    for (x = clickedTileX; isABuilding[mapTiles[x][clickedTileY]]; x++) {}
    let right = x;

    // Trovo il punto più in basso
    for (y = clickedTileY; isABuilding[mapTiles[clickedTileX][y]]; y++) {}
    let bottom = y;

    left++;
    top++;

    for (let larg = left; larg < right; larg++) {
      for (let alt = top; alt < bottom; alt++) {
        mapTiles[larg][alt] = "default";
      }
    }

    drawMap(offsetX, offsetY); // Ridisegna la mappa
    return;
  }

  if (selectedTileType && buildingSizes[selectedTileType]) {
    const { width, height } = buildingSizes[selectedTileType];

    let canBuild = true; // Variabile per controllare se è possibile costruire

    if (selectedTileType !== "CANCEL") {
      // Controlla se tutte le celle nell'area dell'edificio sono libere, il range è -1, x+1 per far sì che le strutture non si "uniscano"
      for (let i = -1; i < width + 1; i++) {
        for (let j = -1; j < height + 1; j++) {
          const tileX = clickedTileX + i;
          const tileY = clickedTileY + j;

          if (tileX < MAP_SIZE && tileY < MAP_SIZE) {
            if (
              mapTiles[tileX][tileY] !== "CANCEL" &&
              mapTiles[tileX][tileY] !== "GRASS" &&
              mapTiles[tileX][tileY] !== "default" &&
              isABuilding[mapTiles[tileX][tileY]]
            ) {
              // Se una cella è già occupata da un altro tipo di mattonella, blocca la costruzione
              // Inoltre gli edifici non possono construire "dentro se stessi"
              canBuild = false;
              break;
            }
          }
        }
        if (!canBuild) break; // Esce dal ciclo se ha trovato una cella occupata
      }
    }

    if (canBuild) {
      // Se tutte le celle sono libere, costruisci l'edificio
      for (let i = 0; i < width; i++) {
        for (let j = 0; j < height; j++) {
          if (clickedTileX + i < MAP_SIZE && clickedTileY + j < MAP_SIZE) {
            mapTiles[clickedTileX + i][clickedTileY + j] = selectedTileType;
          }
        }
      }
    }
  }

  // Ricalcola e ridisegna la mappa
  drawMap(offsetX, offsetY);

  // console.log(mapTiles[0]);
}
