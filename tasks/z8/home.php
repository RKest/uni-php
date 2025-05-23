<div>
<audio controls>
  <source src="/tasks/z8/St-James-Infirmary-2.mp3" type="audio/mpeg">
</audio> 
<p>St-James-Infarmary</p>

<audio controls>
  <source src="/tasks/z8/lagtrain.mp3" type="audio/mpeg">
</audio> 
<p>Lagtrain</p>

<audio controls>
  <source src="/tasks/z8/prel4-1.mp3" type="audio/mpeg">
</audio> 
<p>Prelude in E minor</p>

<audio controls>
  <source src="/tasks/z8/【YOASOBI】もしも命が描けたら（若能描绘生命）.mp3" type="audio/mpeg">
</audio> 
<p>もしも命が描けたら</p>
</div>

<style>

:root {
  --keyboard: hsl(300, 100%, 16%);
  --keyboard-shadow: hsla(19, 50%, 66%, 0.2);
  --keyboard-border: hsl(20, 91%, 5%);
  --black-10: hsla(0, 0%, 0%, 0.1);
  --black-20: hsla(0, 0%, 0%, 0.2);
  --black-30: hsla(0, 0%, 0%, 0.3);
  --black-50: hsla(0, 0%, 0%, 0.5);
  --black-60: hsla(0, 0%, 0%, 0.6);
  --white-20: hsla(0, 0%, 100%, 0.2);
  --white-50: hsla(0, 0%, 100%, 0.5);
  --white-80: hsla(0, 0%, 100%, 0.8);
}

.white,
.black {
  position: relative;
  float: left;
  display: flex;
  justify-content: center;
  align-items: flex-end;
  padding: 0.5rem 0;
  user-select: none;
  cursor: pointer;
}

#keyboard li:first-child {
  border-radius: 5px 0 5px 5px;
}

#keyboard li:last-child {
  border-radius: 0 5px 5px 5px;
}

.white {
  height: 12.5rem;
  width: 3.5rem;
  z-index: 1;
  border-left: 1px solid hsl(0, 0%, 73%);
  border-bottom: 1px solid hsl(0, 0%, 73%);
  border-radius: 0 0 5px 5px;
  box-shadow: -1px 0 0 var(--white-80) inset, 0 0 5px hsl(0, 0%, 80%) inset,
    0 0 3px var(--black-20);
  background: linear-gradient(to bottom, hsl(0, 0%, 93%) 0%, white 100%);
  color: var(--black-30);
}

.black {
  height: 8rem;
  width: 2rem;
  margin: 0 0 0 -1rem;
  z-index: 2;
  border: 1px solid black;
  border-radius: 0 0 3px 3px;
  box-shadow: -1px -1px 2px var(--white-20) inset,
    0 -5px 2px 3px var(--black-60) inset, 0 2px 4px var(--black-50);
  background: linear-gradient(45deg, hsl(0, 0%, 13%) 0%, hsl(0, 0%, 33%) 100%);
  color: var(--white-50);
}

.white.pressed {
  border-top: 1px solid hsl(0, 0%, 47%);
  border-left: 1px solid hsl(0, 0%, 60%);
  border-bottom: 1px solid hsl(0, 0%, 60%);
  box-shadow: 2px 0 3px var(--black-10) inset,
    -5px 5px 20px var(--black-20) inset, 0 0 3px var(--black-20);
  background: linear-gradient(to bottom, white 0%, hsl(0, 0%, 91%) 100%);
  outline: none;
}

.black.pressed {
  box-shadow: -1px -1px 2px var(--white-20) inset,
    0 -2px 2px 3px var(--black-60) inset, 0 1px 2px var(--black-50);
  background: linear-gradient(
    to right,
    hsl(0, 0%, 27%) 0%,
    hsl(0, 0%, 13%) 100%
  );
  outline: none;
}

.offset {
  margin: 0 0 0 -1rem;
}

#keyboard {
  height: 15.25rem;
  width: 41rem;
  margin: 0.5rem auto;
  padding: 3rem 0 0 3rem;
  position: relative;
  border: 1px solid var(--keyboard-border);
  border-radius: 1rem;
  background-color: var(--keyboard);
  box-shadow: 0 0 50px var(--black-50) inset, 0 1px var(--keyboard-shadow) inset,
    0 5px 15px var(--black-50);
}
</style>

<ul id="keyboard">
  <li note="C" class="white">A</li>
  <li note="C#" class="black">W</li>
  <li note="D" class="white offset">S</li>
  <li note="D#" class="black">E</li>
  <li note="E" class="white offset">D</li>
  <li note="F" class="white">F</li>
  <li note="F#" class="black">T</li>
  <li note="G" class="white offset">G</li>
  <li note="G#" class="black">Y</li>
  <li note="A" class="white offset">H</li>
  <li note="A#" class="black">U</li>
  <li note="B" class="white offset">J</li>
  <li note="C2" class="white">K</li>
  <li note="C#2" class="black">O</li>
  <li note="D2" class="white offset">L</li>
  <li note="D#2" class="black">P</li>
  <li note="E2" class="white offset">;</li>
</ul>

<script>
const audioContext = new (window.AudioContext || window.webkitAudioContext)();

const getElementByNote = (note) =>
  note && document.querySelector(`[note="${note}"]`);

const keys = {
  A: { element: getElementByNote("C"), note: "C", octaveOffset: 0 },
  W: { element: getElementByNote("C#"), note: "C#", octaveOffset: 0 },
  S: { element: getElementByNote("D"), note: "D", octaveOffset: 0 },
  E: { element: getElementByNote("D#"), note: "D#", octaveOffset: 0 },
  D: { element: getElementByNote("E"), note: "E", octaveOffset: 0 },
  F: { element: getElementByNote("F"), note: "F", octaveOffset: 0 },
  T: { element: getElementByNote("F#"), note: "F#", octaveOffset: 0 },
  G: { element: getElementByNote("G"), note: "G", octaveOffset: 0 },
  Y: { element: getElementByNote("G#"), note: "G#", octaveOffset: 0 },
  H: { element: getElementByNote("A"), note: "A", octaveOffset: 1 },
  U: { element: getElementByNote("A#"), note: "A#", octaveOffset: 1 },
  J: { element: getElementByNote("B"), note: "B", octaveOffset: 1 },
  K: { element: getElementByNote("C2"), note: "C", octaveOffset: 1 },
  O: { element: getElementByNote("C#2"), note: "C#", octaveOffset: 1 },
  L: { element: getElementByNote("D2"), note: "D", octaveOffset: 1 },
  P: { element: getElementByNote("D#2"), note: "D#", octaveOffset: 1 },
  semicolon: { element: getElementByNote("E2"), note: "E", octaveOffset: 1 }
};

const getHz = (note = "A", octave = 4) => {
  const A4 = 440;
  let N = 0;
  switch (note) {
    default:
    case "A":
      N = 0;
      break;
    case "A#":
    case "Bb":
      N = 1;
      break;
    case "B":
      N = 2;
      break;
    case "C":
      N = 3;
      break;
    case "C#":
    case "Db":
      N = 4;
      break;
    case "D":
      N = 5;
      break;
    case "D#":
    case "Eb":
      N = 6;
      break;
    case "E":
      N = 7;
      break;
    case "F":
      N = 8;
      break;
    case "F#":
    case "Gb":
      N = 9;
      break;
    case "G":
      N = 10;
      break;
    case "G#":
    case "Ab":
      N = 11;
      break;
  }
  N += 12 * (octave - 4);
  return A4 * Math.pow(2, N / 12);
};

const pressedNotes = new Map();
let clickedKey = "";

const playKey = (key) => {
  if (!keys[key]) {
    return;
  }

  const osc = audioContext.createOscillator();
  const noteGainNode = audioContext.createGain();
  noteGainNode.connect(audioContext.destination);

  const zeroGain = 0.00001;
  const maxGain = 0.5;
  const sustainedGain = 0.001;

  noteGainNode.gain.value = zeroGain;

  const setAttack = () =>
    noteGainNode.gain.exponentialRampToValueAtTime(
      maxGain,
      audioContext.currentTime + 0.01
    );
  const setDecay = () =>
    noteGainNode.gain.exponentialRampToValueAtTime(
      sustainedGain,
      audioContext.currentTime + 1
    );
  const setRelease = () =>
    noteGainNode.gain.exponentialRampToValueAtTime(
      zeroGain,
      audioContext.currentTime + 2
    );

  setAttack();
  setDecay();
  setRelease();

  osc.connect(noteGainNode);
  osc.type = "triangle";

  const freq = getHz(keys[key].note, (keys[key].octaveOffset || 0) + 3);

  if (Number.isFinite(freq)) {
    osc.frequency.value = freq;
  }

  keys[key].element.classList.add("pressed");
  pressedNotes.set(key, osc);
  pressedNotes.get(key).start();
};

const stopKey = (key) => {
  if (!keys[key]) {
    return;
  }

  keys[key].element.classList.remove("pressed");
  const osc = pressedNotes.get(key);

  if (osc) {
    setTimeout(() => {
      osc.stop();
    }, 2000);

    pressedNotes.delete(key);
  }
};

document.addEventListener("keydown", (e) => {
  const eventKey = e.key.toUpperCase();
  const key = eventKey === ";" ? "semicolon" : eventKey;
  
  if (!key || pressedNotes.get(key)) {
    return;
  }
  playKey(key);
});

document.addEventListener("keyup", (e) => {
  const eventKey = e.key.toUpperCase();
  const key = eventKey === ";" ? "semicolon" : eventKey;
  
  if (!key) {
    return;
  }
  stopKey(key);
});

for (const [key, { element }] of Object.entries(keys)) {
  element.addEventListener("mousedown", () => {
    playKey(key);
    clickedKey = key;
  });
}

document.addEventListener("mouseup", () => {
  stopKey(clickedKey);
});
</script>
