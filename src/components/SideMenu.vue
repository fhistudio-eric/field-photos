<template>
  <div
    class="
      bg-white/50
      backdrop-blur-lg
      h-full
      absolute
      transition-all
      duration-500
      flex flex-col
      z-50
      w-[360px]
    "
    :class="{ '-ml-[690px] ': menuShowing == false }"
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
          class="
            text-3xl
            mb-2
            hover:bg-blue-400
            duration-300
            transition-all
            w-full
            text-left
            p-2
            rounded-md
            flex
            items-center
          "
          :class="{
            'bg-blue-400 border-b-2 ': store.currentView == '/',
          }"
          @click="navigateTo('/')"
        >
          <HomeIcon class="text-gray-900 w-8 h-8 mr-2" />
          Home
        </button>
        <button
          class="
            text-3xl
            mb-2
            hover:bg-blue-400
            duration-300
            transition-all
            w-full
            text-left
            p-2
            rounded-md
            flex
          "
          :class="{
            'bg-blue-400 border-b-2 ': store.currentView == 'Viewer',
          }"
          @click="navigateTo('Viewer')"
        >
          <ViewGridIcon class="text-gray-900 w-8 h-8 mr-2" />

          Photo Viewer
        </button>
        <button
          class="
            text-3xl
            mb-2
            hover:bg-blue-400
            duration-300
            transition-all
            w-full
            text-left
            p-2
            rounded-md
            flex
          "
          :class="{
            'bg-blue-400 border-b-2 ': store.currentView == 'help',
          }"
          @click="navigateTo('help')"
        >
          <QuestionMarkCircleIcon class="text-gray-900 w-8 h-8 mr-2" />

          About & Help
        </button>
      </div>
      <div class="flex w-full items-center justify-center">
        <img src="../assets/logo_blue.png" class="w-8 mr-2" />
        <span class="font-extralight">Created by FHI Studio </span>
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
import { HomeIcon } from "@heroicons/vue/outline";
import { ViewGridIcon } from "@heroicons/vue/outline";
import { QuestionMarkCircleIcon } from "@heroicons/vue/outline";

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