<template>
  <section>
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-inner">
        <div v-for="(noticia, index) in news_slide" :key="index" :class="['carousel-item', { active: index === 0 }]">
          <a :href="noticia.link" class="link-rounded">
            <img :src="noticia.image_url" class="slide_image" alt="..." />
          </a>
          <div class="text-center">
            <h5>{{ noticia.title }}</h5>
          </div>
        </div>
      </div>
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Noticia 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
          aria-label="Noticia 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
          aria-label="Noticia 3"></button>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div class="container-geral">
      <div class="left-news no-images">
        <h4 class='leia'>Leia também:</h4>
        <ul>
          <li class="list-notice" v-for="(noticia_lista, index) in news" :key="index">
            <a class="link_url" :href="noticia_lista.link">
              {{ noticia_lista.title }}</a>
          </li>
          <hr class='hr-extra'>
        </ul>
        <div class='conteudo-extra'>
          <h4 class='unique'>{{ new_unique.title }}</h4>
          <img class='img_extra' :src='new_unique.image_url'>
          <article>
            <p>
              <span class='subtitle'>
                Fonte: {{ new_unique.source_name }} <br>
                {{ formatDate(new_unique.pubDate) }}
              </span><br>
              {{ new_unique.description }}
            </p>
            <a :href='new_unique.link' target='_blank' class='btn  leia_mais'><i class='mdi mdi-plus'></i>Leia
              mais</a>
          </article>

        </div>
      </div>
      <div class="right-news with-images">
        <ul>
          <h4 class='destaques'>Destaques</h4>
          <li class="list-notice-img" v-for="(noticia_lista_img, index) in news_left" :key="index">
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
      new_unique: '',
      category: "top",
      language: "pt",
      news_slide: [],
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
            credentials: "include",
          },
        );

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const datas = await response.json();

        if (datas.error) {
          console.warn('API Error:', datas.error);
          this.$emit('api-error', datas.error);
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
        } else {
          console.warn('Nenhuma notícia encontrada');
        }
      } catch (error) {
        console.error('Erro ao buscar notícias:', error);
      } finally {
        if (loadingEl) loadingEl.style.display = "none";
      }
    },
  },
  watch: {
    $route: {
      immediate: false,
      handler() {
        this.searchNews();
      },
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jersey+25&family=Markazi+Text:wght@400..700&family=Roboto+Slab:wght@100..900&family=VT323&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");

.container-geral {
  width: 100%;
  font-family: "Markazi Text", serif;
  min-height: 100vh;
  padding: 0 10px;
}

section {
  width: 80%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-self: center;
  align-items: center;
  float: left;
}

.hr-extra {
  margin-top: 30px;
  border-color: rgba(0, 0, 0, 0.1);
}

.conteudo-extra {
  margin-top: 50px;
  width: 95%;
  margin-left: 20px;
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.conteudo-extra p .subtitle {
  font-size: 13px;
  line-height: 1.0em;
  font-family: "Roboto Condensed";
  color: rgba(0, 0, 0, 0.6);
}

.conteudo-extra p {
  font-size: 20px;
  line-height: 1.5em;
  color: #333;
}

.img_extra {
  border-radius: 10px;
  width: 100%;
  max-width: 400px;
  object-fit: cover;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease;
}

.img_extra:hover {
  transform: scale(1.02);
}

h4.destaques {
  font-size: 28px;
  margin-left: 20px;
  padding-left: 15px;
  border-left: 4px solid #2563eb;
  color: #1e293b;
  height: auto;
  display: flex;
  align-items: center;
  align-self: center;
  margin-bottom: 20px;
}

h4.unique {
  font-size: 26px;
  margin-left: 0;
  padding-left: 15px;
  border-left: 4px solid #2563eb;
  color: #1e293b;
  display: flex;
  align-items: center;
  align-self: flex-start;
  margin-bottom: 15px;
}

h4.leia {
  font-size: 32px;
  margin-left: 20px;
  padding-left: 15px;
  border-left: 4px solid #2563eb;
  color: #1e293b;
  height: auto;
  display: flex;
  align-items: center;
  align-self: center;
  margin-bottom: 20px;
}

h5.title-extra {
  font-size: 25px;
  text-align: left;
  color: #1e293b;
  margin-left: 0;
  padding-left: 10px;
}

h5 {
  font-family: "Markazi Text", serif;
  font-size: 24px;
  padding: 0px 40px;
  text-align: left;
  color: #1e293b;
  line-height: 1.3;
}

p.data_info_title:hover {
  text-decoration: underline;
  color: #2563eb;
}

p.data_info_title {
  line-height: 1.2em;
  float: left;
  margin-left: 5px;
  max-width: 200px;
  font-family: "Markazi Text", serif;
  font-size: 17px;
  width: 100%;
  margin-top: -8px;
  color: #1e293b;
  transition: color 0.2s ease;
}

p.data_info {
  float: left;
  margin-left: 5px;
  max-width: 100px;
  color: #64748b;
  font-family: "Roboto Condensed";
  font-size: 12px;
}

.container-geral .left-news {
  width: 64%;
  float: left;
}

.right-news ul li {
  overflow: hidden;
  padding: 15px 10px;
  border-right: none;
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  transition: background-color 0.2s ease;
}

.right-news ul li:hover {
  background-color: rgba(37, 99, 235, 0.03);
}

.right-news ul {
  height: 100%;
  overflow: hidden;
  padding: 0;
}

.container-geral .right-news {
  width: 36%;
  display: block;
  float: left;
  background: #fafbfc;
  border-radius: 12px;
  padding: 15px;
  margin-left: 10px;
}

.list-notice-img:hover {
  text-decoration: none;
}

.list-notice-img a.link_url {
  display: block;
  text-decoration: none;
  color: #1e293b;
  padding: 5px 0;
  font-size: 18px;
  overflow: hidden;
}

.list-notice-img img {
  border-radius: 8px;
  float: left;
  width: 180px;
  height: 100px;
  object-fit: cover;
  margin-right: 12px;
  transition: transform 0.2s ease;
}

.list-notice-img:hover img {
  transform: scale(1.03);
}

.list-notice-img {
  list-style-type: none;
  text-decoration: none;
  color: #1e293b;
  padding: 8px 0;
  width: 100%;
}

.list-notice-img .link_url {
  border-bottom: none;
}

.list-notice .link_url:hover {
  text-decoration: none;
  color: #2563eb;
}

a.leia_mais:hover {
  background-color: #2563eb;
  border-color: #2563eb;
  color: white;
  transform: translateY(-2px);
}

a.leia_mais {
  font-size: 15px;
  font-family: "Roboto Condensed";
  font-weight: 600;
  border: 2px solid #1e293b;
  border-radius: 6px;
  padding: 10px 20px;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

.list-notice .link_url {
  color: #1e293b;
  text-decoration: none;
  width: 100%;
  transition: color 0.2s ease;
}

.list-notice {
  list-style-type: none;
  text-align: left;
  font-size: 19px;
  padding: 8px 0px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  transition: background-color 0.2s ease;
}

.list-notice:hover {
  background-color: rgba(37, 99, 235, 0.03);
  padding-left: 10px;
}

#carouselExampleCaptions .slide_image {
  height: 280px;
  margin-bottom: 15px;
  border-radius: 12px;
  object-fit: cover;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease;
}

#carouselExampleCaptions .slide_image:hover {
  transform: scale(1.02);
}

.carousel-inner {
  text-align: center;
}

.link-rounded img {
  border: none;
  border-radius: 12px;
}

div.carousel-indicators {
  position: relative;
  margin-top: 10px;
}

div.carousel-indicators button.active {
  background-color: #2563eb;
  width: 30px;
}

#carouselExampleCaptions {
  width: 60%;
  float: left;
}

div.carousel-indicators button {
  background-color: #cbd5e1;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin: 0 5px;
  transition: all 0.3s ease;
}

div.carousel button.carousel-control-prev span.carousel-control-prev-icon,
div.carousel button.carousel-control-next span.carousel-control-next-icon {
  background-color: rgba(30, 41, 59, 0.4);
  border-radius: 50%;
  padding: 20px;
}

section .container-geral i.mdi {
  font-size: 18px;
}

@media (max-width: 1024px) {
  section {
    width: 100%;
    margin: 0px;
    padding: 0px 10px;
    display: flex;
    flex-direction: column;
  }

  .container-geral {
    width: 100%;
    height: auto;
    margin: 0;
    padding: 0 5px;
  }

  #carouselExampleCaptions .slide_image {
    width: 100%;
    height: 220px;
  }

  .container-geral .left-news {
    margin: 5px;
    padding: 0;
    float: left;
    width: 55%;
  }

  .container-geral .right-news {
    width: 40%;
    padding: 10px;
    margin: 0;
    float: left;
    margin-left: 5px;
  }

  h4.destaques,
  h4.leia {
    font-size: 24px;
  }
}

@media (max-width: 768px) {
  section {
    width: 100%;
    margin: 0px;
    padding: 0px 15px;
    display: flex;
    flex-direction: column;
  }

  .container-geral {
    width: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    align-self: flex-start;
  }

  #carouselExampleCaptions .slide_image {
    width: 100%;
    height: auto;
    border-radius: 10px;
  }

  .container-geral .left-news li {
    margin-left: 10px;
    line-height: 1.3em;
    list-style-type: none;
  }

  .container-geral .left-news {
    width: 100%;
    margin: 5px 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    align-self: flex-start;
  }

  .container-geral .right-news li {
    border: none;
    margin: 10px 5px;
    padding: 10px;
  }

  .container-geral .right-news ul {
    display: block;
    padding: 0;
    margin: 0;
  }

  .container-geral .left-news ul {
    display: block;
    padding: 0;
    margin: 0;
  }

  .container-geral .right-news {
    width: 100%;
    margin: 0;
    margin-top: 30px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    align-self: flex-start;
    border-radius: 12px;
    margin-left: 0;
  }

  p.data_info_title {
    margin-top: 0;
    max-width: 100%;
  }

  #carouselExampleCaptions {
    width: 100%;
    display: block;
  }

  div.carousel .text-center h5 {
    width: 100%;
    display: block;
    padding: 10px 15px;
    font-size: 20px;
  }

  h4.leia {
    font-size: 28px;
    border-left: 4px solid #2563eb;
    color: #1e293b;
    height: auto;
    margin: 0;
    margin-top: 20px;
    width: 100%;
    padding-left: 12px;
  }

  h4.destaques {
    font-size: 26px;
    margin-left: 0;
  }

  .conteudo-extra {
    width: 100%;
    display: block;
    padding: 20px;
    margin: 20px 0;
  }

  .img_extra {
    width: 100%;
    max-width: 100%;
  }

  .list-notice-img img {
    width: 120px;
    height: 80px;
  }

  a.leia_mais {
    width: 100%;
    justify-content: center;
  }
}
</style>
