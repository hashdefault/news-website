<template>
  <div class="footer-wrapper">
    <!-- Newsletter Section -->
    <div class="newsletter-section">
      <div class="newsletter-content">
        <div class="newsletter-text">
          <i class="mdi mdi-email-newsletter"></i>
          <div>
            <h3>Receba as principais notícias</h3>
            <p>Cadastre-se e receba um resumo diário das notícias mais importantes.</p>
          </div>
        </div>
        <form @submit.prevent="receberForm" class="newsletter-form">
          <input
            v-model="email"
            type="email"
            placeholder="Seu melhor e-mail"
            required
          />
          <button type="submit">
            <i class="mdi mdi-send"></i>
            <span>Inscrever</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
      <div class="footer-content">
        <!-- Brand -->
        <div class="footer-brand">
          <div class="brand-logo">
            <i class="mdi mdi-newspaper-variant-outline"></i>
            <span>News Portal</span>
          </div>
          <p class="brand-description">
            Seu portal de notícias com informações atualizadas 24 horas por dia,
            cobrindo os principais acontecimentos do Brasil e do mundo.
          </p>
          <div class="social-links">
            <a href="#" aria-label="Twitter"><i class="mdi mdi-twitter"></i></a>
            <a href="#" aria-label="Facebook"><i class="mdi mdi-facebook"></i></a>
            <a href="#" aria-label="Instagram"><i class="mdi mdi-instagram"></i></a>
            <a href="#" aria-label="YouTube"><i class="mdi mdi-youtube"></i></a>
          </div>
        </div>

        <!-- Links -->
        <div class="footer-links">
          <div class="links-column">
            <h4>Categorias</h4>
            <ul>
              <li><router-link to="/">Início</router-link></li>
              <li><router-link to="/politics">Política</router-link></li>
              <li><router-link to="/business">Negócios</router-link></li>
              <li><router-link to="/technology">Tecnologia</router-link></li>
            </ul>
          </div>
          <div class="links-column">
            <h4>Mais Seções</h4>
            <ul>
              <li><router-link to="/sports">Esportes</router-link></li>
              <li><router-link to="/entertainment">Entretenimento</router-link></li>
              <li><router-link to="/science">Ciência</router-link></li>
              <li><router-link to="/health">Saúde</router-link></li>
            </ul>
          </div>
          <div class="links-column">
            <h4>Institucional</h4>
            <ul>
              <li><a href="#">Sobre Nós</a></li>
              <li><a href="#">Contato</a></li>
              <li><a href="#">Política de Privacidade</a></li>
              <li><a href="#">Termos de Uso</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="footer-bottom">
        <p>&copy; {{ year }} News Portal. Todos os direitos reservados.</p>
        <p class="powered-by">
          Powered by <a href="https://newsdata.io" target="_blank">NewsData.io</a>
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: "FooterPage",
  data() {
    return {
      year: new Date().getFullYear(),
      email: ''
    };
  },
  methods: {
    receberForm() {
      if (this.email) {
        sessionStorage.setItem("subscribed", true);
        this.email = '';
        location.reload();
      }
    }
  }
};
</script>

<style scoped>
.footer-wrapper {
  margin-top: 60px;
}

/* Newsletter Section */
.newsletter-section {
  background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
  padding: 40px 20px;
}

.newsletter-content {
  max-width: 1000px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
}

.newsletter-text {
  display: flex;
  align-items: center;
  gap: 20px;
  color: #ffffff;
}

.newsletter-text i {
  font-size: 48px;
  opacity: 0.9;
}

.newsletter-text h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 5px 0;
}

.newsletter-text p {
  font-size: 14px;
  opacity: 0.9;
  margin: 0;
}

.newsletter-form {
  display: flex;
  gap: 10px;
  flex-shrink: 0;
}

.newsletter-form input {
  padding: 14px 20px;
  border: none;
  border-radius: 10px;
  font-size: 15px;
  width: 280px;
  background: rgba(255, 255, 255, 0.95);
}

.newsletter-form input:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

.newsletter-form button {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 14px 24px;
  background: #0f172a;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
}

.newsletter-form button:hover {
  background: #1e293b;
  transform: translateY(-2px);
}

.newsletter-form button i {
  font-size: 18px;
}

/* Main Footer */
.main-footer {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  color: #94a3b8;
  padding: 60px 20px 0;
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1.5fr 2fr;
  gap: 60px;
  padding-bottom: 40px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Brand */
.footer-brand {
  max-width: 350px;
}

.brand-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #ffffff;
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 15px;
}

.brand-logo i {
  font-size: 32px;
  color: #f59e0b;
}

.brand-description {
  font-size: 14px;
  line-height: 1.7;
  margin-bottom: 20px;
}

.social-links {
  display: flex;
  gap: 12px;
}

.social-links a {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  color: #94a3b8;
  font-size: 20px;
  transition: all 0.2s ease;
}

.social-links a:hover {
  background: #f59e0b;
  color: #ffffff;
  transform: translateY(-3px);
}

/* Links */
.footer-links {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
}

.links-column h4 {
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  margin: 0 0 20px 0;
}

.links-column ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.links-column li {
  margin-bottom: 12px;
}

.links-column a {
  color: #94a3b8;
  text-decoration: none;
  font-size: 14px;
  transition: all 0.2s ease;
}

.links-column a:hover {
  color: #ffffff;
  padding-left: 5px;
}

/* Bottom Bar */
.footer-bottom {
  max-width: 1200px;
  margin: 0 auto;
  padding: 25px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
}

.footer-bottom p {
  margin: 0;
}

.powered-by a {
  color: #f59e0b;
  text-decoration: none;
}

.powered-by a:hover {
  text-decoration: underline;
}

/* Responsive */
@media (max-width: 1024px) {
  .newsletter-content {
    flex-direction: column;
    text-align: center;
  }

  .newsletter-text {
    flex-direction: column;
  }

  .newsletter-form {
    width: 100%;
    max-width: 400px;
  }

  .newsletter-form input {
    flex: 1;
    width: auto;
  }

  .footer-content {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .footer-brand {
    max-width: 100%;
    text-align: center;
  }

  .social-links {
    justify-content: center;
  }

  .footer-links {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 768px) {
  .newsletter-section {
    padding: 30px 15px;
  }

  .newsletter-text h3 {
    font-size: 20px;
  }

  .newsletter-text i {
    font-size: 36px;
  }

  .newsletter-form {
    flex-direction: column;
  }

  .newsletter-form input,
  .newsletter-form button {
    width: 100%;
  }

  .footer-links {
    grid-template-columns: 1fr;
    gap: 30px;
    text-align: center;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }

  .main-footer {
    padding: 40px 15px 0;
  }
}
</style>
