<template>
  <div class="app-wrapper">
    <!-- Stock Ticker -->
    <StockTicker />

    <!-- Header -->
    <header class="header">
      <div class="header-top">
        <div class="header-content">
          <div class="logo">
            <router-link to="/" class="logo-link">
              <i class="mdi mdi-newspaper-variant-outline"></i>
              <div class="logo-text">
                <span class="logo-main">News Portal</span>
                <span class="logo-sub">Notícias em tempo real</span>
              </div>
            </router-link>
          </div>
          <div class="header-date">
            <i class="mdi mdi-calendar-today"></i>
            {{ formattedDate }}
          </div>
        </div>
      </div>
      <NavBar />
    </header>

    <!-- Alerts -->
    <div class="messages" v-if="alertaInscrito || alertaNoData">
      <div class="alert alert-success" v-if="alertaInscrito" role="alert">
        <i class="mdi mdi-check-circle"></i>
        <span>Você receberá notícias toda manhã, obrigado por se inscrever!</span>
        <button class="alert-close" @click="alertaInscrito = false">
          <i class="mdi mdi-close"></i>
        </button>
      </div>
      <div class="alert alert-danger" v-if="alertaNoData" role="alert">
        <i class="mdi mdi-alert-circle"></i>
        <span>Não foi possível encontrar dados com a pesquisa.</span>
        <button class="alert-close" @click="alertaNoData = false">
          <i class="mdi mdi-close"></i>
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
      <div class="blur-overlay" id="loading">
        <div class="spinner-container">
          <div class="spinner"></div>
          <span class="spinner-text">Carregando notícias...</span>
        </div>
      </div>

      <div class="content-grid">
        <aside class="sidebar sidebar-left">
          <WorldNews />
        </aside>

        <section class="news-main">
          <transition name="fade" mode="out-in">
            <RouterView />
          </transition>
        </section>

        <aside class="sidebar sidebar-right">
          <LiveNews />
          <WeatherWidget />
        </aside>
      </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
      <FooterPage />
    </footer>
  </div>
</template>

<script>
import NavBar from "./components/NavBar.vue";
import FooterPage from "./components/FooterPage.vue";
import WorldNews from "./components/WorldNews.vue";
import LiveNews from "./components/LiveNews.vue";
import StockTicker from "./components/StockTicker.vue";
import WeatherWidget from "./components/WeatherWidget.vue";

export default {
  name: "App",
  data() {
    return {
      alertaInscrito: false,
      alertaNoData: false,
      formattedDate: ''
    };
  },
  created() {
    document.title = "News Portal - Últimas Notícias";
    this.updateDate();
  },
  mounted() {
    this.alertaInscrito = sessionStorage.getItem("subscribed") ? true : false;
    this.alertaNoData = sessionStorage.getItem("nodata") ? true : false;
    sessionStorage.clear();
  },
  methods: {
    updateDate() {
      const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      };
      this.formattedDate = new Date().toLocaleDateString('pt-BR', options);
    }
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
    LiveNews,
    StockTicker,
    WeatherWidget
  }
};
</script>

<style scoped>
.app-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background: #f8fafc;
}

/* Header Styles */
.header {
  width: 100%;
  background: #ffffff;
  box-shadow: var(--shadow, 0 4px 6px -1px rgb(0 0 0 / 0.1));
  position: sticky;
  top: 0;
  z-index: 100;
}

.header-top {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  padding: 12px 0;
}

.header-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-link {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
  color: #ffffff;
}

.logo-link i {
  font-size: 36px;
  color: #f59e0b;
}

.logo-text {
  display: flex;
  flex-direction: column;
}

.logo-main {
  font-family: 'Playfair Display', serif;
  font-size: 26px;
  font-weight: 700;
  letter-spacing: -0.5px;
}

.logo-sub {
  font-size: 12px;
  color: #94a3b8;
  font-weight: 400;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.header-date {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #94a3b8;
  font-size: 14px;
  text-transform: capitalize;
}

.header-date i {
  color: #f59e0b;
}

/* Messages/Alerts */
.messages {
  max-width: 1400px;
  margin: 15px auto;
  padding: 0 20px;
  width: 100%;
}

.alert {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 20px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 500;
  animation: slideDown 0.3s ease;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.alert i:first-child {
  font-size: 22px;
}

.alert span {
  flex: 1;
}

.alert-close {
  background: none;
  border: none;
  cursor: pointer;
  padding: 5px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease;
}

.alert-close:hover {
  background: rgba(0, 0, 0, 0.1);
}

.alert-success {
  background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
  color: #065f46;
  border-left: 4px solid #10b981;
}

.alert-danger {
  background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
  color: #991b1b;
  border-left: 4px solid #ef4444;
}

/* Main Content */
.main-content {
  flex: 1;
  max-width: 1400px;
  margin: 0 auto;
  padding: 25px 20px;
  width: 100%;
  position: relative;
}

/* Loading Overlay */
.blur-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(8px);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.spinner-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #e2e8f0;
  border-top: 4px solid #2563eb;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

.spinner-text {
  color: #64748b;
  font-size: 14px;
  font-weight: 500;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Content Grid */
.content-grid {
  display: grid;
  grid-template-columns: 280px 1fr 300px;
  gap: 25px;
  align-items: start;
}

.sidebar {
  position: sticky;
  top: 140px;
}

.sidebar-left {
  order: 1;
}

.news-main {
  order: 2;
}

.sidebar-right {
  order: 3;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Footer */
.footer {
  margin-top: auto;
}

/* Responsive */
@media (max-width: 1200px) {
  .content-grid {
    grid-template-columns: 1fr 300px;
  }

  .sidebar-left {
    display: none;
  }
}

@media (max-width: 1024px) {
  .content-grid {
    grid-template-columns: 1fr;
  }

  .sidebar-right {
    display: none;
  }

  .header-top {
    padding: 10px 0;
  }

  .logo-link i {
    font-size: 28px;
  }

  .logo-main {
    font-size: 22px;
  }

  .logo-sub {
    font-size: 10px;
  }
}

@media (max-width: 768px) {
  .header-date {
    display: none;
  }

  .main-content {
    padding: 15px 10px;
  }

  .messages {
    padding: 0 10px;
  }

  .alert {
    font-size: 14px;
    padding: 12px 15px;
  }
}

@media (max-width: 480px) {
  .logo-sub {
    display: none;
  }

  .logo-main {
    font-size: 20px;
  }
}
</style>
