<template>
  <div class="live-container">
    <div class="stream-wrapper">
      <div class="live-badge">
        <span class="pulse"></span>
        Ao Vivo
      </div>
      <iframe
        class='live_news'
        src="https://abcnews.go.com/video/embed?id=abc_live11"
        allowfullscreen
        scrolling='no'
        frameborder="0"
        loading="lazy"
      ></iframe>
    </div>
  </div>
</template>
<script>
export default {
  name: "LiveNews"
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jersey+25&family=Markazi+Text:wght@400..700&family=Roboto+Slab:wght@100..900&family=VT323&display=swap");

.live-container {
  float: right;
}

.stream-wrapper {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

iframe.live_news {
  width: 320px;
  height: 180px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.live-badge {
  display: flex;
  align-items: center;
  font-size: 16px;
  font-weight: bold;
  color: #1e293b;
  padding: 8px 0;
  margin-bottom: 8px;
  position: relative;
  font-family: "Roboto Condensed";
}

.live-badge::before {
  content: "";
  width: 10px;
  height: 10px;
  background: #ef4444;
  border-radius: 50%;
  margin-right: 8px;
  position: relative;
}

.pulse {
  position: absolute;
  left: -2px;
  width: 14px;
  height: 14px;
  background: rgba(239, 68, 68, 0.5);
  border-radius: 50%;
  animation: pulse 1.5s infinite ease-out;
}

@keyframes pulse {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  100% {
    transform: scale(2);
    opacity: 0;
  }
}

@media (max-width: 768px) {
  .live-container,
  .stream-wrapper,
  .pulse,
  .live-badge {
    display: none;
  }
}
</style>
