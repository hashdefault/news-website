<template>
  <div class='container' id='container_nav'>
    <a class="menu" @click="openMenu"><i class="mdi mdi-menu"></i></a>
    <a class="menu" @click="openMenu"><i class="mdi mdi-magnify"></i></a>
    <a class="navbar-brand" href="#"><span>news</span><i class="mdi mdi-newspaper"></i></a>
    <nav class="navbar navbar-expand-lg " :class="{ show: displayMenu }">
      <div class='form-container'>
        <form @submit.prevent="redir" action="/" method="get" class='form-search' name="search" id='search'>
          <div class="row">
            <div class="col-auto">
              <input placeholder="Pesquisar" type="text" id="pesquisa_noticia" class="form-control " />
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-sm search">
                <i class="mdi mdi-magnify"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class='items-navigation'>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <RouterLink class="nav-link" to="/">Início</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/">Geral</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/entertainment">Entretenimento</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/sports">Esportes</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/technology">Tecnologia</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/science">Ciência</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/business">Negócios</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/politics">Política</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/health">Saúde</RouterLink>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  name: "NavBar",
  data() {
    return {
      languages: "pt,en,es",
      displayMenu: false
    };
  },
  methods: {
    openMenu() {
      this.displayMenu = !this.displayMenu
    },
    closeMenu() {
      this.displayMenu = false
    },
    redir() {
      const querySearch = document.getElementById('pesquisa_noticia').value

      document.getElementById('pesquisa_noticia').value = ""
      try {
        sessionStorage.setItem("nodata", true);
        this.$router.push(

          {
            path: '/search',
            query: { q: querySearch }
          }
        )
      } catch (error) {
        console.error(error)
      }
    },
  },
  mounted() {
    document.addEventListener('click', (e) => {
      let navbar = document.getElementById('container_nav')
      if (!navbar.contains(e.target)) {
        this.closeMenu()
      }
    })
  }
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jersey+25&family=Markazi+Text:wght@400..700&family=Roboto+Slab:wght@100..900&family=VT323&display=swap");

nav.navbar {
  width: 100%;
  background-color: #ffffff;
  color: #1e293b;
  font-family: "Markazi Text", serif;
  position: fixed;
  overflow: hidden;
  z-index: 10;
  padding: 0px 150px;
  margin-top: 26px;
  display: flex;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.navbar-brand span {
  display: none;
}

.navbar-brand {
  width: 100%;
  background-color: #ffffff;
  color: #1e293b;
  display: flex;
  position: fixed;
  flex-direction: column;
  align-items: center;
  align-self: center;
  margin-top: -12px;
  padding: 0;
  z-index: 10;
  overflow: hidden;
}

.form-container {
  margin: 0px;
  padding-right: 80px;
}

i {
  color: #1e293b;
}

.navbar ul.navbar-nav li.nav-item .nav-link {
  color: #1e293b;
  margin-left: 8px;
  font-size: 20px;
  padding: 8px 12px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.navbar ul.navbar-nav li.nav-item .nav-link:hover {
  text-decoration: none;
  background-color: rgba(37, 99, 235, 0.1);
  color: #2563eb;
}

.navbar ul.navbar-nav li.nav-item .nav-link.router-link-active {
  color: #2563eb;
  font-weight: 600;
}

.navbar .btn-sm.search i {
  color: white;
  font-size: 18px;
}

.navbar .btn-sm.search {
  background-color: #2563eb;
  border-radius: 6px;
  padding: 4px 12px;
  transition: background-color 0.2s ease;
}

.navbar .btn-sm.search:hover {
  background-color: #1d4ed8;
}

input.form-control {
  font-family: "Roboto Condensed";
  font-size: 14px;
  border-radius: 6px;
  border: 1px solid #e2e8f0;
  padding: 8px 12px;
}

input.form-control:focus {
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  border-color: #2563eb;
}

.navbar-brand i.mdi {
  font-size: 24px;
  color: #2563eb;
}

.menu i.mdi {
  font-size: 28px;
  transition: color 0.2s ease;
}

.menu:hover i.mdi {
  color: #2563eb;
}

@media (max-width: 1024px) {
  .form-container {
    margin: 0px;
    display: flex;
    width: 100%;
    align-items: center;
    padding: 10px;
    align-self: center;
    justify-content: center;
  }

  .container {
    min-width: 100%;
    background-color: #ffffff;
    height: 80px;
    padding: 0;
    margin: 0;
    position: fixed;
    z-index: 50;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  }

  div.container nav.navbar {
    height: 0;
    width: 0;
    position: fixed;
    z-index: 50;
  }

  .navbar-brand {
    background-color: transparent;
    display: flex;
    align-items: center;
    align-self: center;
    flex-direction: row;
    font-size: 22px;
    margin-left: 80px;
    font-family: "Roboto Condensed";
    margin-top: 0px;
  }

  .navbar-brand span {
    display: flex;
    font-weight: 700;
    color: #1e293b;
  }

  .container span {
    font-size: 32px;
    margin-right: 10px;
  }

  .container i.mdi {
    font-size: 40px;
  }

  a.menu {
    text-align: left;
    margin: 0;
    padding: 8px;
    margin: 2px 8px;
    z-index: 50;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.2s ease;
  }

  a.menu:hover {
    background-color: rgba(37, 99, 235, 0.1);
  }

  div.container nav.navbar.show {
    display: flex;
    align-items: flex-start;
    align-self: flex-start;
    justify-content: flex-start;
    flex-direction: column;
    width: 100%;
    height: auto;
    text-align: left;
    position: absolute;
    z-index: 100;
    margin-top: 80px;
    padding: 0;
    transition: all 0.3s ease-in-out;
    border-bottom: 3px solid #2563eb;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .navbar .items-navigation {
    width: 100%;
  }

  .navbar .items-navigation ul.navbar-nav li.nav-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    width: 100%;
  }

  .navbar ul.navbar-nav li.nav-item .nav-link {
    font-size: 32px;
    text-decoration: none;
    padding: 15px 20px;
    display: block;
  }

  .navbar ul.navbar-nav li.nav-item .nav-link:hover {
    background-color: rgba(37, 99, 235, 0.05);
  }

  input.form-control {
    font-size: 18px;
    margin: 0;
    height: 50px;
  }

  div.container nav.navbar ul.navbar-nav {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .navbar .btn-sm.search i {
    color: white;
    font-size: 26px;
  }
}

@media (max-width: 768px) {
  div.container nav.navbar {
    height: 0;
    width: 0;
  }

  .navbar-brand i.mdi {
    font-size: 28px;
    padding: 2px 8px;
  }

  .container a.navbar-brand {
    background-color: transparent;
    display: inline-flex;
    align-items: center;
    align-self: center;
    flex-direction: row;
    font-size: 20px;
    margin-left: 50px;
    font-family: "Roboto Condensed";
    margin-top: 0px;
  }

  .navbar-brand span {
    display: inline-flex;
    font-weight: 700;
  }

  a.menu {
    text-align: left;
    margin: 0;
    padding: 6px;
    margin: 2px 6px;
    cursor: pointer;
  }

  div.container nav.navbar div.mx-auto,
  div.container nav.navbar div.mx-auto ul.navbar-nav {
    width: 100%;
  }

  nav.navbar .navbar-nav form#search .row .col-auto {
    float: left;
    width: 44%;
    margin: 12px 8px;
  }

  .navbar .items-navigation {
    width: 100%;
    position: relative;
  }

  div.container nav.navbar.show {
    align-items: flex-start;
    align-self: flex-start;
    justify-content: flex-start;
    flex-direction: column;
    width: 100%;
    height: auto;
    max-height: 80vh;
    overflow-y: auto;
    text-align: left;
    position: absolute;
    z-index: 100;
    margin-top: 5px;
    padding: 0;
    transition: all 0.3s ease-in-out;
    border-bottom: 3px solid #2563eb;
  }

  .navbar .items-navigation ul.navbar-nav li.nav-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  }

  .navbar ul.navbar-nav li.nav-item .nav-link {
    font-size: 24px;
    text-decoration: none;
    padding: 12px 18px;
  }

  input.form-control {
    height: 42px;
    width: 100%;
  }

  .container {
    background-color: #ffffff;
    position: fixed;
    padding: 8px 0;
    display: flex;
    z-index: 100;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .navbar .btn-sm.search i {
    color: white;
    font-size: 20px;
  }
}
</style>
