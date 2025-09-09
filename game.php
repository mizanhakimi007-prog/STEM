<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CAPTURE THE FLAG</title>
  <style>
/* =========================
   Enhanced Game-like UI Styling
   ========================= */
:root {
  --bg: #0a1232;
  --panel: linear-gradient(180deg, #1e2a5a, #0f1730);
  --muted: #a8b4ff;
  --p1: #186014ff;
  --p2: #050505ff;
  --flag: #ff6aa6;
  --accent: #7dffcc;
  --danger: #ff6b6b;
  --glow: #ffd700;
  --border: #2b3a7a;
}
* {
  box-sizing: border-box;
  font-family: 'Press Start 2P', monospace;
}
@font-face {
  font-family: 'Press Start 2P';
  src: url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap') format('woff2');
}
html, body {
  height: 100%;
  margin: 0;
  background: var(--bg);
  color: #dfe7ff;
  overflow: hidden;
}
.container {
  display: grid;
  grid-template-rows: auto 1fr auto;
  min-height: 100vh;
  gap: 12px;
  padding: 12px;
  max-width: 1200px;
  margin: 0 auto;
}
.header, .footer {
  background: var(--panel);
  padding: 12px 16px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.logo {
  width: 48px;
  height: 48px;
  border-radius: 8px;
  background: linear-gradient(135deg, var(--accent), var(--flag));
  box-shadow: 0 0 10px var(--glow);
  animation: pulse 2s infinite;
}
.title {
  font-size: 20px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}
.subtitle {
  font-size: 10px;
  color: var(--muted);
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}
.hud {
  display: flex;
  gap: 10px;
  align-items: center;
  flex-wrap: wrap;
}
.pill {
  background: linear-gradient(45deg, #1a234a, #2b3a7a);
  padding: 8px 14px;
  border-radius: 10px;
  border: 2px solid var(--border);
  color: var(--muted);
  font-size: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
  transition: transform 0.2s;
}
.pill:hover {
  transform: scale(1.05);
}
.pill strong {
  color: #fff;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}
canvas {
  display: block;
  width: 100%;
  max-width: 960px;
  height: 70vh;
  border-radius: 12px;
  border: 4px solid var(--border);
  box-shadow: 0 0 20px var(--glow), inset 0 0 10px rgba(0, 0, 0, 0.5);
  background: radial-gradient(1100px 500px at 50% -200px, #102042 0%, var(--bg) 60%);
  margin: 0 auto;
}
.footer {
  font-size: 10px;
  text-align: center;
  color: var(--muted);
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}
.centerOverlay {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
  z-index: 10;
}
.overlay-content {
  background: rgba(10, 18, 50, 0.9);
  padding: 24px;
  border-radius: 16px;
  border: 3px solid var(--border);
  box-shadow: 0 0 30px var(--glow);
  text-align: center;
  pointer-events: auto;
  animation: fadeIn 0.5s;
}
.overlay-content h2 {
  font-size: 24px;
  color: #fff;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  margin: 0 0 16px;
}
button.btn {
  background: linear-gradient(45deg, #2b3a7a, #3a62b8);
  color: #fff;
  border-radius: 10px;
  padding: 10px 20px;
  border: 2px solid var(--border);
  cursor: pointer;
  font-size: 12px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
  transition: transform 0.2s, box-shadow 0.2s;
}
button.btn:hover {
  transform: scale(1.1);
  box-shadow: 0 0 15px var(--glow);
}
button.btn:active {
  transform: scale(1.05);
}
@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}
@keyframes fadeIn {
  from { opacity: 0; transform: translate(-50%, -60%); }
  to { opacity: 1; transform: translate(-50%, -50%); }
}
@media (max-width: 600px) {
  .title { font-size: 16px; }
  .subtitle { font-size: 8px; }
  .pill { font-size: 10px; padding: 6px 10px; }
  .footer { font-size: 8px; }
  canvas { height: 60vh; }
}
  </style>
</head>
<body>
  <div class="container">
    <header class="header">
      <div style="display:flex;gap:12px;align-items:center">
        <div class="logo"></div>
        <div>
          <div class="title">CAPTURE THE FLAG by mijan 5ST2:3
          </div>
          <div class="subtitle">2 Players • Flag Capture • Power-Ups • Creeper Sprites</div>
        </div>
      </div>

      <div class="hud">
        <div class="pill">P1: <strong id="p1score">0</strong></div>
        <div class="pill">P2: <strong id="p2score">0</strong></div>
        <div class="pill">Time: <strong id="timer">50.0</strong>s</div>
        <div class="pill">Flag: <span id="flagOwner">none</span></div>
        <div class="pill">PU: P1 <span id="pu1">–</span> / P2 <span id="pu2">–</span></div>
        <button id="pauseBtn" class="btn">Pause</button>
        <button id="resetBtn" class="btn">Reset</button>
      </div>
    </header>

    <main style="position:relative">
      <canvas id="game" width="960" height="540" tabindex="0"></canvas>

      <!-- end round overlay -->
      <div id="endOverlay" class="centerOverlay" style="display:none">
        <div class="overlay-content">
          <h2 id="endText"></h2>
          <button id="endReset" class="btn">Restart</button>
        </div>
      </div>
    </main>

    <footer class="footer">
      <div>Controls: P1 [A/D move, W jump] • P2 [←/→ move, ↑ jump] • Space to pause • F toggles waving flag</div>
      <div>Game: 50s rounds • Random star power-ups (~15s) • Flag hold meter • Slowdown zone</div>
    </footer>
  </div>

<script>
/* =========================
   Game Script with Background Sound
   ========================= */

const canvas = document.getElementById('game');
const c = canvas.getContext('2d');
c.imageSmoothingEnabled = false;
canvas.focus();

const HUD = {
  p1score: document.getElementById('p1score'),
  p2score: document.getElementById('p2score'),
  timer: document.getElementById('timer'),
  flagOwner: document.getElementById('flagOwner'),
  pu1: document.getElementById('pu1'),
  pu2: document.getElementById('pu2'),
  pauseBtn: document.getElementById('pauseBtn'),
  resetBtn: document.getElementById('resetBtn'),
  endOverlay: document.getElementById('endOverlay'),
  endText: document.getElementById('endText'),
  endReset: document.getElementById('endReset')
};

const W = canvas.width, H = canvas.height;

/* ===== game constants ===== */
const G = 0.6;
const FRICTION = 0.82;
const AIR_DRAG = 0.985;
const ROUND_TIME = 50.0;
const POWERUP_INTERVAL = 15000;
const FLAG_HOLD_REQUIRED = 5.0;
const FLAG_SLOW_ZONE = {x:540, y:H-44, w:180, h:14};
const COLORS = {
  p1: '#0015ffff', p2: '#fc0000ff', flag:'#fafafaff',
  base1:'#0033fdff', base2:'#b93838ff', plat:'#7da4ff', slow:'#7451ff88',
  bgLine:'#0c112a', text:'#e8f0ff'
};

/* ===== helpers ===== */
function rect(x,y,w,h){ return {x,y,w,h}; }
function aabb(a,b){ return a.x < b.x+b.w && a.x+a.w > b.x && a.y < b.y+b.h && a.y+a.h > b.y; }
function clamp(v,a,b){ return Math.max(a, Math.min(b, v)); }
function rand(a,b){ return a + Math.random()*(b-a); }
function choice(arr){ return arr[(Math.random()*arr.length)|0]; }

/* ===== world geometry ===== */
const groundY = H - 30;
const platforms = [
  rect(0, groundY, W, 30),
  rect(150, groundY-120, 140, 16),
  rect(420, groundY-180, 120, 16),
  rect(680, groundY-120, 140, 16)
];
const movingPlatform = rect(300, groundY-80, 120, 14);
let moveDir = 1;
const slowZone = rect(FLAG_SLOW_ZONE.x, FLAG_SLOW_ZONE.y, FLAG_SLOW_ZONE.w, FLAG_SLOW_ZONE.h);
const base1 = rect(8, H-60, 90, 18);
const base2 = rect(W-98, H-60, 90, 18);

/* ===== flag object ===== */
const flag = {
  x: W/2 - 6, y: groundY - 16, w: 14, h: 18,
  vx: 0, vy: 0,
  carrier: 0,
  holdTimer: 0.0,
  stealCooldown: 0,
  reset(){
    this.x = W/2 - 6; this.y = groundY - 16; this.vx = 0; this.vy = 0;
    this.carrier = 0; this.holdTimer = 0; this.stealCooldown = 0;
  }
};

/* ===== powerups ===== */
const PU_TYPES = [
  {id:'Chaos', desc:'glow + teleport', dur:3000},
];
let powerups = [];
let lastPowerDrop = 0;

/* ===== players ===== */
function makePlayer(id){
  return {
    id,
    x: id===1 ? 40 : W-72,
    y: groundY-40,
    w: 24, h: 32,
    vx: 0, vy: 0,
    onGround: false,
    facing: 1,
    score: 0,
    effects: {},
    frozenUntil: 0,
    prevOnGround: false,
    lastDust: 0,
    lastTeleport: 0,
    updateHUD(){ }
  };
}
const p1 = makePlayer(1), p2 = makePlayer(2);

/* ===== clouds for background ===== */
let clouds = [];
function initClouds(){
  clouds = [];
  for(let i = 0; i < 6; i++){
    clouds.push({
      x: rand(0, W),
      y: rand(20, H/3),
      w: rand(60, 120),
      h: rand(20, 40),
      vx: rand(0.5, 1.5)
    });
  }
}
function updateClouds(dt){
  for(const cloud of clouds){
    cloud.x += cloud.vx * (dt / 16);
    if(cloud.x > W) cloud.x -= W + cloud.w;
  }
}
function drawClouds(){
  for(const cloud of clouds){
    c.fillStyle = 'rgba(255, 255, 255, 0.7)';
    c.beginPath();
    c.roundRect(cloud.x, cloud.y, cloud.w, cloud.h, 8);
    c.fill();
  }
}

/* ===== sound (with background music) ===== */
const Sound = (() => {
  let ctx;
  let bgGainNode, bgOscillators = [];
  const melody = [
    {freq: 261.63, dur: 0.4}, // C4
    {freq: 329.63, dur: 0.4}, // E4
    {freq: 392.00, dur: 0.4}, // G4
    {freq: 349.23, dur: 0.4}, // F4
    {freq: 261.63, dur: 0.4}, // C4
    {freq: 329.63, dur: 0.4}, // E4
    {freq: 392.00, dur: 0.4}, // G4
    {freq: 440.00, dur: 0.4}  // A4
  ];
  let melodyIndex = 0;
  let nextNoteTime = 0;

  function initAudioContext() {
    if (!window.AudioContext && !window.webkitAudioContext) return;
    if (!ctx) ctx = new (window.AudioContext || window.webkitAudioContext)();
    return ctx;
  }

  function beep(freq = 440, dur = 100, type = 'square', vol = 0.02) {
    const ctx = initAudioContext();
    if (!ctx) return;
    const o = ctx.createOscillator();
    const g = ctx.createGain();
    o.type = type;
    o.frequency.value = freq;
    g.gain.value = vol;
    o.connect(g);
    g.connect(ctx.destination);
    o.start();
    g.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + dur / 1000);
    o.stop(ctx.currentTime + dur / 1000 + 0.02);
  }

  function startBackgroundMusic() {
    const ctx = initAudioContext();
    if (!ctx) return;
    if (bgGainNode) return; // Already playing
    bgGainNode = ctx.createGain();
    bgGainNode.gain.value = 0.015; // Low volume for background
    bgGainNode.connect(ctx.destination);
    scheduleNextNote(ctx.currentTime);
  }

  function scheduleNextNote(currentTime) {
    if (!bgGainNode) return;
    while (nextNoteTime < currentTime + 0.1) {
      const note = melody[melodyIndex];
      const osc = ctx.createOscillator();
      osc.type = 'square';
      osc.frequency.value = note.freq;
      osc.connect(bgGainNode);
      osc.start(nextNoteTime);
      osc.stop(nextNoteTime + note.dur * 0.8);
      bgOscillators.push(osc);
      melodyIndex = (melodyIndex + 1) % melody.length;
      nextNoteTime += note.dur;
    }
  }

  function stopBackgroundMusic() {
    if (bgGainNode) {
      bgGainNode.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.1);
      setTimeout(() => {
        bgOscillators.forEach(osc => osc.stop());
        bgOscillators = [];
        bgGainNode.disconnect();
        bgGainNode = null;
      }, 150);
    }
  }

  return { beep, startBackgroundMusic, stopBackgroundMusic, scheduleNextNote };
})();

/* ===== input handling ===== */
const keys = {};
addEventListener('keydown', e => {
  keys[e.code] = true;
  if (e.code === 'Space') { togglePause(); e.preventDefault(); }
  if (e.code === 'KeyF') {
    USE_WAVING_FLAG = !USE_WAVING_FLAG;
  }
});
addEventListener('keyup', e => { keys[e.code] = false; });

HUD.pauseBtn.onclick = () => togglePause();
HUD.resetBtn.onclick = () => resetGame();
HUD.endReset.onclick = () => { resetGame(); HUD.endOverlay.style.display = 'none'; };

/* ===== state ===== */
let running = true;
let lastTime = performance.now();
let elapsedMs = 0;
let roundTime = ROUND_TIME;
let frameCount = 0;

/* ===== pause toggle ===== */
function togglePause() {
  running = !running;
  HUD.pauseBtn.textContent = running ? 'Pause' : 'Resume';
  HUD.endOverlay.style.display = running ? 'none' : 'block';
  HUD.endText.textContent = 'Paused';
  HUD.endReset.textContent = 'Resume';
  HUD.endReset.style.display = running ? 'none' : 'inline-block';
  if (running) {
    Sound.startBackgroundMusic();
  } else {
    Sound.stopBackgroundMusic();
  }
  Sound.beep(660, 100, 'sine', 0.05);
}

/* ===== animation + particles ===== */
let USE_WAVING_FLAG = false;
let particles = [];
function spawnDust(x, y, count = 6, baseVX = 0) {
  const now = Date.now();
  for (let i = 0; i < count; i++) {
    particles.push({
      x: x + rand(-6, 6),
      y: y + rand(-2, 6),
      vx: baseVX + rand(-1.2, 1.2),
      vy: rand(-2.4, -0.6),
      life: rand(0.45, 0.95),
      size: rand(2, 6),
      born: now
    });
  }
}
function updateParticles(dt) {
  for (const p of particles) {
    p.vy += G * 0.12;
    p.x += p.vx;
    p.y += p.vy;
    p.life -= dt / 1000;
  }
  particles = particles.filter(p => p.life > 0);
}
function drawParticles() {
  for (const p of particles) {
    const alpha = clamp(p.life, 0, 1);
    c.fillStyle = `rgba(120,110,100,${alpha})`;
    c.fillRect(Math.round(p.x), Math.round(p.y), Math.round(p.size), Math.round(p.size));
  }
}
function handleDustForPlayer(p) {
  const now = Date.now();
  const moving = Math.abs(p.vx) > 0.35 && p.onGround;
  if (moving && now - p.lastDust > 120) {
    spawnDust(p.x + p.w / 2, p.y + p.h - 4, 4, -p.vx * 0.2);
    p.lastDust = now;
  }
  if (p.onGround && !p.prevOnGround) {
    spawnDust(p.x + p.w / 2, p.y + p.h - 2, 8, -p.vx * 0.2);
  }
  p.prevOnGround = p.onGround;
}

/* ===== display helpers ===== */
function activeText(eff) {
  const now = Date.now();
  return Object.entries(eff).filter(([k, t]) => now < t).map(([k, t]) => k + ' ' + ((t - now) / 1000).toFixed(1) + 's').join(', ');
}

/* ===== reset / toggle ===== */
function resetGame() {
  p1.x = 40; p1.y = groundY - 40; p1.vx = p1.vy = 0; p1.score = 0; p1.effects = {}; p1.prevOnGround = false; p1.lastDust = 0; p1.lastTeleport = 0;
  p2.x = W - 72; p2.y = groundY - 40; p2.vx = p2.vy = 0; p2.score = 0; p2.effects = {}; p2.prevOnGround = false; p2.lastDust = 0; p2.lastTeleport = 0;
  flag.reset();
  powerups = []; lastPowerDrop = 0;
  running = true; roundTime = ROUND_TIME; elapsedMs = 0;
  HUD.p1score.textContent = '0'; HUD.p2score.textContent = '0';
  HUD.flagOwner.textContent = 'none';
  HUD.pu1.textContent = '–'; HUD.pu2.textContent = '–';
  HUD.pauseBtn.textContent = 'Pause';
  HUD.endOverlay.style.display = 'none';
  Sound.stopBackgroundMusic();
  Sound.startBackgroundMusic();
  Sound.beep(880, 120, 'sine', 0.05);
  initClouds();
}

/* ===== physics & collisions ===== */
function moveEntity(e) {
  e.vy += G;
  e.x += e.vx;
  e.y += e.vy;
  const plats = platforms.concat([movingPlatform]);
  e.onGround = false;
  for (const p of plats) {
    if (aabb(e, p)) {
      if (e.y + e.h - e.vy <= p.y + 1) {
        e.y = p.y - e.h; e.vy = 0; e.onGround = true;
        if (p === movingPlatform) e.x += moveDir * 1.2;
      } else if (e.y - e.vy >= p.y + p.h - 1) {
        e.y = p.y + p.h; e.vy = 0.2;
      } else if (e.x + e.w - e.vx <= p.x + 1) {
        e.x = p.x - e.w; e.vx = 0;
      } else {
        e.x = p.x + p.w; e.vx = 0;
      }
    }
  }
  e.x = clamp(e.x, 0, W - e.w);
  if (e.y > H - 1) { e.y = H - 1; e.vy = 0; }
  if (e.onGround) e.vx *= FRICTION; else e.vx *= AIR_DRAG;
}

/* ===== powerups ===== */
function spawnPowerUp() { const t = PU_TYPES[0]; const x = rand(60, W - 60); powerups.push({type: t, x, y: -30, w: 18, h: 18, vy: 0}); }
function applyPowerUp(player, other, pu) {
  const now = Date.now(); const add = (name, ms, obj = player) => { obj.effects[name] = now + ms; };
  add('Chaos', pu.type.dur);
  Sound.beep(740, 120, 'square', 0.04); player.updateHUD(); other.updateHUD();
}

/* ===== scoring by meter ===== */
function tryScoreByMeter(player) {
  if (flag.carrier !== player.id) return;
  if (flag.holdTimer >= FLAG_HOLD_REQUIRED) {
    player.score++;
    HUD['p' + player.id + 'score'].textContent = player.score;
    flag.reset();
    HUD.flagOwner.textContent = 'none';
    Sound.beep(880, 140); Sound.beep(1320, 120);
  }
}

/* ===== input -> movement ===== */
function handleInput(p, map) {
  if (!running) return;
  if (Date.now() < (p.effects['Freeze'] || 0)) return;
  const left = !!keys[map.left], right = !!keys[map.right], jump = !!keys[map.jump];
  let l = left, r = right;
  if (Date.now() < (p.effects['Reverse'] || 0)) { l = right; r = left; }
  const spdBase = 1.3;
  const speed = spdBase * (Date.now() < (p.effects['Speed'] || 0) ? 1.45 : 1) * (p.id && flag.carrier === p.id && aabb(p, slowZone) ? 0.7 : 1);
  if (l) { p.vx -= speed; p.facing = -1; }
  if (r) { p.vx += speed; p.facing = 1; }
  if (jump && p.onGround) {
    p.vy = -(12 * (Date.now() < (p.effects['Jump'] || 0) ? 1.25 : 1));
    Sound.beep(360, 80, 'square', 0.03);
  }
}

/* ===== main update loop ===== */
function update(dt) {
  elapsedMs += dt;
  frameCount++;
  if (running) {
    roundTime = Math.max(0, roundTime - dt / 1000);
    HUD.timer.textContent = roundTime.toFixed(1);
    if (elapsedMs - lastPowerDrop > POWERUP_INTERVAL) { lastPowerDrop = elapsedMs; spawnPowerUp(); }
    Sound.scheduleNextNote(performance.now() / 1000); // Update background music
  }
  if (roundTime <= 0 && running) {
    running = false; HUD.pauseBtn.textContent = 'Restart';
    const t = p1.score === p2.score ? 'Draw!' : (p1.score > p2.score ? 'Player 1 Wins!' : 'Player 2 Wins!');
    HUD.endText.textContent = t; HUD.endOverlay.style.display = 'block';
    HUD.endReset.textContent = 'Restart';
    HUD.endReset.style.display = 'inline-block';
    Sound.stopBackgroundMusic();
    return;
  }

  movingPlatform.x += moveDir * 1.2;
  if (movingPlatform.x < 160 || movingPlatform.x > W - 280) moveDir *= -1;

  handleInput(p1, {left: 'KeyA', right: 'KeyD', jump: 'KeyW'});
  handleInput(p2, {left: 'ArrowLeft', right: 'ArrowRight', jump: 'ArrowUp'});

  moveEntity(p1); moveEntity(p2);

  handleDustForPlayer(p1);
  handleDustForPlayer(p2);

  updateParticles(dt);
  updateClouds(dt);

  for (const pu of powerups) {
    pu.vy += G * 0.6; pu.y += pu.vy;
    const allPlats = platforms.concat([movingPlatform]);
    for (const p of allPlats) {
      if (aabb(pu, p) && pu.y - pu.vy < p.y) { pu.y = p.y - pu.h; pu.vy = 0; }
    }
    if (aabb(pu, p1)) { applyPowerUp(p1, p2, pu); pu.dead = true; }
    else if (aabb(pu, p2)) { applyPowerUp(p2, p1, pu); pu.dead = true; }
  }
  powerups = powerups.filter(p => !p.dead && p.y < H + 40);

  if (flag.carrier === 0) {
    flag.vy += G * 0.6; flag.x += flag.vx; flag.y += flag.vy;
    const plats = platforms.concat([movingPlatform]);
    for (const p of plats) {
      const r = {x: flag.x, y: flag.y, w: flag.w, h: flag.h};
      if (aabb(r, p)) {
        if (flag.y - flag.vy <= p.y) { flag.y = p.y - flag.h; flag.vy = 0; }
      }
    }
    const fr = {x: flag.x, y: flag.y, w: flag.w, h: flag.h};
    if (aabb(fr, p1)) { flag.carrier = 1; HUD.flagOwner.textContent = 'P1'; flag.holdTimer = 0; Sound.beep(520, 120); }
    else if (aabb(fr, p2)) { flag.carrier = 2; HUD.flagOwner.textContent = 'P2'; flag.holdTimer = 0; Sound.beep(520, 120); }
  } else {
    const carrier = flag.carrier === 1 ? p1 : p2;
    const other = carrier === p1 ? p2 : p1;
    flag.x = carrier.x + carrier.w / 2 - flag.w / 2;
    flag.y = carrier.y - flag.h + 3;
    if (running) flag.holdTimer += dt / 1000;
    tryScoreByMeter(carrier);
    if (Date.now() > (flag.stealCooldown || 0) && aabb(other, carrier)) {
      flag.carrier = other.id;
      HUD.flagOwner.textContent = 'P' + other.id;
      flag.holdTimer = 0;
      flag.stealCooldown = Date.now() + 600;
      Sound.beep(740, 120, 'square', 0.05);
    }
  }

  const now = Date.now();
  [p1, p2].forEach(p => {
    if (running && now < (p.effects.Chaos || 0) && now > (p.lastTeleport || 0)) {
      p.x = rand(50, W - 50 - p.w);
      p.y = groundY - p.h;
      p.vx = 0;
      p.vy = 0;
      p.lastTeleport = now + rand(400, 600);
      Sound.beep(1000, 80, 'sine', 0.05);
    }
  });

  p1.updateHUD = () => { HUD.pu1.textContent = activeText(p1.effects) || '–'; };
  p2.updateHUD = () => { HUD.pu2.textContent = activeText(p2.effects) || '–'; };
  p1.updateHUD(); p2.updateHUD();
}

/* ===== rendering ===== */
const creeperGrid = [
    "........................",
  "....################....",
  "....################...",
  "....################....",
  "....################....",
  "....###XX####XX#####....",
  "....################....",
  "....######XXXX######....",
  "....######XXXX######....",
  "....#####XX##XX#####....",
  "....################......",
  "........................",
  "....#################....",
  "...++################.",
  "...++################.",
  "...++################.",
  "...++################.",
  "...++################.",
  "...++################.",
  "...++################.",
  "....++##############+..",
  "........................",
  "...###++##....##++###...",
  "...###++##....##++###...",
  "...###++##....##++###...",
  "...###++##....##++###...",
  "...###++##....##++###...",
  "...###++##....##++###...",
  "........................"
];

const spriteColors = { "#": '#3aa635', "G": '#f6f6f6ff', ".": null };

function drawCreeperSprite(player, frameN) {
  const scale = 1.9;
  const grid = creeperGrid;
  const spriteWidth = grid[0].length * scale;
  const spriteHeight = grid.length * scale;
  const x0 = player.x - 2; // Adjusted for new hitbox center
  const y0 = player.y - 4; // Adjusted for new hitbox top
  const moving = Math.abs(player.vx) > 0.5 && player.onGround;
  const speedFactor = clamp(Math.abs(player.vx) / 3, 0, 1);
  const legPhase = (frameN / 6) % (Math.PI * 2);
  const legOffset = moving ? Math.sin(legPhase) * 2.6 * speedFactor : 0;
  const bodySway = moving ? Math.sin(frameN / 12) * 0.8 * speedFactor * player.facing : 0;
  const now = Date.now();
  const isChaos = now < (player.effects.Chaos || 0);

  c.save();
  if (player.facing === -1) {
    c.translate(x0 + spriteWidth / 2, 0);
    c.scale(-1, 1);
    c.translate(-(x0 + spriteWidth / 2), 0);
  }
  if (isChaos) {
    c.shadowColor = 'gold';
    c.shadowBlur = 15;
  }
  for (let r = 0; r < grid.length; r++) {
    const row = grid[r];
    for (let c = 0; c < row.length; c++) {
      const ch = row[c];
      if (ch === '.') continue;
      let col = spriteColors[ch] || spriteColors['#'];
      if (isChaos) col = shadeColor(col, -20);
      if ((r + c) % 5 === 0) col = shadeColor(col, -8);
      let yOff = 0;
      let xOff = bodySway;
      if (r > grid.length - 6) {
        if (c < 6) yOff = legOffset * (player.facing === -1 ? 1 : -1);
        if (c > row.length - 7) yOff = -legOffset * (player.facing === -1 ? 1 : -1);
      }
      cfillRect(Math.round(x0 + c * scale + xOff), Math.round(y0 + r * scale + yOff), scale, scale, col);
    }
  }
  const eyeW = 3 * scale, eyeH = 3 * scale;
  const leftEyeX = x0 + 5 * scale + (bodySway * 0.6), leftEyeY = y0 + 3 * scale;
  const rightEyeX = x0 + 12 * scale + (bodySway * 0.6), rightEyeY = leftEyeY;
  cfillRect(leftEyeX, leftEyeY, eyeW, eyeH, '#ffffffff');
  cfillRect(rightEyeX, rightEyeY, eyeW, eyeH, '#ffffffff');
  cfillRect(x0 + 7 * scale + (bodySway * 0.6), y0 + 8 * scale, 8 * scale, 6 * scale, '#081016');
  c.restore();

  c.font = '10px "Press Start 2P"';
  c.fillStyle = player.id === 1 ? COLORS.p1 : COLORS.p2;
  c.fillText('P' + player.id, Math.round(player.x + player.w / 2 - 10), Math.round(player.y - 16));
  if (flag.carrier === player.id) {
    c.font = '10px "Press Start 2P"';
    c.fillStyle = '#fff';
    c.fillText('FLAG', Math.round(player.x), Math.round(player.y - 8));
  }
}

function cfillRect(x, y, w, h, color) { if (!color) return; c.fillStyle = color; c.fillRect(Math.round(x), Math.round(y), Math.round(w), Math.round(h)); }
function shadeColor(hex, percent) {
  let num = parseInt(hex.slice(1), 16);
  let r = (num >> 16) + percent;
  let g = ((num >> 8) & 0x00FF) + percent;
  let b = (num & 0x0000FF) + percent;
  r = clamp(Math.round(r), 0, 255);
  g = clamp(Math.round(g), 0, 255);
  b = clamp(Math.round(b), 0, 255);
  return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
}

function drawStar(cx, cy, spikes, outerRadius, innerRadius, color) {
  c.fillStyle = color;
  c.beginPath();
  let rot = Math.PI / 2 * 3;
  let x = cx;
  let y = cy;
  let step = Math.PI / spikes;
  c.moveTo(cx, cy - outerRadius);
  for (let i = 0; i < spikes; i++) {
    x = cx + Math.cos(rot) * outerRadius;
    y = cy + Math.sin(rot) * outerRadius;
    c.lineTo(x, y);
    rot += step;
    x = cx + Math.cos(rot) * innerRadius;
    y = cy + Math.sin(rot) * innerRadius;
    c.lineTo(x, y);
    rot += step;
  }
  c.lineTo(cx, cy - outerRadius);
  c.closePath();
  c.fill();
  c.strokeStyle = '#333';
  c.stroke();
}

function drawFlag() {
  const poleX = flag.x;
  const poleTop = flag.y - flag.h - 8;
  c.fillStyle = '#666'; c.fillRect(poleX, poleTop, 4, flag.h + 24);
  const amp = (flag.carrier ? Math.sin(frameCount / 8) * 3 : 0);
  const baseY = poleTop + 6;
  c.beginPath();
  c.moveTo(poleX + 4, baseY);
  c.quadraticCurveTo(poleX + 34 + amp, baseY + 8 + amp, poleX + 4, baseY + flag.h - 6);
  c.lineTo(poleX + 4, baseY); c.closePath(); c.fillStyle = COLORS.flag; c.fill();
  c.strokeStyle = '#0e0e0e'; c.stroke();

  if (flag.carrier !== 0) {
    const meterW = 60, meterH = 8; const mx = poleX - meterW / 2 + 6; const my = poleTop - 14;
    c.fillStyle = '#222'; c.fillRect(mx - 1, my - 1, meterW + 2, meterH + 2); c.strokeStyle = '#000'; c.strokeRect(mx - 1, my - 1, meterW + 2, meterH + 2);
    const pct = clamp(flag.holdTimer / FLAG_HOLD_REQUIRED, 0, 1);
    c.fillStyle = '#7df'; c.fillRect(mx, my, meterW * pct, meterH);
    c.fillStyle = '#fff'; c.font = '8px "Press Start 2P"'; c.fillText((pct * 100).toFixed(0) + '%', mx + meterW / 2 - 10, my + meterH + 10);
  }
}

function drawWavingFlag(flagObj) {
  const poleX = flagObj.x;
  const poleTop = flagObj.y - flagObj.h - 8;
  c.fillStyle = '#666'; c.fillRect(poleX, poleTop, 4, flagObj.h + 24);
  const clothW = 36;
  const clothH = flagObj.h;
  const segments = 8;
  const segH = clothH / segments;
  const t = frameCount / 10;
  c.beginPath();
  let startX = poleX + 4;
  c.moveTo(startX, poleTop + 6);
  for (let i = 0; i <= segments; i++) {
    const y = poleTop + 6 + i * segH;
    const phase = (i / segments) * Math.PI * 2 + t;
    const xOffset = Math.sin(phase) * (flagObj.carrier ? 4 : 1.2);
    c.lineTo(startX + clothW + xOffset, y + Math.cos(phase) * 0.8);
  }
  c.lineTo(startX, poleTop + 6 + clothH);
  c.closePath();
  c.fillStyle = COLORS.flag; c.fill();
  c.strokeStyle = '#0e0e0e'; c.stroke();
  c.fillStyle = 'rgba(0,0,0,0.08)';
  for (let i = 0; i < segments; i++) {
    const y = poleTop + 6 + i * segH + segH * 0.2;
    const phase = (i / segments) * Math.PI * 2 + t;
    const xOffset = Math.sin(phase) * (flagObj.carrier ? 4 : 1.2);
    c.fillRect(poleX + 8 + xOffset, y, clothW - 10, segH * 0.4);
  }
  if (flagObj.carrier !== 0) {
    const meterW = 60, meterH = 8; const mx = poleX - meterW / 2 - 6; const my = poleTop - 14;
    c.fillStyle = '#222'; c.fillRect(mx - 1, my - 1, meterW + 2, meterH + 2); c.strokeStyle = '#000'; c.strokeRect(mx - 1, my - 1, meterW + 2, meterH + 2);
    const pct = clamp(flag.holdTimer / FLAG_HOLD_REQUIRED, 0, 1);
    c.fillStyle = '#7df'; c.fillRect(mx, my, meterW * pct, meterH);
    c.fillStyle = '#fff'; c.font = '8px "Press Start 2P"'; c.fillText((pct * 100).toFixed(0) + '%', mx + meterW / 2 - 10, my + meterH + 10);
  }
}

function drawPlayers() {
  drawPlayerShadow(p1);
  drawCreeperSprite(p1, frameCount);
  drawPlayerShadow(p2);
  drawCreeperSprite(p2, frameCount);
}
function drawPlayerShadow(p) { c.fillStyle = '#0008'; c.beginPath(); c.ellipse(p.x + p.w / 2, p.y + p.h + 6, p.w / 1.2, 6, 0, 0, Math.PI * 2); c.fill(); }

function drawRect(r, color, stroke) { c.fillStyle = color; c.fillRect(Math.round(r.x), Math.round(r.y), Math.round(r.w), Math.round(r.h)); if (stroke) { c.strokeStyle = stroke; c.strokeRect(Math.round(r.x), Math.round(r.y), Math.round(r.w), Math.round(r.h)); } }

function draw() {
  c.clearRect(0, 0, W, H);

  const skyGradient = c.createLinearGradient(0, 0, 0, H);
  skyGradient.addColorStop(0, '#87CEEB');
  skyGradient.addColorStop(1, '#4682B4');
  c.fillStyle = skyGradient;
  c.fillRect(0, 0, W, H);

  drawClouds();
  drawRect(base1, COLORS.base1, '#0006'); drawRect(base2, COLORS.base2, '#0006');
  c.fillStyle = COLORS.slow; c.fillRect(slowZone.x, slowZone.y, slowZone.w, slowZone.h);
  for (const p of platforms) drawRect(p, '#24315d', '#31427a'); drawRect(movingPlatform, COLORS.plat, '#49609cff');
  drawParticles();
  if (USE_WAVING_FLAG) drawWavingFlag(flag);
  else drawFlag();
  drawPlayers();
  for (const pu of powerups) {
    drawStar(pu.x + pu.w / 2, pu.y + pu.h / 2, 5, 9, 4, '#ffd700');
  }
  c.fillStyle = COLORS.text; c.font = '10px "Press Start 2P"';
  c.fillText('P1 effects: ' + (activeText(p1.effects) || '–'), 12, 18);
  c.fillText('P2 effects: ' + (activeText(p2.effects) || '–'), 12, 34);
}

/* ===== frame driver ===== */
function frame(now) {
  const dt = Math.min(40, now - lastTime);
  lastTime = now;
  if (running) update(dt);
  draw();
  frameCount++;
  requestAnimationFrame(frame);
}

/* ===== start ===== */
resetGame();
initClouds();
Sound.startBackgroundMusic();
requestAnimationFrame(frame);
canvas.addEventListener('click', () => canvas.focus(), {passive: true});
HUD.pauseBtn.addEventListener('keydown', (e) => { if (e.key === 'f' || e.key === 'F') USE_WAVING_FLAG = !USE_WAVING_FLAG; });
</script>
</body>
</html>