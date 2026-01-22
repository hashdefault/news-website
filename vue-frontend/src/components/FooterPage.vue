<template>
  <div class="container container-footer">
    <h5>
      Inscreva-se para receber a nossa newsletter
      <i class="mdi mdi-coffee"></i>
    </h5>
    <form @submit.prevent="receberForm" action="" method="post" name="newsletter_form" id='newsletter_form'>
      <div class="container content">
        <div class="row">
          <div class='col-md-7 mx-auto'>
            <div class='form-group'>
              <label class='form-label'>Email
              </label>
              <input class="form-control" id="email" name="email" type="email" />
            </div>
          </div>
          <div class='row'>
            <div class='col-md-2 mx-auto'>
              <button class="btn cadastrar_news btn-sm" type='submit'>
                <i class="mdi mdi-check"></i><span class='btn-span'> Cadastrar</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <p class='rights'>© {{ year }} All rights reserved</p>
</template>
<script>
export default {
  name: "FooterPage",
  data() {
    return {
      year: new Date().getFullYear(),
    };
  },
  methods: {
    receberForm() {
      sessionStorage.setItem("subscribed", true);
      location.href = location.href
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Jersey+25&family=Markazi+Text:wght@400..700&family=Roboto+Slab:wght@100..900&family=VT323&display=swap");

hr {
  width: 70%;
  text-align: center;
  align-items: center;
  align-self: center;
  justify-content: center;
  border-color: #e2e8f0;
}

h5 {
  text-align: center;
  width: 100%;
  font-size: 32px;
  font-family: "Markazi Text", serif;
  color: #1e293b;
}

p {
  text-align: center;
  align-items: center;
  align-self: center;
  justify-content: center;
  font-family: "Markazi Text", serif;
  font-size: 16px;
}

.container-footer #newsletter_form .col-md-7 {
  text-align: left;
}

.container-footer i.mdi {
  font-size: 18px;
  color: #2563eb;
}

.container-footer #newsletter_form {
  width: 100%;
  max-width: 600px;
  margin: 25px auto 60px auto;
  border: none;
  border-radius: 16px;
  padding: 30px;
  background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.rights {
  width: 100%;
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: #94a3b8;
  margin: 0;
  padding: 25px;
  font-size: 14px;
}

.container-footer {
  width: 100%;
  margin-top: 60px;
  flex-direction: column;
  padding: 0 20px;
}

.btn-span {
  font-weight: 600;
}

.btn.cadastrar_news:hover {
  background-color: #2563eb;
  border-color: #2563eb;
  color: white;
  transform: translateY(-2px);
}

.btn.cadastrar_news {
  border: 2px solid #1e293b;
  border-radius: 8px;
  display: flex;
  align-items: center;
  padding: 10px 24px;
  font-family: "Roboto Condensed";
  transition: all 0.3s ease;
}

.row {
  margin-top: 12px;
}

input.form-control:focus {
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  border-color: #2563eb;
}

input.form-control {
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 12px 16px;
  font-size: 15px;
}

label.form-label {
  font-family: "Roboto Condensed";
  font-weight: 500;
  color: #475569;
  margin-bottom: 6px;
}

@media (max-width: 768px) {
  .container .container-footer {
    display: block;
  }

  .container .container-footer #newsletter_form {
    display: block;
    padding: 20px;
    margin: 20px 10px 40px 10px;
  }

  h5 {
    font-size: 26px;
  }

  .btn.cadastrar_news {
    width: 100%;
    justify-content: center;
  }

  .rights {
    padding: 20px;
    font-size: 13px;
  }
}
</style>
