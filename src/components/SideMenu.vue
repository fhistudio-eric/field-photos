<template>
  <div
    class="
      bg-white/50
      backdrop-blur-lg
      h-full
      w-full
      absolute
      transition-all
      duration-500
      flex flex-col
      z-50
    "
    :class="{ '-ml-[420px]': menuShowing == false }"
  >
    <div class="flex justify-between items-center p-4">
      <div
        class="
          font-extrabold
          text-transparent text-4xl
          bg-clip-text bg-gradient-to-r
          from-blue-400
          to-green-600
          hover:from-green-400 hover:to-blue-600
        "
      >
        Menu
      </div>
      <XIcon
        class="text-gray-900 w-10 h-10 mt-0 mr-0 cursor-pointer"
        @click="showMenu"
      />
    </div>

    <div class="w-full mt-2 p-4 flex-grow flex flex-col justify-between">
      <div class="flex flex-col items-start">
        <button
          class="text-3xl mb-3 hover:translate-x-2 duration-300 transition-all"
          :class="{ underline: store.currentView == '/' }"
          @click="navigateTo('/')"
        >
          Home
        </button>
        <button
          class="text-3xl mb-3 hover:translate-x-2 duration-300 transition-all"
          :class="{ underline: store.currentView == 'Viewer' }"
          @click="navigateTo('Viewer')"
        >
          Photo Viewer
        </button>
        <button
          class="text-3xl mb-3 hover:translate-x-2 duration-300 transition-all"
          :class="{ underline: store.currentView == 'help' }"
          @click="navigateTo('help')"
        >
          About & Help
        </button>
      </div>
      <div class="flex w-full items-center justify-center">
        <img src="../assets/logo_blue.png" class="w-8 mr-2" />
        <span class="font-bold">Created by FHI Studio </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "../store";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

import { XIcon } from "@heroicons/vue/outline";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const props = defineProps({
  menuShowing: Boolean,
});

const emit = defineEmits(["showMenu"]);

const showMenu = () => {
  emit("showMenu");
};

const navigateTo = (to) => {
  store.currentView = to;
  router.push(to);
  emit("showMenu");
};
</script>