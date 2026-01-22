<template>
  <header class="header">
    <NavBar />
  </header>
  <h1>Portal de notícias</h1>
  <hr class="divider" />
  <div class="messages">
    <div class="alert alert-success" v-if="alertaInscrito" role="alert">
      <i class="mdi mdi-check"></i>
      Você receberá noticias toda manhã, obrigado por se inscrever!
    </div>
    <div class="alert alert-danger" v-if="alertaNoData" role="alert">
      <i class="mdi mdi-info"></i>
      Não foi possível encontrar dados com a pesquisa.
    </div>
  </div>
  <div class="container">
    <div class="blur-overlay" id="loading">
      <div class="spinner"></div>
    </div>
    <div class='world_news'>
      <WorldNews />
    </div>
    <transition name="fade" mode="out-in">
      <RouterView />
    </transition>
    <div class='live_iframe'>
      <LiveNews />
    </div>

  </div>
  <div class="footer">
    <FooterPage />
  </div>
</template>
<script>

import NavBar from "./components/NavBar.vue";
import FooterPage from "./components/FooterPage.vue";
import WorldNews from "./components/WorldNews.vue";
import LiveNews from "./components/LiveNews.vue";
export default {
  name: "App",
  data() {
    return {
      alertaInscrito: false,
      alertaNoData: false,
    };
  },
  created() {
    document.title = "News Website";
  },
  mounted() {
    this.alertaInscrito = sessionStorage.getItem("subscribed") ? sessionStorage.getItem("subscribed") : false;
    this.alertaNoData = sessionStorage.getItem("nodata") ? sessionStorage.getItem("nodata") : false;
    sessionStorage.clear()
  },
  methods: {
    beforeEnter(el) {
      el.style.opacity = 0;
    },
    enter(el, done) {
      setTimeout(() => {
        el.style.opacity = 1;
        done();
      }, 500);
    },
    leave(el, done) {
      el.style.opacity = 0;
      setTimeout(done, 500);
    },
  },
  watch: {
    $route() {
      this.alertaInscrito = false;
      this.alertaNoData = false;
    }
  },
  components: {
    NavBar,
    FooterPage,
    WorldNews,
    LiveNews
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jersey+25&family=Markazi+Text:wght@400..700&family=Roboto+Slab:wght@100..900&family=VT323&display=swap");

.blur-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.footer {
  margin: 0;
  padding: 0;
}

.spinner {
  width: 45px;
  height: 45px;
  border: 4px solid #e2e8f0;
  border-top: 4px solid #2563eb;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

h1 {
  display: none;
}

.header {
  width: 100%;
  margin-bottom: 15px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  align-self: flex-start;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.divider {
  color: #e2e8f0;
  display: flex;
  justify-content: center;
  align-items: center;
  align-self: center;
  width: 60%;
  padding: 8px 0px;
  margin-top: 70px;
  border-color: #e2e8f0;
}

.messages {
  width: 90%;
  max-width: 800px;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  align-self: center;
}

.container {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  color: #1e293b;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  align-self: flex-start;
  padding: 0 15px;
}

.messages .alert {
  font-family: "Markazi Text", serif;
  font-size: 18px;
  padding: 12px 30px;
  border-radius: 10px;
  border: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.messages .alert-success {
  background-color: #ecfdf5;
  color: #065f46;
}

.messages .alert-danger {
  background-color: #fef2f2;
  color: #991b1b;
}

@media (max-width: 1024px) {
  .live_iframe {
    width: 0;
    height: 0;
    display: none;
  }

  header.header {
    padding: 0;
    height: 90px;
  }

  .divider {
    padding: 0;
    margin-top: 100px;
    display: block;
    text-align: center;
    width: 80%;
  }

  .container {
    padding: 0 10px;
  }
}

@media (max-width: 768px) {
  .world_news {
    display: none;
  }

  header.header {
    margin-bottom: 40px;
  }

  .container {
    width: 100%;
    display: block;
    padding: 0 10px;
  }

  h1 {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 30px;
    font-family: "Roboto Condensed";
    font-size: 28px;
    color: #1e293b;
    font-weight: 700;
  }

  .divider {
    margin-top: 20px;
    width: 90%;
  }

  .messages {
    width: 95%;
  }

  .messages .alert {
    font-size: 16px;
    padding: 10px 20px;
  }
}
</style>
