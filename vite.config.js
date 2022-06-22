import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  base: "https://www.fhistudio-apps.com/fieldphotos",
  // base: "",
  server: {
    origin: "http://localhost:3000",
    proxy: {
      '/php': {
        target: 'https://www.fhistudio-apps.com/fieldphotos',
        changeOrigin: true,
        secure: false,
        ws: false,
      }
    }
  },
})