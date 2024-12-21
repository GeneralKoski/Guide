// Dimensione di ciascuna cella in px da modificare a piacere,
// nel caso modificare anchele funzioni per un gridSize > 1
// const gridSize = 1;

var reverted = false; // Variabile per gestire se invertire lunghezza e larghezza delle strutture
let isDrawing = false; // Variabile per tracciare se il mouse è premuto
let selectedTileType = "ICS";
const MAP_SIZE = 10000;

document.querySelector(".description").textContent =
  selectedTileType + " " + (reverted ? "Girato" : "Normale");
document.querySelector("#selectedIcon i").className = "fa-solid fa-x";

const isABuilding = {
  FACTORY: "yes",
  HOUSE: "yes",
  HUT: "yes",
};

const previewDiv = document.getElementById("preview");

document
  .getElementById("grid-container")
  .addEventListener("mouseleave", function () {
    previewDiv.style.display = "none";
  });

// Oggetto per definire le dimensioni degli edifici
const buildingSizes = {
  FACTORY: {
    width: 340,
    height: 135,
  },
  HOUSE: {
    width: 150,
    height: 60,
  },
  ROAD: {
    width: 75,
    height: 15,
  },
  GRASS: {
    width: 25,
    height: 25,
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
    width: 15,
    height: 15,
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
document.getElementById("ICS").addEventListener("click", () => {
  selectedTileType = "ICS";
});

document.getElementById("CANCEL").addEventListener("click", () => {
  selectedTileType = "CANCEL";
});

document.getElementById("FACTORY").addEventListener("click", () => {
  selectedTileType = "FACTORY";
});

document.getElementById("HOUSE").addEventListener("click", () => {
  selectedTileType = "HOUSE";
});

document.getElementById("HUT").addEventListener("click", () => {
  selectedTileType = "HUT";
});

document.getElementById("ROAD").addEventListener("click", () => {
  selectedTileType = "ROAD";
});

document.getElementById("WATER").addEventListener("click", () => {
  selectedTileType = "WATER";
});

document.getElementById("GRASS").addEventListener("click", () => {
  selectedTileType = "GRASS";
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

// Script per fare class injection
document.querySelectorAll(".controls button").forEach((button) => {
  button.addEventListener("click", function () {
    const selectedIcon = document.querySelector("#selectedIcon i");
    const iconClass = this.querySelector("i").className; // Ottieni la classe dell'icona del bottone cliccato
    selectedIcon.className = iconClass; // Imposta la classe dell'icona selezionata

    // console.log(getTileColor(selectedTileType));
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

document
  .getElementById("grid-container")
  .addEventListener("mousedown", function (e) {
    // isABuilding[selectedTileType] ? (isDrawing = false) : (isDrawing = true);
    const { width, height } = buildingSizes[selectedTileType];
    const rect = this.getBoundingClientRect();
    const left = e.clientX - rect.left;
    const top = e.clientY - rect.top;
    const right = e.clientX - rect.left + width;
    const bottom = e.clientY - rect.top + height;

    // console.log("Occupata? ", isAreaOccupied(left, right, top, bottom));
    if (isAreaOccupied(left, right, top, bottom)) {
      isDrawing = false;
    } else {
      isDrawing = true;
      previewDiv.style.display = "none"; // Nasconde la preview
      colorCells(left, top); // Disegna la prima mattonella
    }
  });

// Ferma il disegno quando il mouse viene rilasciato
window.addEventListener("mouseup", function () {
  isDrawing = false;
});

// Disegna durante il trascinamento del mouse (se il mouse è premuto)
document
  .getElementById("grid-container")
  .addEventListener("mousemove", function (e) {
    const { width, height } = buildingSizes[selectedTileType];

    const rect = this.getBoundingClientRect();
    const left = e.clientX - rect.left;
    const top = e.clientY - rect.top;
    const right = e.clientX - rect.left + width;
    const bottom = e.clientY - rect.top + height;

    previewDiv.style.width = `${width}px`;
    previewDiv.style.height = `${height}px`;
    previewDiv.style.left = `${left + 160}px`;
    previewDiv.style.top = `${top}px`;

    previewDiv.style.display = "block";

    !isABuilding[selectedTileType] && isDrawing ? colorCells(left, top) : "";
    // if (
    //   isABuilding[selectedTileType] &&
    //   isAreaOccupied(left, right, top, bottom) &&
    //   isDrawing
    // ) {
    //   isDrawing = false;
    // } else {
    //   isDrawing ? colorCells(left, top) : "";
    // }
  });

function isAreaOccupied(newLeft, newRight, newTop, newBottom) {
  if (selectedTileType !== "CANCEL") {
    const existingTiles = document.querySelectorAll(".grid-cell");

    for (let tile of existingTiles) {
      const buildingType = tile.getAttribute("building-type");
      if (buildingType === "HOUSE") {
        console.log(buildingType);
      } else {
        console.log("CIAO");
      }
      const [left, right] = tile.getAttribute("data-x").split(",").map(Number); // Estrai il lato sinistro e destro
      const [top, bottom] = tile.getAttribute("data-y").split(",").map(Number); // Estrai il lato in alto e in basso

      // Verifica se i bordi dell'edificio nuovo si sovrappongono a un edificio esistente
      if (
        newLeft < right && // Il lato sinistro del nuovo edificio è a sinistra del lato destro dell'edificio esistente
        newRight > left && // Il lato destro del nuovo edificio è a destra del lato sinistro dell'edificio esistente
        newTop < bottom && // Il lato superiore del nuovo edificio è sopra il lato inferiore dell'edificio esistente
        newBottom > top // Il lato inferiore del nuovo edificio è sotto il lato superiore dell'edificio esistente
      ) {
        return true; // C'è una sovrapposizione
      }
    }
  }

  return false; // Non c'è sovrapposizione, l'area è libera
}

// Funzione per colorare le celle nel quadrato 10x10 intorno al punto cliccato
function colorCells(startX, startY) {
  //   console.log(startX, startY);
  const gridContainer = document.getElementById("grid-container");
  const { width, height } = buildingSizes[selectedTileType];

  // if (selectedTileType === "CANCEL") {
  //   // Se il tipo selezionato è "CANCEL", rimuovi la div nella posizione cliccata
  //   const buildingToRemove = findBuildingAt(startX, startY);
  //   if (buildingToRemove) {
  //     buildingToRemove.remove(); // Rimuove la div esistente
  //     console.log("Building removed at:", startX, startY);
  //   }
  //   return; // Interrompe la funzione qui
  // }

  // Creiamo una sola div per l'oggetto
  const objectDiv = document.createElement("div");
  objectDiv.classList.add("grid-cell");
  //   objectDiv.setAttribute("data-x", startX);
  //   objectDiv.setAttribute("data-y", startY);
  objectDiv.setAttribute("data-x", `${startX},${startX + width}`);
  objectDiv.setAttribute("data-y", `${startY},${startY + height}`);
  objectDiv.setAttribute("building-type", selectedTileType);
  // console.log(`${startX},${startX + width}`);
  // console.log(`${startY},${startY + height}`);
  // Impostiamo la larghezza, altezza, e posizione dell'oggetto
  objectDiv.style.width = `${width}px`;
  objectDiv.style.height = `${height}px`;

  // Assicurati che startX e startY siano posizioni relative alla griglia
  objectDiv.style.left = `${startX}px`;
  objectDiv.style.top = `${startY}px`;

  // Impostiamo il colore dell'oggetto
  objectDiv.style.backgroundColor = getTileColor(selectedTileType);

  // Disegno il bordo
  if (selectedTileType !== "ICS" && selectedTileType !== "CANCEL")
    objectDiv.style.border = "1px solid black";

  // Aggiungiamo la div all'interno del container della griglia
  gridContainer.appendChild(objectDiv);
}

function findBuildingAt(x, y) {
  const buildings = document.querySelectorAll(".building"); // Supponendo che le div delle costruzioni abbiano una classe 'building'

  for (let building of buildings) {
    const rect = building.getBoundingClientRect();

    // Controlla se il punto cliccato (x, y) si trova all'interno della costruzione
    if (
      x >= rect.left &&
      x <= rect.right &&
      y >= rect.top &&
      y <= rect.bottom
    ) {
      return building; // Restituisce la div trovata
    }
  }
  return null; // Nessuna costruzione trovata
}
