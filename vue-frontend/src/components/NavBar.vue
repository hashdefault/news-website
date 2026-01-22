<template>
  <div class="navbar-wrapper" id="container_nav">
    <!-- Mobile Header -->
    <div class="mobile-header">
      <button class="menu-toggle" @click="openMenu">
        <i :class="displayMenu ? 'mdi mdi-close' : 'mdi mdi-menu'"></i>
      </button>
      <router-link to="/" class="mobile-logo">
        <i class="mdi mdi-newspaper-variant-outline"></i>
        <span>News</span>
      </router-link>
      <button class="search-toggle" @click="toggleSearch">
        <i class="mdi mdi-magnify"></i>
      </button>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar" :class="{ show: displayMenu }">
      <div class="nav-content">
        <!-- Search Form -->
        <div class="search-container" :class="{ 'mobile-show': showMobileSearch }">
          <form @submit.prevent="redir" class="search-form">
            <i class="mdi mdi-magnify"></i>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Buscar notícias..."
              class="search-input"
            />
            <button type="submit" class="search-btn">
              Buscar
            </button>
          </form>
        </div>

        <!-- Nav Links -->
        <ul class="nav-links">
          <li v-for="link in navLinks" :key="link.path">
            <router-link
              :to="link.path"
              class="nav-link"
              @click="closeMenu"
            >
              <i :class="'mdi ' + link.icon"></i>
              <span>{{ link.label }}</span>
            </router-link>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Overlay -->
    <div class="nav-overlay" :class="{ show: displayMenu }" @click="closeMenu"></div>
  </div>
</template>

<script>
export default {
  name: "NavBar",
  data() {
    return {
      displayMenu: false,
      showMobileSearch: false,
      searchQuery: '',
      navLinks: [
        { path: '/', label: 'Início', icon: 'mdi-home-outline' },
        { path: '/entertainment', label: 'Entretenimento', icon: 'mdi-movie-open-outline' },
        { path: '/sports', label: 'Esportes', icon: 'mdi-soccer' },
        { path: '/technology', label: 'Tecnologia', icon: 'mdi-laptop' },
        { path: '/science', label: 'Ciência', icon: 'mdi-flask-outline' },
        { path: '/business', label: 'Negócios', icon: 'mdi-chart-line' },
        { path: '/politics', label: 'Política', icon: 'mdi-bank-outline' },
        { path: '/health', label: 'Saúde', icon: 'mdi-heart-pulse' }
      ]
    };
  },
  methods: {
    openMenu() {
      this.displayMenu = !this.displayMenu;
      document.body.style.overflow = this.displayMenu ? 'hidden' : '';
    },
    closeMenu() {
      this.displayMenu = false;
      document.body.style.overflow = '';
    },
    toggleSearch() {
      this.showMobileSearch = !this.showMobileSearch;
    },
    redir() {
      if (!this.searchQuery.trim()) return;

      sessionStorage.setItem("nodata", true);
      this.$router.push({
        path: '/search',
        query: { q: this.searchQuery }
      });

      this.searchQuery = '';
      this.closeMenu();
      this.showMobileSearch = false;
    }
  },
  mounted() {
    document.addEventListener('click', (e) => {
      const navbar = document.getElementById('container_nav');
      if (navbar && !navbar.contains(e.target)) {
        this.closeMenu();
      }
    });
  }
};
</script>

<style scoped>
.navbar-wrapper {
  background: #ffffff;
  position: relative;
}

/* Mobile Header */
.mobile-header {
  display: none;
  align-items: center;
  justify-content: space-between;
  padding: 12px 16px;
  background: #ffffff;
}

.menu-toggle,
.search-toggle {
  background: none;
  border: none;
  padding: 8px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.menu-toggle:hover,
.search-toggle:hover {
  background: #f1f5f9;
}

.menu-toggle i,
.search-toggle i {
  font-size: 24px;
  color: #1e293b;
}

.mobile-logo {
  display: flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  color: #1e293b;
  font-family: 'Playfair Display', serif;
  font-size: 20px;
  font-weight: 700;
}

.mobile-logo i {
  font-size: 26px;
  color: #f59e0b;
}

/* Main Navbar */
.navbar {
  background: #ffffff;
  border-top: 1px solid #e2e8f0;
}

.nav-content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  align-items: center;
  gap: 30px;
}

/* Search Container */
.search-container {
  flex-shrink: 0;
}

.search-form {
  display: flex;
  align-items: center;
  background: #f1f5f9;
  border-radius: 10px;
  padding: 6px 6px 6px 14px;
  gap: 10px;
  transition: all 0.2s ease;
  border: 2px solid transparent;
}

.search-form:focus-within {
  background: #ffffff;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.search-form i {
  color: #64748b;
  font-size: 20px;
}

.search-input {
  border: none;
  background: none;
  outline: none;
  font-size: 14px;
  width: 200px;
  color: #1e293b;
}

.search-input::placeholder {
  color: #94a3b8;
}

.search-btn {
  background: #2563eb;
  color: #ffffff;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s ease;
}

.search-btn:hover {
  background: #1d4ed8;
}

/* Nav Links */
.nav-links {
  display: flex;
  align-items: center;
  list-style: none;
  margin: 0;
  padding: 0;
  flex: 1;
  gap: 4px;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 14px 14px;
  text-decoration: none;
  color: #475569;
  font-size: 15px;
  font-weight: 500;
  border-radius: 8px;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.nav-link i {
  font-size: 18px;
  display: none;
}

.nav-link:hover {
  color: #2563eb;
  background: rgba(37, 99, 235, 0.08);
}

.nav-link.router-link-exact-active {
  color: #2563eb;
  background: rgba(37, 99, 235, 0.1);
  font-weight: 600;
}

/* Overlay */
.nav-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 90;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.nav-overlay.show {
  opacity: 1;
}

/* Responsive */
@media (max-width: 1200px) {
  .nav-link {
    padding: 12px 10px;
    font-size: 14px;
  }

  .search-input {
    width: 160px;
  }
}

@media (max-width: 1024px) {
  .mobile-header {
    display: flex;
  }

  .navbar {
    position: fixed;
    top: 0;
    left: -100%;
    width: 320px;
    height: 100vh;
    z-index: 100;
    flex-direction: column;
    transition: left 0.3s ease;
    overflow-y: auto;
    border-top: none;
    box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
  }

  .navbar.show {
    left: 0;
  }

  .nav-content {
    flex-direction: column;
    padding: 20px;
    gap: 20px;
    align-items: stretch;
  }

  .search-container {
    width: 100%;
    padding-top: 10px;
  }

  .search-container.mobile-show {
    display: block;
  }

  .search-form {
    width: 100%;
  }

  .search-input {
    width: 100%;
    flex: 1;
  }

  .nav-links {
    flex-direction: column;
    gap: 4px;
    width: 100%;
  }

  .nav-links li {
    width: 100%;
  }

  .nav-link {
    padding: 14px 16px;
    font-size: 16px;
    border-radius: 10px;
  }

  .nav-link i {
    display: block;
    font-size: 22px;
    width: 28px;
  }

  .nav-overlay {
    display: block;
    pointer-events: none;
  }

  .nav-overlay.show {
    pointer-events: auto;
  }
}

@media (max-width: 480px) {
  .navbar {
    width: 100%;
  }

  .mobile-logo span {
    display: none;
  }

  .mobile-logo i {
    font-size: 30px;
  }
}
</style>
