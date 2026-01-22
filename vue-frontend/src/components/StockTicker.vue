<template>
  <div class="stock-ticker-wrapper">
    <div class="stock-ticker">
      <div class="ticker-label">
        <i class="mdi mdi-chart-line"></i>
        <span>Mercados</span>
      </div>
      <div class="ticker-content">
        <div class="ticker-scroll">
          <div
            v-for="(stock, index) in stocks"
            :key="index"
            class="stock-item"
          >
            <span class="stock-name">{{ stock.symbol }}</span>
            <span class="stock-value">{{ formatNumber(stock.value) }}</span>
            <span
              class="stock-change"
              :class="stock.change >= 0 ? 'positive' : 'negative'"
            >
              <i :class="stock.change >= 0 ? 'mdi mdi-arrow-up' : 'mdi mdi-arrow-down'"></i>
              {{ formatPercent(stock.change) }}
            </span>
          </div>
        </div>
      </div>
      <div class="ticker-time">
        <i class="mdi mdi-clock-outline"></i>
        {{ currentTime }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "StockTicker",
  data() {
    return {
      currentTime: '',
      stocks: [
        { symbol: 'IBOV', value: 128450.32, change: 0.85 },
        { symbol: 'PETR4', value: 38.42, change: -1.23 },
        { symbol: 'VALE3', value: 67.89, change: 2.15 },
        { symbol: 'ITUB4', value: 32.56, change: 0.42 },
        { symbol: 'BBDC4', value: 14.23, change: -0.67 },
        { symbol: 'USD/BRL', value: 5.12, change: -0.34 },
        { symbol: 'EUR/BRL', value: 5.58, change: 0.21 },
        { symbol: 'BTC', value: 97850.00, change: 3.45 },
        { symbol: 'S&P 500', value: 5892.45, change: 0.67 },
        { symbol: 'NASDAQ', value: 19234.12, change: 1.12 },
      ]
    };
  },
  mounted() {
    this.updateTime();
    setInterval(this.updateTime, 1000);
    this.simulateMarket();
  },
  methods: {
    updateTime() {
      const now = new Date();
      this.currentTime = now.toLocaleTimeString('pt-BR', {
        hour: '2-digit',
        minute: '2-digit'
      });
    },
    formatNumber(value) {
      if (value >= 1000) {
        return value.toLocaleString('pt-BR', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }
      return value.toFixed(2);
    },
    formatPercent(value) {
      const sign = value >= 0 ? '+' : '';
      return `${sign}${value.toFixed(2)}%`;
    },
    simulateMarket() {
      setInterval(() => {
        this.stocks = this.stocks.map(stock => ({
          ...stock,
          value: stock.value * (1 + (Math.random() - 0.5) * 0.001),
          change: stock.change + (Math.random() - 0.5) * 0.1
        }));
      }, 5000);
    }
  }
};
</script>

<style scoped>
.stock-ticker-wrapper {
  width: 100%;
  background: linear-gradient(135deg, var(--dark, #0f172a) 0%, #1e293b 100%);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.stock-ticker {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  padding: 10px 20px;
  gap: 20px;
  overflow: hidden;
}

.ticker-label {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #f59e0b;
  font-weight: 600;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  white-space: nowrap;
  padding-right: 15px;
  border-right: 1px solid rgba(255, 255, 255, 0.2);
}

.ticker-label i {
  font-size: 18px;
}

.ticker-content {
  flex: 1;
  overflow: hidden;
  mask-image: linear-gradient(
    to right,
    transparent,
    black 5%,
    black 95%,
    transparent
  );
}

.ticker-scroll {
  display: flex;
  gap: 30px;
  animation: scroll 40s linear infinite;
}

.ticker-scroll:hover {
  animation-play-state: paused;
}

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.stock-item {
  display: flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
  padding: 4px 12px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 6px;
  transition: background 0.2s ease;
}

.stock-item:hover {
  background: rgba(255, 255, 255, 0.1);
}

.stock-name {
  color: #94a3b8;
  font-size: 12px;
  font-weight: 500;
}

.stock-value {
  color: #ffffff;
  font-size: 13px;
  font-weight: 600;
  font-family: 'Inter', monospace;
}

.stock-change {
  display: flex;
  align-items: center;
  gap: 2px;
  font-size: 12px;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 4px;
}

.stock-change.positive {
  color: #10b981;
  background: rgba(16, 185, 129, 0.15);
}

.stock-change.negative {
  color: #ef4444;
  background: rgba(239, 68, 68, 0.15);
}

.stock-change i {
  font-size: 12px;
}

.ticker-time {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #64748b;
  font-size: 13px;
  font-weight: 500;
  white-space: nowrap;
  padding-left: 15px;
  border-left: 1px solid rgba(255, 255, 255, 0.2);
}

.ticker-time i {
  font-size: 16px;
}

@media (max-width: 768px) {
  .stock-ticker {
    padding: 8px 12px;
  }

  .ticker-label {
    display: none;
  }

  .ticker-time {
    display: none;
  }

  .stock-item {
    padding: 3px 8px;
    gap: 6px;
  }

  .stock-name {
    font-size: 11px;
  }

  .stock-value {
    font-size: 12px;
  }

  .stock-change {
    font-size: 11px;
    padding: 1px 4px;
  }
}
</style>
