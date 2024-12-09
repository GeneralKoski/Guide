const player = document.querySelector('.player');
const gameArea = document.querySelector('.game-area');
const alienRow = document.querySelector('.alien-row');

let playerPos = 180;
let aliens = [];
let bullets = [];
let moveLeft = true;
const alienSpeed = 1.5;
const bulletSpeed = 5;

// Create aliens
for (let i = 0; i < 8; i++) {
  let alien = document.createElement('div');
  alien.classList.add('alien');
  alienRow.appendChild(alien);
  aliens.push(alien);
}

// Move player
document.addEventListener('keydown', (e) => {
  if (e.key === 'ArrowLeft' && playerPos > 0) {
    playerPos -= 10;
  } else if (e.key === 'ArrowRight' && playerPos < 360) {
    playerPos += 10;
  } else if (e.key === ' ') {
    shootBullet();
  }
  player.style.left = `${playerPos}px`;
});

// Shoot bullet
function shootBullet() {
  let bullet = document.createElement('div');
  bullet.classList.add('bullet');
  bullet.style.left = `${playerPos + 18}px`;
  bullet.style.bottom = '40px';
  gameArea.appendChild(bullet);
  bullets.push(bullet);
}

// Move aliens and bullets
function gameLoop() {
  // Move aliens
  let alienRowPos = alienRow.offsetLeft;
  if (alienRowPos >= 300 || alienRowPos <= 0) moveLeft = !moveLeft;
  alienRow.style.left = moveLeft ? `${alienRowPos - alienSpeed}px` : `${alienRowPos + alienSpeed}px`;

  // Move bullets
  bullets.forEach((bullet, index) => {
    let bulletPos = bullet.offsetTop;
    if (bulletPos <= 0) {
      bullet.remove();
      bullets.splice(index, 1);
    } else {
      bullet.style.top = `${bulletPos - bulletSpeed}px`;
      // Check for collision
      aliens.forEach((alien, aIndex) => {
        if (checkCollision(bullet, alien)) {
          alien.remove();
          bullet.remove();
          aliens.splice(aIndex, 1);
          bullets.splice(index, 1);
        }
      });
    }
  });

  requestAnimationFrame(gameLoop);
}

// Collision detection
function checkCollision(bullet, alien) {
  let bulletRect = bullet.getBoundingClientRect();
  let alienRect = alien.getBoundingClientRect();
  return !(
    bulletRect.top > alienRect.bottom ||
    bulletRect.bottom < alienRect.top ||
    bulletRect.left > alienRect.right ||
    bulletRect.right < alienRect.left
  );
}

gameLoop();
