<template>
  <div class="live-container">
    <div class="live-badge" @click="loadStream" v-if="!showStream">
      <span class="pulse"></span>
      Ao Vivo - Clique para assistir
    </div>
    <div v-if="showStream" class="stream-wrapper">
      <div class="live-badge active">
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
  name: "LiveNews",
  data() {
    return {
      showStream: false
    };
  },
  methods: {
    loadStream() {
      this.showStream = true;
    }
  }
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
  padding: 10px 16px;
  border-radius: 8px;
  position: relative;
  font-family: "Roboto Condensed";
  cursor: pointer;
  background: #fafbfc;
  border: 1px solid #e2e8f0;
  transition: all 0.2s ease;
}

.live-badge:hover {
  background: #f1f5f9;
  border-color: #cbd5e1;
}

.live-badge.active {
  cursor: default;
  background: transparent;
  border: none;
  padding: 8px 0;
  margin-bottom: 8px;
}

.live-badge.active:hover {
  background: transparent;
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
  left: 14px;
  width: 14px;
  height: 14px;
  background: rgba(239, 68, 68, 0.5);
  border-radius: 50%;
  animation: pulse 1.5s infinite ease-out;
}

.live-badge.active .pulse {
  left: -2px;
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
