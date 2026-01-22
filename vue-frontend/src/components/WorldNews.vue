<template>
  <div class="world-news-widget">
    <div class="widget-header">
      <i class="mdi mdi-earth"></i>
      <span>World News</span>
    </div>

    <div class="news-list">
      <article
        v-for="(noticia, index) in news"
        :key="index"
        class="news-item"
      >
        <a :href="noticia.link" target="_blank" class="news-link">
          <div class="news-image" v-if="noticia.image_url">
            <img :src="noticia.image_url" :alt="noticia.title" />
          </div>
          <div class="news-content">
            <h4 class="news-title">{{ noticia.title }}</h4>
            <div class="news-meta">
              <span class="news-source">{{ noticia.source_name }}</span>
              <span class="news-date">{{ formatDate(noticia.pubDate) }}</span>
            </div>
          </div>
        </a>
      </article>
    </div>

    <div class="widget-footer" v-if="news.length > 0">
      <span>Powered by NewsData.io</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "WorldNews",
  data() {
    return {
      api_url: import.meta.env.VITE_API_URL,
      language: "en",
      category: "top",
      news: []
    };
  },
  mounted() {
    this.searchNewsWorld();
  },
  methods: {
    formatDate(date) {
      if (!date) return '';
      const options = {
        day: "2-digit",
        month: "short"
      };
      return new Intl.DateTimeFormat("en-US", options).format(new Date(date));
    },
    async searchNewsWorld() {
      try {
        const language = this.language;
        const category = this.category;
        const response = await fetch(
          `${this.api_url}/get-news.php?languages=${language}&categories=${category}`,
          {
            method: 'GET',
            credentials: 'include'
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
          throw new Error(datas.message || 'Unknown error');
        }

        if (datas && datas.results && datas.results.length > 0) {
          this.news = datas.results.slice(0, 5);
        }
      } catch (error) {
        console.error('Error fetching world news:', error);
      }
    }
  }
};
</script>

<style scoped>
.world-news-widget {
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

.widget-header {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 18px 20px;
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  color: #ffffff;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.widget-header i {
  font-size: 20px;
  color: #f59e0b;
}

.news-list {
  padding: 10px;
}

.news-item {
  border-bottom: 1px solid #f1f5f9;
}

.news-item:last-child {
  border-bottom: none;
}

.news-link {
  display: flex;
  gap: 12px;
  padding: 12px 10px;
  text-decoration: none;
  color: inherit;
  border-radius: 10px;
  transition: all 0.2s ease;
}

.news-link:hover {
  background: #f8fafc;
}

.news-image {
  width: 70px;
  height: 70px;
  border-radius: 8px;
  overflow: hidden;
  flex-shrink: 0;
}

.news-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.news-link:hover .news-image img {
  transform: scale(1.1);
}

.news-content {
  flex: 1;
  min-width: 0;
}

.news-title {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
  line-height: 1.4;
  margin: 0 0 8px 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: color 0.2s ease;
}

.news-link:hover .news-title {
  color: #f59e0b;
}

.news-meta {
  display: flex;
  flex-direction: column;
  gap: 2px;
  font-size: 11px;
  color: #64748b;
}

.news-source {
  font-weight: 500;
  color: #f59e0b;
}

.widget-footer {
  padding: 12px 20px;
  background: #f8fafc;
  text-align: center;
  font-size: 11px;
  color: #94a3b8;
}

@media (max-width: 1200px) {
  .world-news-widget {
    display: none;
  }
}
</style>
