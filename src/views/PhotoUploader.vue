<template>
  <div class="flex flex-col h-1/2">
    <div class="bg-gray-900 p-4 text-white text-lg">
      <router-link to="/" class="flex items-center">
        <ArrowLeftIcon class="h-5 w-5 text-white mr-1" /> Home</router-link
      >
    </div>
    <div class="p-6 flex-grow">
      <div
        v-if="!photoURL"
        class="flex justify-center items-center w-full h-full"
      >
        <label
          for="image-file"
          class="
            h-full
            w-full
            border-4 border-dashed border-black
            rounded-xl
            flex flex-col
            items-center
            justify-center
            bg-white
          "
        >
          <div class="flex flex-col justify-center items-center pt-5 pb-6">
            <CameraIcon class="h-20 w-20 text-gray-600 mr-1" />
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
              <span class="font-semibold">Tap open your camera</span>
            </p>
          </div>
          <input
            id="image-file"
            type="file"
            accept="image/*"
            capture="camera"
            class="hidden"
            @change="setImage"
          />
        </label>
      </div>
      <div v-else class="w-full flex flex-col">
        <img :src="photoURL" />
        <button class="p-2 border border-gray-500 mt-2" @click="retakePhoto">
          Re-take Photo
        </button>
      </div>
    </div>
  </div>
  <div class="bg-white h-1/2 p-6 flex flex-col justify-between">
    <div class="flex flex-col h-full">
      <div class="text-lg font-bold mt-2">Notes:</div>
      <div class="w-full h-full flex-grow">
        <textarea
          class="w-full border border-gray-500 p-2 h-5/6 rounded-sm resize-none"
          placeholder="describe this image"
        ></textarea>
      </div>
    </div>
    <div class="w-full">
      <button class="w-full border border-gray-500 p-4 text-xl rounded-sm">
        Submit
      </button>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "../store";
import { useRouter, useRoute } from "vue-router";

import { ArrowLeftIcon } from "@heroicons/vue/solid";
import { CameraIcon } from "@heroicons/vue/outline";

const uploadTime = ref();
const photoFile = ref();
const photoURL = ref();

const setImage = (e) => {
  photoFile.value = e.target.files[0];
  photoURL.value = URL.createObjectURL(photoFile.value);
};
const retakePhoto = (e) => {
  photoURL.value = null;
};

console.log(new Date().toLocaleTimeString());
</script>
