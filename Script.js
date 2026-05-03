document.addEventListener('DOMContentLoaded', () => {
  document.body.style.backgroundImage = "url('https://i.pinimg.com/736x/2d/0e/88/2d0e88623e87c37ab3389b3fd22d55b2.jpg')";

  const generateBtn = document.getElementById('generateBtn');

  const cardSection = document.getElementById('cardSection');
  const cardName = document.getElementById('cardName');
  const cardAddress = document.getElementById('cardAddress');
  const cardDate = document.getElementById('cardDate');
  const cardTime = document.getElementById('cardTime');
  const cardPhoto = document.getElementById('cardPhoto');
  const photoInput = document.getElementById('photo');

  const mapContainer = document.getElementById('mapContainer');
  const mapFrame = document.getElementById('mapFrame');

  const confettiCanvas = document.getElementById('confettiCanvas');
  const confetti = window.confetti ? window.confetti.create(confettiCanvas, { resize: true, useWorker: true }) : null;

  const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search?';

  generateBtn.addEventListener('click', async () => {
    const nameVal = document.getElementById('name').value.trim();
    const locationVal = document.getElementById('location').value.trim();
    const dateVal = document.getElementById('date').value;
    const timeVal = document.getElementById('time').value;

    if (!nameVal || !locationVal || !dateVal || !timeVal) {
      alert('Please fill in all required fields.');
      return;
    }

    cardName.textContent = `You're invited by ${nameVal}`;
    cardDate.textContent = new Date(dateVal).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
    cardTime.textContent = timeVal;

    const file = photoInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        cardPhoto.src = e.target.result;
        cardPhoto.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    } else {
      cardPhoto.classList.add('hidden');
      cardPhoto.src = '';
    }

    try {
      const params = new URLSearchParams({
        q: locationVal,
        format: 'json',
        limit: 1
      });

      const response = await fetch(NOMINATIM_URL + params.toString(), {
        headers: { 'Accept-Language': 'en-US,en;q=0.9' }
      });
      const data = await response.json();

      if (data.length > 0) {
        const place = data[0];
        cardAddress.textContent = place.display_name || locationVal;

        const lat = place.lat;
        const lon = place.lon;
        const bboxPadding = 0.005;
        const mapSrc = `https://www.openstreetmap.org/export/embed.html?bbox=${lon - bboxPadding},${lat - bboxPadding},${Number(lon) + bboxPadding},${Number(lat) + bboxPadding}&layer=mapnik&marker=${lat},${lon}`;
        mapFrame.src = mapSrc;
        mapContainer.classList.remove('hidden');
      } else {
        cardAddress.textContent = locationVal;
        mapContainer.classList.add('hidden');
      }
    } catch (err) {
      console.error('Location fetch error:', err);
      cardAddress.textContent = locationVal;
      mapContainer.classList.add('hidden');
    }

    cardSection.classList.remove('hidden');

    launchConfetti();

    cardSection.scrollIntoView({ behavior: 'smooth' });
  });

  function launchConfetti() {
    if (!confetti) return;
    const duration = 3 * 1000;
    const animationEnd = Date.now() + duration;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 1000 };

    function randomInRange(min, max) {
      return Math.random() * (max - min) + min;
    }

    const interval = setInterval(() => {
      const timeLeft = animationEnd - Date.now();

      if (timeLeft <= 0) {
        clearInterval(interval);
        return;
      }

      const particleCount = 50 * (timeLeft / duration);

      confetti(Object.assign({}, defaults, {
        particleCount,
        origin: { x: randomInRange(0.2, 0.8), y: Math.random() * 0.2 }
      }));
    }, 250);
  }
});
