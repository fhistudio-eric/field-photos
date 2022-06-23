<template>
  <div
    class="
      absolute
      inset-0
      bg-gray-100
      md:container md:mx-auto md:w-[360px]
      overflow-hidden
    "
  >
    <SideMenu :menuShowing="menuShowing" @showMenu="showMenu" />
    <router-view @showMenu="showMenu"> </router-view>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "./store";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

import SideMenu from "./components/SideMenu.vue";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const menuShowing = ref(false);

const showMenu = () => {
  menuShowing.value = !menuShowing.value;
};
</script>

