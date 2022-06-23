<template>
  <div
    class="
      bg-white
      h-full
      flex flex-col
      justify-between
      md:container md:mx-auto md:w-[360px]
      relative
      overflow-x-hidden
    "
  >
    <div class="flex flex-col bg-white p-4">
      <div
        class="
          text-3xl
          font-extrabold
          mb-2
          pt-2
          flex
          items-center
          justify-between
        "
      >
        <div class="flex items-center">
          <PhotographIcon class="text-gray-900 mr-1 w-10 h-10" />
          <div
            class="
              font-extrabold
              text-transparent text-4xl
              bg-clip-text bg-gradient-to-r
              from-blue-400
              to-green-600
            "
          >
            Field Photos
          </div>
        </div>
        <MenuIcon
          class="text-gray-900 mr-1 w-8 h-8 cursor-pointer"
          @click="showMenu"
        />
      </div>
      <div class="text-lg font-bold">Load Photos by Session Name</div>
      <div class="w-full flex flex-row">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
          v-model="sessionName"
          placeholder="enter your session name here"
        />
        <button class="p-2 border border-gray-900 ml-1" @click="load">
          Load
        </button>
      </div>
    </div>
    <div
      class="
        w-full
        flex
        text-center
        flex-col
        bg-white
        flex-grow
        overflow-scroll
        pb-10
      "
    >
      <div
        v-if="noPhotosFound == true"
        class="p-2 shadow-md rounded-md mt-6 flex items-center flex-col"
      >
        <CubeTransparentIcon
          class="text-gray-900 mr-1 w-10 h-10 animate-bounce"
        />
        No Session found with that Name
      </div>

      <div v-else class="grid grid-cols-3 gap-1">
        <div v-for="photo in photos" :key="photo.id">
          <div class="col-span-1" @click="zoomPhoto(photo)">
            <img
              :src="
                'https://www.fhistudio-apps.com/fieldphotos/uploads/' +
                photo.fileName
              "
            />
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="zoomShowing"
      class="absolute bg-white/50 backdrop-blur-md h-full w-full p-4"
    >
      <div class="w-full flex justify-end mb-2">
        <XIcon
          class="text-gray-900 w-8 h-8 mt-0 mr-0 cursor-pointer"
          @click="zoomPhoto(null)"
        />
      </div>
      <div class="w-full flex flex-col">
        <div class="bg-white p-2 mb-2 shadow-md">
          <img
            :src="
              'https://www.fhistudio-apps.com/fieldphotos/uploads/' +
              selectedPhoto.fileName
            "
          />
        </div>
        <div class="font-bold">Notes:</div>
        <div class="italic">{{ selectedPhoto.photoNotes }}</div>
        {{ selectedPhoto }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "../store";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

import { PhotographIcon } from "@heroicons/vue/outline";
import { CubeTransparentIcon } from "@heroicons/vue/outline";
import { MenuIcon } from "@heroicons/vue/outline";
import { XIcon } from "@heroicons/vue/outline";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const sessionName = ref();
const noPhotosFound = ref();
const photos = ref();

onMounted(async () => {});

const menuShowing = ref(false);
const zoomShowing = ref(false);
const selectedPhoto = ref({});

const emit = defineEmits(["showMenu"]);

const showMenu = () => {
  emit("showMenu");
};
const zoomPhoto = (photo) => {
  zoomShowing.value = !zoomShowing.value;
  selectedPhoto.value = photo;
};

const load = async () => {
  photos.value = null;
  let formData = new FormData();
  formData.append("sessionName", sessionName.value);

  const response = await axios.post("/php/loadPhotosBySession.php", formData);
  // const response = await axios.post(
  //   "https://www.fhistudio-apps.com/fieldphotos/php/loadPhotosBySession.php",
  //   formData
  // );
  photos.value = response.data;
  if (photos.value == "NONE") {
    noPhotosFound.value = true;
  } else {
    noPhotosFound.value = false;
  }
};
</script>
