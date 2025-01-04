// Effettua la fetch verso allMaps.php
fetch("http://localhost:3000/php/allMaps.php")
  .then((response) => response.json())
  .then((data) => {
    // Ottieni il container dove mettere le mappe
    const grigliaMappa = document.querySelector(".griglia-mappa");

    // Itera sui dati ricevuti
    data.forEach((mappa) => {
      // Crea una nuova div per ogni mappa
      const boxMappa = document.createElement("div");
      boxMappa.classList.add("box-mappa");
      boxMappa.style.cursor = "pointer";
      boxMappa.onclick = () => {
        window.location.href = "/Map/map.html?id=" + mappa.id; // Passa l'id mappa nell'URL
      };

      // Crea l'immagine
      const immagineMappa = document.createElement("img");
      immagineMappa.classList.add("immagine-mappa");
      immagineMappa.src = "/php/uploads/" + mappa.image; // Usa un campo per l'URL immagine
      immagineMappa.alt = `Immagine ${mappa.name}`;

      // Crea il titolo
      const titoloMappa = document.createElement("h3");
      titoloMappa.classList.add("titolo-mappa");
      titoloMappa.textContent = mappa.name;

      // Crea la descrizione
      const descrizioneMappa = document.createElement("p");
      descrizioneMappa.classList.add("descrizione-mappa");
      descrizioneMappa.textContent = mappa.description;

      // Crea la descrizione
      const felicitaMappa = document.createElement("p");
      felicitaMappa.classList.add("felicita-mappa");
      felicitaMappa.textContent = "Happiness: " + mappa.happiness;

      // Crea la descrizione
      const abitantiMappa = document.createElement("p");
      abitantiMappa.classList.add("cittadini-mappa");
      abitantiMappa.textContent = "Citizens: " + mappa.citizens;

      // Crea il bottone di eliminazione
      const bottoneElimina = document.createElement("button");
      bottoneElimina.classList.add("delete-button");
      bottoneElimina.textContent = "DELETE";

      // Aggiungi un event listener per eliminare la mappa
      bottoneElimina.addEventListener("click", (event) => {
        event.stopPropagation(); // Evita che l'evento click sulla box si attivi
        if (confirm(`Sei sicuro di voler eliminare la mappa ${mappa.name}?`)) {
          // Chiamata per eliminare la mappa dal server, ad esempio tramite fetch
          fetch(`http://localhost:3000/php/deleteMap.php?id=${mappa.id}`, {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: mappa.id }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                grigliaMappa.removeChild(boxMappa);
              } else {
                alert("Errore nell'eliminazione della mappa.");
              }
            })
            .catch((error) => {
              console.error("Errore nella richiesta di eliminazione:", error);
            });
        }
      });

      // Aggiungi immagine, titolo e descrizione alla box-mappa
      boxMappa.appendChild(immagineMappa);
      boxMappa.appendChild(titoloMappa);
      boxMappa.appendChild(descrizioneMappa);
      boxMappa.appendChild(abitantiMappa);
      boxMappa.appendChild(felicitaMappa);
      boxMappa.appendChild(bottoneElimina);

      // Aggiungi la nuova mappa alla griglia
      grigliaMappa.appendChild(boxMappa);
    });
  })
  .catch((error) => {
    console.error("Errore nel caricamento delle mappe:", error);
  });

document.getElementById("createMap").onclick = function () {
  window.location.href = "/CreateMap/createMap.html";
};
