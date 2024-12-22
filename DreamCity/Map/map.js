var rotated = false; // Variabile per gestire se invertire lunghezza e larghezza delle strutture
let selectedTileType = "ICS"; // Inizializzazione della variabile che terrà conto dell'edificio selezionato
const MAP_SIZE = 10000; // Dimensione della mappa, 10000x10000 per questo progetto

// Codice per impostare l'icona selezionata, inizializzati come ICS Normale
document.querySelector(".selectedDescription").textContent =
  selectedTileType + " " + (rotated ? "Girato" : "Normale");
document.querySelector("#selectedIcon i").className = "fa-solid fa-x";

// E' la div che fa vedere la preview dell'elemento selezionato, mentre ti muovi con il mouse
const previewDiv = document.getElementById("preview");

// Per vedere cos'è un edificio. Array utile al momento solo per disegnarci il bordo
const isABuilding = {
  FACTORY: "yes",
  HOUSE: "yes",
  HUT: "yes",
};

// Array per definire le dimensioni degli elementi
const buildingSizes = {
  FACTORY: {
    width: 340,
    height: 135,
  },
  HOUSE: {
    width: 150,
    height: 60,
  },
  ROUNDABOUT: {
    width: 80,
    height: 80,
  },
  ROAD: {
    width: 75,
    height: 15,
  },
  HUT: {
    width: 15,
    height: 15,
  },
  WATER: {
    width: 80,
    height: 80,
  },
  ICS: {
    width: 0,
    height: 0,
  },
};

// Funzione per ottenere il colore in base al tipo di elemento
function getTileColor(type) {
  switch (type) {
    case "WATER":
      return "#00BFFF"; // Azzurro
    case "ROAD":
      return "#7F7F7F"; // Grigio
    case "FACTORY":
      return "#FF6600"; // Arancione
    case "HOUSE":
      return "#FFFF00"; // Giallo
    case "HUT":
      return "#996600"; // Marrone
    case "ICS":
      return "transparent"; // Trasparente
    case "ROUNDABOUT":
      return "transparent"; // Trasparente perchè il "buco" è gestito dal CSS
    default:
      return "#6DCF40"; // Verde
  }
}

// Gestisce la selezione dell'elemento dai bottoni e imposta il valore all'icona selezionata
document.getElementById("ICS").addEventListener("click", () => {
  selectedTileType = "ICS";
  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");
});

document.getElementById("FACTORY").addEventListener("click", () => {
  selectedTileType = "FACTORY";
  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");
});

document.getElementById("HOUSE").addEventListener("click", () => {
  selectedTileType = "HOUSE";
  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");
});

document.getElementById("HUT").addEventListener("click", () => {
  selectedTileType = "HUT";
  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");
});

document.getElementById("ROAD").addEventListener("click", () => {
  selectedTileType = "ROAD";
  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");
});

document.getElementById("WATER").addEventListener("click", () => {
  selectedTileType = "WATER";
  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");
});

document.getElementById("ROUNDABOUT").addEventListener("click", () => {
  selectedTileType = "ROUNDABOUT";
  const desc = "ROTONDA";
  document.querySelector(".selectedDescription").textContent =
    desc + " " + (rotated ? "Girato" : "Normale");
});

// Gestione dell'icona per la rotazione degli edifici di 90°
document.getElementById("rotate").addEventListener("click", () => {
  rotated ? (rotated = false) : (rotated = true);

  document.querySelector(".selectedDescription").textContent =
    selectedTileType + " " + (rotated ? "Girato" : "Normale");

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

// Script per per gestire l'elemento selezionato
document.querySelectorAll(".controls button").forEach((button) => {
  button.addEventListener("click", function () {
    const selectedIcon = document.querySelector("#selectedIcon i");
    const iconClass = this.querySelector("i").className; // L'icona del bottone cliccato
    selectedIcon.className = iconClass;
  });
});

// Gestione del disabilitato, inizializzando ICS come selezionato
let previousButton = document.querySelector("#ICS");
previousButton.disabled = true;

document.querySelectorAll(".controls button").forEach((button) => {
  button.addEventListener("click", function () {
    // Se c'è un pulsante precedentemente cliccato, lo abilita
    if (previousButton) {
      previousButton.disabled = false;
    }
    // Disabilita il pulsante appena cliccato
    this.disabled = true;
    previousButton = this;
    // Aggiorna l'icona selezionata
    const selectedIcon = document.querySelector("#selectedIcon i");
    const iconClass = this.querySelector("i").className;
    selectedIcon.className = iconClass;
  });
});

// Funzione per ottenere l'orario attuale
function updateClock() {
  const now = new Date(); // Ottieni la data e l'orario correnti
  let year = now.getFullYear().toString().padStart(2, "0"); // Anno
  let month = now.getMonth().toString().padStart(2, "0"); // Mese
  let day = now.getDate().toString().padStart(2, "0"); // Giorno
  let hour = now.getHours().toString().padStart(2, "0"); // Ore
  let minute = now.getMinutes().toString().padStart(2, "0"); // Minuti
  let second = now.getSeconds().toString().padStart(2, "0"); // Secondi

  // Imposto gli span con gli orari
  document.querySelector(".year").textContent = year;
  document.querySelector(".month").textContent = month;
  document.querySelector(".day").textContent = day;
  document.querySelector(".hour").textContent = hour;
  document.querySelector(".minute").textContent = minute;
  document.querySelector(".second").textContent = second;
}
// Chiamata iniziale per mostrare subito l'orario quando la pagina viene caricata
updateClock();

// Chiamo la funzione ogni secondo per un aggiornamento costante
setInterval(updateClock, 1000);

// Gestione dei vari click
document
  .getElementById("grid-container")
  .addEventListener("mousedown", function (e) {
    const { width, height } = buildingSizes[selectedTileType]; // Dimensioni dell'elemento selezionato
    const rect = this.getBoundingClientRect();
    // Prendo le coordinate
    const cleft = e.clientX - rect.left;
    const ctop = e.clientY - rect.top;
    const cright = e.clientX - rect.left + width;
    const cbottom = e.clientY - rect.top + height;

    const result = isAreaOccupied(cleft, cright, ctop, cbottom); // Controllo se dove ho cliccato è già presente qualcosa

    if (result[0].success === true) {
      // Se c'è qualcosa e ho selezionato il tasto per cancellare cancello la div
      if (selectedTileType === "ICS") {
        result[0].foundDiv.remove();
      }
      return;
    } else {
      // Se non c'è nulla, disegno
      previewDiv.style.display = "none"; // Nasconde la preview finchè non mi muovo con il mouse
      colorCells(cleft, ctop); // Disegna la div
    }
  });

// Per nascondere la preview quando il moouse esce dall'area di disegno
document
  .getElementById("grid-container")
  .addEventListener("mouseleave", function () {
    previewDiv.style.display = "none";
  });

// Muove la preview durante il trascinamento del mouse
document
  .getElementById("grid-container")
  .addEventListener("mousemove", function (e) {
    const { width, height } = buildingSizes[selectedTileType]; // Prendo le dimensioni dell'elemento selezionato

    const rect = this.getBoundingClientRect();
    const left = e.clientX - rect.left;
    const top = e.clientY - rect.top;

    previewDiv.style.width = `${width}px`;
    previewDiv.style.height = `${height}px`;
    previewDiv.style.left = `${left + 160}px`; // +160 per il margin-left del grid-container
    previewDiv.style.top = `${top}px`;
    previewDiv.style.display = "block";
  });

// Funzione per vedere se c'è spazio per piazzare l'elemento selezionato
function isAreaOccupied(newLeft, newRight, newTop, newBottom) {
  const existingTiles = document.querySelectorAll(".grid-cell"); // Seleziona tutte le div che esistono e controllo per ognuna
  for (let tile of existingTiles) {
    const buildingType = tile.getAttribute("building-type"); // Prendo il suo tipo di elemento
    const [left, right] = tile.getAttribute("data-x").split(",").map(Number); // Trovo il lato sinistro e destro
    const [top, bottom] = tile.getAttribute("data-y").split(",").map(Number); // Trovo il lato superiore e inferiore
    // Verifica se i bordi dell'edificio nuovo si sovrappongono a un edificio esistente
    if (
      newLeft < right && // Il lato sinistro del nuovo edificio è a sinistra del lato destro dell'edificio esistente
      newRight > left && // Il lato destro del nuovo edificio è a destra del lato sinistro dell'edificio esistente
      newTop < bottom && // Il lato superiore del nuovo edificio è sopra il lato inferiore dell'edificio esistente
      newBottom > top // Il lato inferiore del nuovo edificio è sotto il lato superiore dell'edificio esistente
    ) {
      return [{ foundDiv: tile, success: true }]; // C'è già qualcosa
    }
  }
  return [{ success: false }]; // L'area è libera
}

// Funzione per creare la div
function colorCells(startX, startY) {
  const gridContainer = document.getElementById("grid-container"); // All'intern dell'area
  const { width, height } = buildingSizes[selectedTileType]; // Prendo le dimensioni dell'elemento selezionato
  const objectDiv = document.createElement("div"); // Creo una div
  objectDiv.classList.add("grid-cell"); // La div avrà classe grid-cell definita nel CSS
  // Se ho selezionato la rotonda, ha una classe specifica nel CSS
  if (selectedTileType === "ROUNDABOUT") {
    objectDiv.classList.add("roundabout");
  }
  // I valori che mi serviranno per inserirli nel DB e ricaricarli in futuro
  objectDiv.setAttribute("data-x", `${startX},${startX + width}`); // Gli inietto le sue coordinate orizzontali come classe
  objectDiv.setAttribute("data-y", `${startY},${startY + height}`); // Gli inietto le sue coordinate verticali come classe
  objectDiv.setAttribute("building-type", selectedTileType); // Gli inietto l'elemento selezionato come classe
  // Definisco la larghezza, altezza, e posizione dell'elemento
  objectDiv.style.width = `${width}px`;
  objectDiv.style.height = `${height}px`;
  objectDiv.style.left = `${startX}px`;
  objectDiv.style.top = `${startY}px`;
  // Imposto il colore dell'elemento in base al suo valore nell'array
  objectDiv.style.backgroundColor = getTileColor(selectedTileType);
  // Disegno il bordo solo se è un edificio
  if (isABuilding[selectedTileType]) {
    objectDiv.style.border = "1px solid black";
  }
  // Aggiungo la div all'interno del grid-container
  gridContainer.appendChild(objectDiv);
}
