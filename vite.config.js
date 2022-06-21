import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  base: "",
  // server: {
  //   origin: "http://localhost:3000",
  //   proxy: {
  //     '/phpmm': {
  //       // target: 'https://materials.fhistudio.com/',
  //       target: 'https://www.fhistudio-apps.com/',
  //       changeOrigin: true,
  //       secure: true,
  //       ws: false,
  //     }
  //   }
  // },
})