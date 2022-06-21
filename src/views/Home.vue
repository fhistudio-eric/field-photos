<template>
  <div class="bg-white h-full p-6 flex flex-col justify-between">
    <div class="flex flex-col">
      <div class="text-3xl font-extrabold mb-4 flex items-center">
        <PhotographIcon class="text-gray-900 mr-1 w-10 h-10" />
        Field Photos
      </div>
      <div class="text-lg font-bold">Your Name: *</div>
      <div class="w-full">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
          v-model="store.userName"
        />
      </div>
      <div class="text-lg font-bold mt-2">Sesssion Name: *</div>
      <div class="w-full">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
          v-model="store.sessionName"
        />
      </div>
      <div class="text-lg font-bold mt-2">Session notes:</div>
      <div class="w-full">
        <textarea
          class="w-full border border-gray-500 p-2 h-32 rounded-sm"
          v-model="store.sessionNotes"
        ></textarea>
      </div>
    </div>
    <div class="w-full flex text-center flex-col">
      <span class="mb-2 text-gray-500">* required to begin</span>
      <button
        class="
          w-full
          border border-gray-500
          p-4
          rounded-sm
          text-xl
          disabled:opacity-30
          transition-all
          duration-400
        "
        :disabled="
          store.sessionName == '' ||
          store.userName == '' ||
          store.sessionName == null ||
          store.userName == null ||
          store.sessionName == undefined ||
          store.userName == undefined
            ? true
            : false
        "
      >
        <router-link to="photo"> Begin </router-link>
      </button>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "../store";
import { useRouter, useRoute } from "vue-router";

import { PhotographIcon } from "@heroicons/vue/outline";

onMounted(() => {
  store.sessionDate = new Date().toISOString().split("T")[0];
});

const store = defaultStore();
const router = useRouter();
const route = useRoute();
</script>
