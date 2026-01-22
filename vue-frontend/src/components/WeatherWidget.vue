<template>
  <div class="weather-widget">
    <div class="weather-header">
      <i class="mdi mdi-weather-partly-cloudy"></i>
      <span>Clima</span>
    </div>
    <div class="weather-main">
      <div class="weather-temp">
        <span class="temp-value">{{ weather.temp }}</span>
        <span class="temp-unit">°C</span>
      </div>
      <div class="weather-info">
        <span class="weather-condition">{{ weather.condition }}</span>
        <span class="weather-location">
          <i class="mdi mdi-map-marker"></i>
          {{ weather.city }}
        </span>
      </div>
    </div>
    <div class="weather-details">
      <div class="weather-detail">
        <i class="mdi mdi-water-percent"></i>
        <span>{{ weather.humidity }}%</span>
        <span class="detail-label">Umidade</span>
      </div>
      <div class="weather-detail">
        <i class="mdi mdi-weather-windy"></i>
        <span>{{ weather.wind }} km/h</span>
        <span class="detail-label">Vento</span>
      </div>
      <div class="weather-detail">
        <i class="mdi mdi-thermometer"></i>
        <span>{{ weather.feelsLike }}°</span>
        <span class="detail-label">Sensação</span>
      </div>
    </div>
    <div class="weather-forecast">
      <div
        v-for="(day, index) in forecast"
        :key="index"
        class="forecast-day"
      >
        <span class="forecast-name">{{ day.name }}</span>
        <i :class="'mdi ' + day.icon"></i>
        <span class="forecast-temp">{{ day.temp }}°</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "WeatherWidget",
  data() {
    return {
      weather: {
        temp: 28,
        condition: 'Parcialmente nublado',
        city: 'São Paulo',
        humidity: 65,
        wind: 12,
        feelsLike: 30
      },
      forecast: [
        { name: 'Seg', icon: 'mdi-weather-sunny', temp: 30 },
        { name: 'Ter', icon: 'mdi-weather-partly-cloudy', temp: 28 },
        { name: 'Qua', icon: 'mdi-weather-rainy', temp: 24 },
        { name: 'Qui', icon: 'mdi-weather-cloudy', temp: 26 },
        { name: 'Sex', icon: 'mdi-weather-sunny', temp: 29 }
      ]
    };
  }
};
</script>

<style scoped>
.weather-widget {
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  border-radius: 16px;
  padding: 20px;
  color: #ffffff;
  box-shadow: 0 10px 25px rgba(15, 23, 42, 0.3);
}

.weather-header {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0.9;
  margin-bottom: 15px;
}

.weather-header i {
  font-size: 20px;
}

.weather-main {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 20px;
}

.weather-temp {
  display: flex;
  align-items: flex-start;
}

.temp-value {
  font-size: 56px;
  font-weight: 300;
  line-height: 1;
}

.temp-unit {
  font-size: 20px;
  font-weight: 500;
  margin-top: 8px;
}

.weather-info {
  text-align: right;
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.weather-condition {
  font-size: 16px;
  font-weight: 500;
}

.weather-location {
  font-size: 13px;
  opacity: 0.8;
  display: flex;
  align-items: center;
  gap: 4px;
  justify-content: flex-end;
}

.weather-location i {
  font-size: 14px;
}

.weather-details {
  display: flex;
  justify-content: space-between;
  padding: 15px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.2);
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  margin-bottom: 15px;
}

.weather-detail {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}

.weather-detail i {
  font-size: 20px;
  opacity: 0.8;
}

.weather-detail span:nth-child(2) {
  font-size: 14px;
  font-weight: 600;
}

.detail-label {
  font-size: 11px;
  opacity: 0.7;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.weather-forecast {
  display: flex;
  justify-content: space-between;
}

.forecast-day {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}

.forecast-name {
  font-size: 12px;
  font-weight: 600;
  opacity: 0.8;
}

.forecast-day i {
  font-size: 22px;
}

.forecast-temp {
  font-size: 14px;
  font-weight: 600;
}

@media (max-width: 768px) {
  .weather-widget {
    display: none;
  }
}
</style>
