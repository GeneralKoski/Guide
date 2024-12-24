// Fetch per perndere i dettagli dell'utente loggato
fetch("http://localhost:3000/php/userDetails.php")
  .then((response) => response.json())
  .then((data) => {
    document.getElementById("username").textContent = data.username;
    document.getElementById("role").textContent = data.role;
    budget = parseInt(data.budget, 10);
    updateBudgetSpan();
  })
  .catch((error) => console.error("Errore nella richiesta:", error));

let happiness = 0;
let budget = 0;

// Fetch per ottenere il valore iniziale di happiness
fetch("http://localhost:3000/php/mapDetails.php")
  .then((response) => response.json())
  .then((data) => {
    document.getElementById("mapName").textContent = data.name;
    happiness = parseInt(data.happiness, 10);
    updateHappinessSpan();
  })
  .catch((error) => console.error("Errore nella richiesta:", error));

function updateMapBuildingsDB(x_coordinate, y_coordinate) {
  fetch(
    `http://localhost:3000/php/updateMapBuildings.php?x_coordinate=${x_coordinate}&y_coordinate=${y_coordinate}`
  ).catch((error) => console.error("Errore nella richiesta:", error));

  changeHappinessLevel(happiness); // Al posto di 1 c'è da mettere il quantitativo di felicità che aumenta la struttura cliccata
}
function updateBudgetDB(budget) {
  // console.log(budget);
  fetch(`http://localhost:3000/php/updateBudget.php?budget=${budget}`).catch(
    (error) => console.error("Errore nella richiesta:", error)
  );

  changeBudgetLevel(budget); // Al posto di 1 c'è da mettere il quantitativo di felicità che aumenta la struttura cliccata
}

// Funzione per aggiornare nel DB il valore della felicità
function updateHappinessDB(happiness) {
  fetch(
    `http://localhost:3000/php/updateHappiness.php?value=${happiness}`
  ).catch((error) => console.error("Errore nella richiesta:", error));

  changeHappinessLevel(happiness); // Al posto di 1 c'è da mettere il quantitativo di felicità che aumenta la struttura cliccata
}

function changeBudgetLevel(newBudget) {
  budget = newBudget;
  updateBudgetSpan();
}

// Funzione per cambiare il valore di happiness in locale
function changeHappinessLevel(newHappiness) {
  happiness = newHappiness;
  updateHappinessSpan();
}

function updateBudgetSpan() {
  document.getElementById("budget").textContent = budget;
}

// Funzione per aggiornare lo span con il valore corrente di happiness
function updateHappinessSpan() {
  document.getElementById("happiness").textContent = happiness;

  const progressBar = document.querySelector(".progress-bar");
  progressBar.style.width = `${happiness / 100}%`;
}

function saveBuildingDB(buildingType, x, y, rotated) {
  // console.log(rotated);
  fetch("http://localhost:3000/php/saveBuilding.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      building_type: buildingType,
      x: x,
      y: y,
      rotated: rotated ? "yes" : "no",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status !== "success") {
        console.error("Errore nel salvataggio dell'edificio:", data.message);
      }
    })
    .catch((error) => console.error("Errore nella richiesta:", error));
}

// building.x_coordinate, building.y_coordinate, building.building_type;

function loadBuildings() {
  fetch("http://localhost:3000/php/loadBuildings.php")
    .then((response) => response.json())
    .then((buildings) => {
      buildings.forEach((building) => {
        const gridContainer = document.getElementById("grid-container"); // All'intern dell'area
        let width = buildingSizes[building.building_type].width; // Prendo le dimensioni dell'elemento selezionato
        let height = buildingSizes[building.building_type].height;
        // console.log(building.rotated);
        if (building.rotated === "yes") {
          let temp = width;
          width = height;
          height = temp;
        }

        const objectDiv = document.createElement("div"); // Creo una div
        objectDiv.classList.add("grid-cell"); // La div avrà classe grid-cell definita nel CSS
        // Se ho selezionato la rotonda, ha una classe specifica nel CSS
        if (building.building_type === "ROUNDABOUT") {
          objectDiv.classList.add("roundabout");
        }

        const xCoordinate = parseInt(building.x_coordinate, 10);
        const yCoordinate = parseInt(building.y_coordinate, 10);

        objectDiv.setAttribute(
          "data-x",
          `${building.x_coordinate},${xCoordinate + width}`
        ); // Gli inietto le sue coordinate orizzontali come classe

        objectDiv.setAttribute(
          "data-y",
          `${building.y_coordinate},${yCoordinate + height}`
        ); // Gli inietto le sue coordinate verticali come classe
        objectDiv.setAttribute("building-type", building.building_type); // Gli inietto l'elemento selezionato come classe
        // Definisco la larghezza, altezza, e posizione dell'elemento
        objectDiv.style.width = `${width}px`;
        objectDiv.style.height = `${height}px`;
        objectDiv.style.left = `${building.x_coordinate}px`;
        objectDiv.style.top = `${building.y_coordinate}px`;

        // Imposto il colore dell'elemento in base al suo valore nell'array
        objectDiv.style.backgroundColor = getTileColor(building.building_type);
        // Disegno il bordo solo se è un edificio
        if (
          building.building_type !== "WATER" &&
          building.building_type !== "ROAD" &&
          building.building_type !== "ROUNDABOUT"
        ) {
          objectDiv.style.border = "1px solid black";
        }
        // Aggiungo la div all'interno del grid-container
        gridContainer.appendChild(objectDiv);
      });
    })
    .catch((error) =>
      console.error("Errore nel caricamento degli edifici:", error)
    );
}

var rotated = false; // Variabile per gestire se invertire lunghezza e larghezza delle strutture
let buildingType = ""; // Inizializzazione della variabile che terrà conto dell'edificio selezionato
const MAP_SIZE = 10000; // Dimensione della mappa, 10000x10000 per questo progetto
var isDrawing = false;

// E' la div che fa vedere la preview dell'elemento selezionato, mentre ti muovi con il mouse
const previewDiv = document.getElementById("preview");

let userBuildings = [];

fetch("http://localhost:3000/php/selectUserBuildings.php")
  .then((response) => response.json())
  .then((buildings) => {
    const controlsContainer = document.querySelector(".controls");
    controlsContainer.innerHTML = ""; // Svuota i pulsanti esistenti

    // Aggiungi il pulsante CANC manualmente
    const CANCButton = document.createElement("button");
    CANCButton.id = "CANC";

    // Aggiungi un'icona o una descrizione al pulsante CANC
    const CANCSpan = document.createElement("span");
    CANCSpan.textContent = "CANC";
    CANCButton.appendChild(CANCSpan);

    // Aggiungi l'event listener per il pulsante CANC
    CANCButton.addEventListener("click", () => {
      buildingType = "CANC"; // Imposta buildingType a CANC
      document.querySelector(".selectedDescription").textContent =
        buildingType + " " + (rotated ? "Girato" : "Normale");
      document.querySelector("#selectedIcon i").textContent = "CANC";
    });

    userBuildings.push("CANC");

    // Aggiungi il pulsante CANC al container
    controlsContainer.appendChild(CANCButton);

    // Ciclo per aggiungere gli altri pulsanti dinamicamente
    buildings.forEach((building) => {
      // Crea un nuovo pulsante per ogni edificio
      const button = document.createElement("button");
      button.id = building.name; // Imposta l'id in base al nome

      // Crea una <span> con le prime 3 lettere del nome
      const span = document.createElement("span");
      span.textContent = building.name.substring(0, 4); // Prime 3 lettere

      // Aggiungi lo span al pulsante
      button.appendChild(span);

      // Aggiungi l'event listener per ogni pulsante dinamico
      button.addEventListener("click", () => {
        buildingType = building.name; // Imposta il buildingType al nome cliccato
        document.querySelector(".selectedDescription").textContent =
          buildingType + " " + (rotated ? "Girato" : "Normale");
        document.querySelector("#selectedIcon i").textContent =
          buildingType.substring(0, 4);
      });

      if (!userBuildings.includes(building.name)) {
        userBuildings.push(building.name);
      }
      // Aggiungi il pulsante al container
      controlsContainer.appendChild(button);
    });
  })
  .catch((error) =>
    console.error("Errore nella selezione degli edifici:", error)
  );

fetch("http://localhost:3000/php/selectBuildings.php")
  .then((response) => response.json())
  .then((buildings) => {
    buildings.forEach((building) => {
      // Definisci il tipo di edificio e crea l'oggetto corrispondente con dimensioni e colore
      buildingSizes[building.name] = {
        width: parseInt(building.width, 10),
        height: parseInt(building.height, 10),
      };

      // Aggiungi il colore per ogni edificio nel metodo getTileColor
      buildingColors[building.name] = building.color;

      buildingHappiness[building.name] = building.happiness;

      buildingCosts[building.name] = building.cost;
    });

    buildingSizes["CANC"] = {
      width: 0,
      height: 0,
    };
    buildingColors["CANC"] = "transparent";
    buildingHappiness["CANC"] = 0;
    buildingCosts["CANC"] = 0;
  })
  .catch((error) =>
    console.error("Errore nel caricamento degli edifici:", error)
  );
const buildingSizes = {};
const buildingColors = {};
const buildingHappiness = {};
const buildingCosts = {};

// Funzione per ottenere il colore in base al tipo di elemento
function getTileColor(type) {
  return buildingColors[type];
}

// Gestione dell'icona per la rotazione degli edifici di 90°
document.getElementById("rotate").addEventListener("click", () => {
  rotated ? (rotated = false) : (rotated = true);

  document.querySelector(".selectedDescription").textContent =
    buildingType + " " + (rotated ? "Girato" : "Normale");

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

// Gestione del disabilitato, inizializzando CANC come selezionato
let previousButton = document.querySelector("#CANC");
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

setTimeout(loadBuildings());

// Gestione dei vari click
document
  .getElementById("grid-container")
  .addEventListener("mousedown", function (e) {
    if (buildingType) {
      isDrawing = true;
      const width = buildingSizes[buildingType].width; // Prendo le dimensioni dell'elemento selezionato
      const height = buildingSizes[buildingType].height;
      const rect = this.getBoundingClientRect();
      // Prendo le coordinate
      const cleft = e.clientX - rect.left;
      const ctop = e.clientY - rect.top;
      const cright = e.clientX - rect.left + width;
      const cbottom = e.clientY - rect.top + height;
      // console.log(buildingCosts[buildingType]);
      // console.log(budget);
      const result = isAreaOccupied(cleft, cright, ctop, cbottom); // Controllo se dove ho cliccato è già presente qualcosa

      if (result[0].success === true) {
        // Se c'è qualcosa e ho selezionato il tasto per cancellare cancello la div
        if (buildingType === "CANC") {
          const buildingType = result[0].tile.getAttribute("building-type"); // Prendo il suo tipo di elemento
          if (userBuildings.includes(buildingType)) {
            const [x_coordinate, xr] = result[0].tile.dataset.x
              .split(",")
              .map(Number); // Trovo il lato sinistro e destro
            const [y_coordinate, yr] = result[0].tile.dataset.y
              .split(",")
              .map(Number); // Trovo il lato superiore e inferiore
            result[0].tile.remove();

            updateMapBuildingsDB(x_coordinate, y_coordinate);

            updateHappinessDB(
              parseInt(happiness) -
                parseInt(buildingHappiness[result[0].buildingType])
            );

            updateBudgetDB(
              parseInt(budget) + parseInt(buildingCosts[result[0].buildingType])
            );
          } else {
            console.log("Non possiedi questo edificio");
            return;
          }
        } else {
          console.log("Non hai abbastanza spazio qui");
          return;
        }
      } else {
        if (buildingType !== "CANC") {
          // Se non c'è nulla, disegno
          previewDiv.style.display = "none"; // Nasconde la preview finchè non mi muovo con il mouse

          colorCells(cleft, ctop, buildingType); // Disegna la div

          updateHappinessDB(
            parseInt(happiness) + parseInt(buildingHappiness[buildingType])
          );

          updateBudgetDB(
            parseInt(budget) - parseInt(buildingCosts[buildingType])
          );

          saveBuildingDB(buildingType, cleft, ctop, rotated);
        }
      }
    }
  });

document
  .getElementById("grid-container")
  .addEventListener("mouseup", function () {
    isDrawing = false;
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
    if (buildingType) {
      const width = buildingSizes[buildingType].width; // Prendo le dimensioni dell'elemento selezionato
      const height = buildingSizes[buildingType].height;

      const rect = this.getBoundingClientRect();
      const left = e.clientX - rect.left;
      const top = e.clientY - rect.top;
      const right = e.clientX - rect.left + width;
      const bottom = e.clientY - rect.top + height;

      previewDiv.style.width = `${width}px`;
      previewDiv.style.height = `${height}px`;
      previewDiv.style.left = `${left + 160}px`; // +160 per il margin-left del grid-container
      previewDiv.style.top = `${top}px`;
      previewDiv.style.display = "block";

      // const result = isAreaOccupied(cleft, cright, ctop, cbottom); // Controllo se dove ho cliccato è già presente qualcosa
      // console.log(result);
      // if (result[0].success === true) {
      // console.log(isAreaOccupied(left, right, top, bottom));
      if (
        document.getElementById("role").textContent ===
          "Gestione delle strade" &&
        buildingType !== "ROUNDABOUT" &&
        isAreaOccupied(left, right, top, bottom)[0].success === false &&
        isDrawing &&
        buildingType !== "CANC"
      ) {
        const rect = this.getBoundingClientRect();
        const left = e.clientX - rect.left;
        const top = e.clientY - rect.top;
        colorCells(left, top, buildingType);
        updateHappinessDB(
          parseInt(happiness) + parseInt(buildingHappiness[buildingType])
        );

        updateBudgetDB(
          parseInt(budget) - parseInt(buildingCosts[buildingType])
        );

        saveBuildingDB(buildingType, left, top, rotated);
      }
    }
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
      // if (tile.building_type !== undefined) {
      //   return [{ foundDiv: tile.building_type, success: true }]; // C'è già qualcosa
      // }
      return [
        {
          tile: tile,
          buildingType: buildingType,
          success: true,
        },
      ]; // C'è già qualcosa
    }
  }
  return [{ success: false }]; // L'area è libera
}

// Funzione per creare la div
function colorCells(startX, startY, buildingType) {
  const gridContainer = document.getElementById("grid-container"); // All'intern dell'area
  const width = buildingSizes[buildingType].width; // Prendo le dimensioni dell'elemento selezionato
  const height = buildingSizes[buildingType].height;
  const objectDiv = document.createElement("div"); // Creo una div
  objectDiv.classList.add("grid-cell"); // La div avrà classe grid-cell definita nel CSS
  // Se ho selezionato la rotonda, ha una classe specifica nel CSS
  if (buildingType === "ROUNDABOUT") {
    objectDiv.classList.add("roundabout");
  }
  // I valori che mi serviranno per inserirli nel DB e ricaricarli in futuro
  objectDiv.setAttribute("data-x", `${startX},${startX + width}`); // Gli inietto le sue coordinate orizzontali come classe
  objectDiv.setAttribute("data-y", `${startY},${startY + height}`); // Gli inietto le sue coordinate verticali come classe
  objectDiv.setAttribute("building-type", buildingType); // Gli inietto l'elemento selezionato come classe
  // Definisco la larghezza, altezza, e posizione dell'elemento
  objectDiv.style.width = `${width}px`;
  objectDiv.style.height = `${height}px`;
  objectDiv.style.left = `${startX}px`;
  objectDiv.style.top = `${startY}px`;
  // Imposto il colore dell'elemento in base al suo valore nell'array
  objectDiv.style.backgroundColor = getTileColor(buildingType);
  // Disegno il bordo solo se è un edificio
  if (
    buildingType !== "WATER" &&
    buildingType !== "ROAD" &&
    buildingType !== "ROUNDABOUT"
  ) {
    objectDiv.style.border = "1px solid black";
  }
  // Aggiungo la div all'interno del grid-container
  gridContainer.appendChild(objectDiv);
}
