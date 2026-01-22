<template>
  <section>
    <div class="right-news with-images">
      <h4>No mundo</h4>
      <ul>
        <li class="list-notice-img" v-for="(noticia_lista_img, index) in news" :key="index">
          <a class="link_url" :href="noticia_lista_img.link">
            <img :src="noticia_lista_img.image_url" />
            <p class="data_info">
              Fonte: {{ noticia_lista_img.source_name }}<br>
              {{ formatDate(noticia_lista_img.pubDate) }}
            </p>
            <br />
            <p class="data_info_title">{{ noticia_lista_img.title }}</p>
          </a>
        </li>
      </ul>
    </div>
  </section>
</template>
<script>
export default {
  name: "WorldNews",
  mounted() {
    this.searchNewsWorld();
  },
  data() {
    return {
      news: [],
      api_url: import.meta.env.VITE_API_URL,
      language: "en",
      category: 'top'
    };
  },
  methods: {
    formatDate(date) {
      const options = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      };
      return new Intl.DateTimeFormat("en-GB", options).format(new Date(date));
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
          throw new Error(datas.message || 'Erro desconhecido');
        }

        if (datas && datas.results && datas.results.length > 0) {
          const noticias = datas.results;
          this.news = noticias.slice(0, 5);
        }
      } catch (error) {
        console.error('Erro ao buscar notícias mundiais:', error);
      }
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jersey+25&family=Markazi+Text:wght@400..700&family=Roboto+Slab:wght@100..900&family=VT323&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");

section {
  display: flex;
  justify-content: flex-start;
  margin-left: 0px;
  border-right: none;
  margin-top: 40px;
  padding-right: 15px;
}

p.data_info_title:hover {
  text-decoration: none;
  color: #2563eb;
}

p.data_info_title {
  line-height: 1.2em;
  float: left;
  margin-left: 5px;
  max-width: 200px;
  font-size: 16px;
  width: 90%;
  margin-top: -12px;
  color: #1e293b;
  transition: color 0.2s ease;
}

h4 {
  font-family: "Markazi Text", serif;
  margin-left: 15px;
  font-size: 26px;
  border-left: 4px solid #2563eb;
  color: #1e293b;
  padding-left: 12px;
  height: auto;
  display: flex;
  align-items: center;
  align-self: center;
  margin-bottom: 15px;
}

p.data_info {
  float: left;
  margin-left: 5px;
  max-width: 200px;
  color: #64748b;
  font-family: "Roboto Condensed";
  font-size: 11px;
}

.right-news ul li {
  overflow: hidden;
  padding: 12px 8px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  transition: background-color 0.2s ease;
}

.right-news ul li:hover {
  background-color: rgba(37, 99, 235, 0.03);
}

.right-news ul li:last-child {
  border-bottom: none;
}

.right-news ul {
  height: 100%;
  overflow: hidden;
  padding: 0;
}

.right-news {
  font-family: "Markazi Text", serif;
  width: 100%;
  float: left;
  background: #fafbfc;
  border-radius: 12px;
  padding: 15px;
}

.list-notice-img:hover {
  text-decoration: none;
}

.list-notice-img a.link_url {
  display: block;
  text-decoration: none;
  color: #1e293b;
  padding: 4px 0;
  font-size: 17px;
  overflow: hidden;
}

.list-notice-img img {
  border-radius: 8px;
  float: left;
  width: 130px;
  height: 80px;
  object-fit: cover;
  margin-right: 10px;
  transition: transform 0.2s ease;
}

.list-notice-img:hover img {
  transform: scale(1.03);
}

.list-notice-img {
  list-style-type: none;
  text-decoration: none;
  color: #1e293b;
  padding: 5px 0;
  width: 100%;
}

.list-notice .link_url:hover {
  color: #2563eb;
}

.list-notice .link_url {
  color: #1e293b;
  text-decoration: none;
  width: 100%;
  transition: color 0.2s ease;
}

.link-rounded img {
  border: none;
  border-radius: 8px;
}

@media (max-width: 1024px) {
  section {
    display: block;
    padding: 0;
    margin-top: 20px;
    width: 100%;
  }

  section .right-news {
    display: block;
    padding: 10px;
    margin: 0;
    width: 100%;
  }
}

@media (max-width: 768px) {
  section {
    display: block;
    width: 100%;
    padding-right: 0;
  }

  section .right-news {
    display: block;
    width: 100%;
    border-radius: 10px;
  }

  h4 {
    font-size: 24px;
    margin-left: 10px;
  }

  .list-notice-img img {
    width: 100px;
    height: 65px;
  }
}
</style>
