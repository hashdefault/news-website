<template>
  <section class="news-section">
    <!-- Featured Carousel -->
    <div class="featured-section">
      <div class="section-header">
        <h2>
          <i class="mdi mdi-fire"></i>
          Destaques
        </h2>
        <span class="section-badge">Mais lidas</span>
      </div>

      <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div
            v-for="(noticia, index) in news_slide"
            :key="index"
            :class="['carousel-item', { active: index === 0 }]"
          >
            <a :href="noticia.link" target="_blank" class="featured-card">
              <div class="featured-image">
                <img :src="noticia.image_url" :alt="noticia.title" />
                <div class="featured-overlay"></div>
              </div>
              <div class="featured-content">
                <span class="featured-source">
                  <i class="mdi mdi-newspaper-variant-outline"></i>
                  {{ noticia.source_name }}
                </span>
                <h3 class="featured-title">{{ noticia.title }}</h3>
                <p class="featured-description" v-if="noticia.description">
                  {{ truncateText(noticia.description, 120) }}
                </p>
                <span class="featured-date">
                  <i class="mdi mdi-clock-outline"></i>
                  {{ formatDate(noticia.pubDate) }}
                </span>
              </div>
            </a>
          </div>
        </div>

        <div class="carousel-indicators">
          <button
            v-for="(_, index) in news_slide"
            :key="index"
            type="button"
            data-bs-target="#newsCarousel"
            :data-bs-slide-to="index"
            :class="{ active: index === 0 }"
            :aria-label="'Notícia ' + (index + 1)"
          ></button>
        </div>

        <button class="carousel-control carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
          <i class="mdi mdi-chevron-left"></i>
        </button>
        <button class="carousel-control carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
          <i class="mdi mdi-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-wrapper">
      <!-- News List -->
      <div class="news-list-section">
        <div class="section-header">
          <h2>
            <i class="mdi mdi-format-list-bulleted"></i>
            Últimas Notícias
          </h2>
        </div>

        <div class="news-list">
          <article
            v-for="(noticia, index) in news"
            :key="index"
            class="news-item"
          >
            <span class="news-number">{{ String(index + 1).padStart(2, '0') }}</span>
            <div class="news-item-content">
              <a :href="noticia.link" target="_blank" class="news-item-title">
                {{ noticia.title }}
              </a>
              <div class="news-item-meta">
                <span class="news-source">{{ noticia.source_name }}</span>
                <span class="news-date">{{ formatDate(noticia.pubDate) }}</span>
              </div>
            </div>
          </article>
        </div>
      </div>

      <!-- Highlight Cards -->
      <div class="highlights-section">
        <div class="section-header">
          <h2>
            <i class="mdi mdi-star-outline"></i>
            Em Alta
          </h2>
        </div>

        <div class="highlights-grid">
          <article
            v-for="(noticia, index) in news_left"
            :key="index"
            class="highlight-card"
          >
            <a :href="noticia.link" target="_blank">
              <div class="highlight-image">
                <img :src="noticia.image_url" :alt="noticia.title" />
              </div>
              <div class="highlight-content">
                <span class="highlight-source">{{ noticia.source_name }}</span>
                <h4 class="highlight-title">{{ noticia.title }}</h4>
                <span class="highlight-date">{{ formatDate(noticia.pubDate) }}</span>
              </div>
            </a>
          </article>
        </div>
      </div>
    </div>

    <!-- Featured Article -->
    <div class="featured-article" v-if="new_unique">
      <div class="section-header">
        <h2>
          <i class="mdi mdi-bookmark-outline"></i>
          Leitura Recomendada
        </h2>
      </div>

      <article class="article-card">
        <div class="article-image">
          <img :src="new_unique.image_url" :alt="new_unique.title" />
        </div>
        <div class="article-content">
          <div class="article-meta">
            <span class="article-source">
              <i class="mdi mdi-newspaper-variant-outline"></i>
              {{ new_unique.source_name }}
            </span>
            <span class="article-date">
              <i class="mdi mdi-clock-outline"></i>
              {{ formatDate(new_unique.pubDate) }}
            </span>
          </div>
          <h3 class="article-title">{{ new_unique.title }}</h3>
          <p class="article-description">{{ new_unique.description }}</p>
          <a :href="new_unique.link" target="_blank" class="article-btn">
            <span>Ler matéria completa</span>
            <i class="mdi mdi-arrow-right"></i>
          </a>
        </div>
      </article>
    </div>
  </section>
</template>

<script>
export default {
  name: "HomeView",
  mounted() {
    this.searchNews();
  },
  data() {
    return {
      news: [],
      api_url: import.meta.env.VITE_API_URL,
      news_left: [],
      new_unique: null,
      category: "top",
      language: "pt",
      news_slide: []
    };
  },
  methods: {
    formatDate(date) {
      if (!date) return '';
      const options = {
        day: "2-digit",
        month: "short",
        hour: "2-digit",
        minute: "2-digit"
      };
      return new Intl.DateTimeFormat("pt-BR", options).format(new Date(date));
    },
    truncateText(text, maxLength) {
      if (!text) return '';
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength).trim() + '...';
    },
    async searchNews() {
      const loadingEl = document.getElementById('loading');
      if (loadingEl) loadingEl.style.display = "flex";

      const category = this.$route.name;
      const keywords = this.$route.query.q ? this.$route.query.q : '';
      const language = this.language;

      try {
        const response = await fetch(
          `${this.api_url}/get-news.php?languages=${language}&keywords=${keywords}&categories=${category}`,
          {
            method: "GET",
            credentials: "include"
          }
        );

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const datas = await response.json();

        if (datas.error) {
          console.warn('API Error:', datas.error);
          return;
        }

        if (datas.status === 'error') {
          throw new Error(datas.message || 'Erro desconhecido');
        }

        if (datas && datas.results && datas.results.length > 0) {
          const noticias = datas.results;
          this.news_slide = noticias.slice(0, 3);
          this.news = noticias.slice(3, 14);
          this.news_left = noticias.slice(14, 18);
          this.new_unique = noticias.slice(18, 19)[0] || null;
        }
      } catch (error) {
        console.error('Erro ao buscar notícias:', error);
      } finally {
        if (loadingEl) loadingEl.style.display = "none";
      }
    }
  },
  watch: {
    $route: {
      immediate: false,
      handler() {
        this.searchNews();
      }
    }
  }
};
</script>

<style scoped>
.news-section {
  width: 100%;
}

/* Section Headers */
.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  padding-bottom: 12px;
  border-bottom: 2px solid #e2e8f0;
}

.section-header h2 {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: 'Playfair Display', serif;
  font-size: 22px;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.section-header h2 i {
  color: #f59e0b;
  font-size: 24px;
}

.section-badge {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: #ffffff;
  font-size: 11px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Featured Carousel */
.featured-section {
  margin-bottom: 35px;
}

.carousel {
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
}

.featured-card {
  display: block;
  position: relative;
  text-decoration: none;
  color: inherit;
}

.featured-image {
  position: relative;
  height: 380px;
  overflow: hidden;
}

.featured-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.featured-card:hover .featured-image img {
  transform: scale(1.05);
}

.featured-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 70%;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
}

.featured-content {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 30px;
  color: #ffffff;
}

.featured-source {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  margin-bottom: 12px;
}

.featured-title {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  font-weight: 700;
  line-height: 1.3;
  margin-bottom: 10px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.featured-description {
  font-size: 15px;
  line-height: 1.5;
  opacity: 0.9;
  margin-bottom: 12px;
}

.featured-date {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  opacity: 0.8;
}

/* Carousel Controls */
.carousel-indicators {
  position: relative;
  margin: 15px 0;
}

.carousel-indicators button {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #cbd5e1;
  border: none;
  margin: 0 5px;
  transition: all 0.3s ease;
}

.carousel-indicators button.active {
  width: 30px;
  border-radius: 10px;
  background: #f59e0b;
}

.carousel-control {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 45px;
  height: 45px;
  background: rgba(255, 255, 255, 0.95);
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  z-index: 10;
}

.carousel-control:hover {
  background: #f59e0b;
  color: #ffffff;
}

.carousel-control i {
  font-size: 24px;
  color: #1e293b;
}

.carousel-control:hover i {
  color: #ffffff;
}

.carousel-control-prev {
  left: 20px;
}

.carousel-control-next {
  right: 20px;
}

/* Content Wrapper */
.content-wrapper {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
  margin-bottom: 35px;
}

/* News List */
.news-list-section {
  background: #ffffff;
  border-radius: 16px;
  padding: 25px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

.news-list {
  display: flex;
  flex-direction: column;
}

.news-item {
  display: flex;
  gap: 15px;
  padding: 16px 0;
  border-bottom: 1px solid #f1f5f9;
  transition: all 0.2s ease;
}

.news-item:last-child {
  border-bottom: none;
}

.news-item:hover {
  padding-left: 10px;
}

.news-number {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 700;
  color: #e2e8f0;
  min-width: 35px;
}

.news-item:hover .news-number {
  color: #f59e0b;
}

.news-item-content {
  flex: 1;
}

.news-item-title {
  display: block;
  font-size: 15px;
  font-weight: 600;
  color: #1e293b;
  text-decoration: none;
  line-height: 1.4;
  margin-bottom: 8px;
  transition: color 0.2s ease;
}

.news-item-title:hover {
  color: #f59e0b;
}

.news-item-meta {
  display: flex;
  gap: 12px;
  font-size: 12px;
  color: #64748b;
}

.news-source {
  font-weight: 500;
}

/* Highlights Grid */
.highlights-section {
  background: #ffffff;
  border-radius: 16px;
  padding: 25px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

.highlights-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.highlight-card {
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.highlight-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.highlight-card a {
  text-decoration: none;
  color: inherit;
  display: block;
}

.highlight-image {
  height: 130px;
  overflow: hidden;
}

.highlight-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.highlight-card:hover .highlight-image img {
  transform: scale(1.1);
}

.highlight-content {
  padding: 15px;
  background: #f8fafc;
}

.highlight-source {
  font-size: 11px;
  font-weight: 600;
  color: #f59e0b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.highlight-title {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
  line-height: 1.4;
  margin: 8px 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.highlight-date {
  font-size: 11px;
  color: #64748b;
}

/* Featured Article */
.featured-article {
  margin-bottom: 30px;
}

.article-card {
  display: grid;
  grid-template-columns: 1fr 1fr;
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

.article-image {
  height: 300px;
  overflow: hidden;
}

.article-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.article-card:hover .article-image img {
  transform: scale(1.05);
}

.article-content {
  padding: 30px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.article-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 15px;
}

.article-source,
.article-date {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #64748b;
}

.article-source i,
.article-date i {
  color: #f59e0b;
}

.article-title {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
  line-height: 1.3;
  margin-bottom: 15px;
}

.article-description {
  font-size: 15px;
  color: #475569;
  line-height: 1.6;
  margin-bottom: 20px;
}

.article-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #f59e0b;
  color: #ffffff;
  text-decoration: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  transition: all 0.2s ease;
  width: fit-content;
}

.article-btn:hover {
  background: #d97706;
  transform: translateX(5px);
}

.article-btn i {
  transition: transform 0.2s ease;
}

.article-btn:hover i {
  transform: translateX(3px);
}

/* Responsive */
@media (max-width: 1024px) {
  .content-wrapper {
    grid-template-columns: 1fr;
  }

  .article-card {
    grid-template-columns: 1fr;
  }

  .article-image {
    height: 200px;
  }

  .featured-image {
    height: 300px;
  }

  .featured-title {
    font-size: 24px;
  }
}

@media (max-width: 768px) {
  .section-header h2 {
    font-size: 18px;
  }

  .featured-image {
    height: 250px;
  }

  .featured-content {
    padding: 20px;
  }

  .featured-title {
    font-size: 20px;
  }

  .featured-description {
    display: none;
  }

  .highlights-grid {
    grid-template-columns: 1fr;
  }

  .news-list-section,
  .highlights-section {
    padding: 20px;
  }

  .carousel-control {
    width: 36px;
    height: 36px;
  }

  .carousel-control i {
    font-size: 20px;
  }

  .article-content {
    padding: 20px;
  }

  .article-title {
    font-size: 20px;
  }

  .article-btn {
    width: 100%;
    justify-content: center;
  }
}
</style>
