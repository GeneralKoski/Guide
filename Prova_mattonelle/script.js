

const canvas = document.getElementById('tileCanvas');
const ctx = canvas.getContext('2d');

// Definire le dimensioni della mappa e delle mattonelle
const MAP_SIZE = 10000;
const TILE_SIZE = 15; // Dimensione di ogni mattonella (in pixel)
const VISIBLE_TILES_X = Math.ceil(window.innerWidth / TILE_SIZE - 21);
const VISIBLE_TILES_Y = Math.ceil(window.innerHeight / TILE_SIZE);

// Crea una matrice per memorizzare i tipi di mattonelle
const mapTiles = Array.from({
    length: MAP_SIZE
}, () => Array(MAP_SIZE).fill('default'));

// Imposta la dimensione del canvas pari alla dimensione dello schermo
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let isDrawing = false; // Variabile per tracciare se il mouse è premuto

// Variabile per memorizzare il tipo di mattonella selezionata
let selectedTileType = '';

// Imposta una posizione di partenza per il "caricamento" della mappa
let offsetX = 0;
let offsetY = 0;

// Disegna la mappa inizialmente
drawMap(offsetX, offsetY);

// Oggetto per definire le dimensioni degli edifici
const buildingSizes = {
    'FACTORY': {
        width: 10,
        height: 3
    },
    'HOUSE': {
        width: 5,
        height: 2
    },
};

// Funzione per ottenere il colore in base al tipo di mattonella
function getTileColor(type) {
    switch (type) {
        case 'WATER':
            return '#00BFFF'; // Azzurro
        case 'ROAD':
            return '#7F7F7F'; // Grigio
        case 'GRASS':
            return '#00FF00'; // Verde
        case 'FACTORY':
            return '#FF6600'; // Arancione
        case 'HOUSE':
            return '#FFFF00'; // Giallo
        case 'HUT':
            return '#996600'; // Marrone
        case 'CANCEL':
            return '#FFFFFF'; // Bianco
        default:
            return '#6DCF40'; // Verde
    }
}

// Gestisce la selezione del tipo di mattonella dai bottoni
document.getElementById('cancel').addEventListener('click', () => {
    selectedTileType = 'CANCEL';
});

document.getElementById('factory').addEventListener('click', () => {
    selectedTileType = 'FACTORY';
});

document.getElementById('house').addEventListener('click', () => {
    selectedTileType = 'HOUSE';
});

document.getElementById('hut').addEventListener('click', () => {
    selectedTileType = 'HUT';
});

document.getElementById('road').addEventListener('click', () => {
    selectedTileType = 'ROAD';
});

document.getElementById('water').addEventListener('click', () => {
    selectedTileType = 'WATER';
});

document.getElementById('grass').addEventListener('click', () => {
    selectedTileType = 'GRASS';
});

// Aggiunge funzionalità di scroll per navigare la mappa
window.addEventListener('keydown', function(e) {
    switch (e.key) {
        case 'ArrowUp':
            offsetY = Math.max(0, offsetY - 20);
            break;
        case 'ArrowDown':
            offsetY = Math.min(MAP_SIZE - VISIBLE_TILES_Y, offsetY + 20);
            break;
        case 'ArrowLeft':
            offsetX = Math.max(0, offsetX - 20);
            break;
        case 'ArrowRight':
            offsetX = Math.min(MAP_SIZE - VISIBLE_TILES_X, offsetX + 20);
            break;
    }

    // Ricalcola e ridisegna la mappa basata sul nuovo offset
    drawMap(offsetX, offsetY);
});

// Funzione per disegnare la porzione visibile della mappa
function drawMap(offsetX, offsetY) {
    for (let x = 0; x < VISIBLE_TILES_X; x++) {
        for (let y = 0; y < VISIBLE_TILES_Y; y++) {
            const tileX = x + offsetX;
            const tileY = y + offsetY;

            if (tileX < 0 || tileY < 0 || tileX >= MAP_SIZE || tileY >= MAP_SIZE) continue;

            const tileType = mapTiles[tileX][tileY]; // Ottiene il tipo di mattonella
            const color = getTileColor(tileType);

            // Disegna la mattonella
            ctx.fillStyle = color;
            ctx.fillRect(x * TILE_SIZE, y * TILE_SIZE, TILE_SIZE, TILE_SIZE);

            // Verifica le celle vicine
            const leftTile = tileX > 0 ? mapTiles[tileX - 1][tileY] : null;
            const rightTile = tileX < MAP_SIZE - 1 ? mapTiles[tileX + 1][tileY] : null;
            const topTile = tileY > 0 ? mapTiles[tileX][tileY - 1] : null;
            const bottomTile = tileY < MAP_SIZE - 1 ? mapTiles[tileX][tileY + 1] : null;

            // Disegna il bordo solo agli estremi della sequenza di celle dello stesso tipo
            ctx.strokeStyle = '#000000';

            function shouldDrawBorder(adjTile) {
                return adjTile !== 'GRASS' && adjTile !== 'default';
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
}

// Funzione per gestire la logica di disegno
function drawTileAtPosition(canvasX, canvasY) {
    const clickedTileX = Math.floor((canvasX / TILE_SIZE) + offsetX - 10.7);
    const clickedTileY = Math.floor((canvasY / TILE_SIZE) + offsetY - 0.1);

    console.log(`Cella premuta: X=${clickedTileX}, Y=${clickedTileY}`);
    console.log(`Il suo tipo è: ${mapTiles[clickedTileX][clickedTileY]}`);

    const selectedBuilding = selectedTileType;

    if (selectedBuilding === 'FACTORY') {
        if (clickedTileX > 9990 || clickedTileY > 9996) {
            return;
        }
    }

    if (selectedBuilding === 'HOUSE') {
        if (clickedTileX > 9995 || clickedTileY > 9997) {
            return;
        }
    }

    console.log("selectedBuilding:", selectedBuilding, typeof selectedBuilding);
    console.log("buildingSizes[selectedBuilding]:", buildingSizes[selectedBuilding]);

    if (selectedBuilding && buildingSizes[selectedBuilding]) {
        const {
            width,
            height
        } = buildingSizes[selectedBuilding];

        let canBuild = true; // Variabile per controllare se è possibile costruire

        if (selectedBuilding !== 'CANCEL') {
            // Controlla se tutte le celle nell'area dell'edificio sono libere
            for (let i = 0; i < width; i++) {
                for (let j = 0; j < height; j++) {
                    const tileX = clickedTileX + i;
                    const tileY = clickedTileY + j;

                    if (tileX < MAP_SIZE && tileY < MAP_SIZE) {
                        if (mapTiles[tileX][tileY] !== 'CANCEL' && mapTiles[tileX][tileY] !== 'GRASS' && mapTiles[tileX][tileY] !== 'default') {
                            // Se una cella è già occupata da un altro tipo di mattonella, blocca la costruzione
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
                        mapTiles[clickedTileX + i][clickedTileY + j] = selectedBuilding;
                    }
                }
            }
        }
    } else if (selectedTileType) {
        if (selectedBuilding !== 'CANCEL') {
            if (mapTiles[clickedTileX][clickedTileY] !== 'CANCEL' && mapTiles[clickedTileX][clickedTileY] !== 'GRASS' && mapTiles[clickedTileX][clickedTileY] !== 'default') {
                return; // Se la casella è colorata, esce dalla funzione senza costruire nulla
            }
        }
        
        if (clickedTileX < MAP_SIZE && clickedTileY < MAP_SIZE) {
            mapTiles[clickedTileX][clickedTileY] = selectedTileType;
        }
    } else {
        if (clickedTileX < MAP_SIZE && clickedTileY < MAP_SIZE) {
            mapTiles[clickedTileX][clickedTileY] = 'CANCEL';
        }
    }

    // Ricalcola e ridisegna la mappa
    drawMap(offsetX, offsetY);
}

// Inizia il disegno al mousedown
canvas.addEventListener('mousedown', function(e) {
    isDrawing = true;
    drawTileAtPosition(e.clientX, e.clientY); // Disegna la prima mattonella
});

// Ferma il disegno quando il mouse viene rilasciato
window.addEventListener('mouseup', function() {
    isDrawing = false;
});

// Disegna durante il trascinamento del mouse (se il mouse è premuto)
canvas.addEventListener('mousemove', function(e) {
    if (isDrawing) {
        drawTileAtPosition(e.clientX, e.clientY);
    }
});