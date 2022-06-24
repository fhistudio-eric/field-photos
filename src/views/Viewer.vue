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
      <div class="w-full flex flex-row">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
          v-model="sessionName"
          placeholder="enter your session name here"
        />
        <button
          class="p-2 px-4 border border-gray-900 ml-1 flex items-center"
          @click="load"
        >
          <SearchIcon class="mr-1 w-4 h-4 font-extrabold" />
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
        v-if="noPhotosFound == null"
        class="
          p-2
          flex
          items-center
          flex-col flex-grow
          justify-center
          font-extrabold
          text-transparent text-4xl
          bg-clip-text bg-gradient-to-br
          from-blue-400
          to-green-600
        "
      >
        <SearchIcon class="mr-1 w-10 h-10 text-yellow-500" />
        Search for a session above
      </div>
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
        <GoogleMap
          v-if="noPhotosFound == false"
          :api-key="pk"
          class="col-span-3 h-52"
          :center="center"
          :zoom="7"
          :disableDefaultUi="true"
        >
          <Marker
            v-for="location in pLocation"
            :key="location"
            :options="{ position: location.center }"
          >
            <InfoWindow
           
            >
              <img
                :src="
                  'https://www.fhistudio-apps.com/fieldphotos/uploads/' +
                  location.fileName
                "
                class="w-32"
            /></InfoWindow>
          </Marker>
        </GoogleMap>
        <div v-for="photo in photos" :key="photo.id">
          <button
            class="
              col-span-1
              h-28
              overflow-hidden
              flex
              items-center
              justify-center
              bg-black
              hover:scale-105 hover:shadow-md hover:shadow-gray-500
              transition-all
              duration-300
            "
            @click="zoomPhoto(photo)"
          >
            <img
              :src="
                'https://www.fhistudio-apps.com/fieldphotos/uploads/' +
                photo.fileName
              "
            />
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="zoomShowing"
      class="absolute bg-white/70 backdrop-blur-lg h-full w-full p-4"
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
        <div class="font-bold mt-2">Notes:</div>
        <div class="italic">{{ selectedPhoto.photoNotes }}</div>
        <div class="font-bold">Upload Time:</div>
        <div class="italic">
          {{ selectedPhoto.sessionDate.toString().slice(5, 7) }}/{{
            selectedPhoto.sessionDate.toString().slice(8, 10)
          }}/{{ selectedPhoto.sessionDate.toString().slice(0, 4) }} at
          {{ selectedPhoto.uploadTime }}
        </div>
        <div class="font-bold mt-2">Location:</div>
        <div class="italic">
          {{ selectedPhoto.lat }},{{ selectedPhoto.lng }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "../store";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

import { defineComponent } from "vue";
import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";

import { PhotographIcon } from "@heroicons/vue/outline";
import { CubeTransparentIcon } from "@heroicons/vue/outline";
import { MenuIcon } from "@heroicons/vue/outline";
import { XIcon } from "@heroicons/vue/outline";
import { SearchIcon } from "@heroicons/vue/outline";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const sessionName = ref();
const noPhotosFound = ref(null);
const photos = ref();

const menuShowing = ref(false);
const zoomShowing = ref(false);
const selectedPhoto = ref({});

//MAP
const center = ref({ lat: 41.7679044, lng: -72.751958 });
const pk = import.meta.env.VITE_MAPKEY;

const pLocation = ref({});

const emit = defineEmits(["showMenu"]);

const showMenu = () => {
  emit("showMenu");
};
const zoomPhoto = (photo) => {
  zoomShowing.value = !zoomShowing.value;
  selectedPhoto.value = photo;
};

var response;
const load = async () => {
  selectedPhoto.value = {};
  photos.value = null;
  let formData = new FormData();
  formData.append("sessionName", sessionName.value);
  if (store.host == "www.fhistudio-apps.com") {
    response = await axios.post(
      "https://www.fhistudio-apps.com/fieldphotos/php/loadPhotosBySession.php",
      formData
    );
  } else {
    response = await axios.post("/php/loadPhotosBySession.php", formData);
  }

  photos.value = response.data;

  for (const [key, value] of Object.entries(response.data)) {
    var latitude = parseFloat(value.lat);
    var longitude = parseFloat(value.lng);

    var photoObj = {
      center: { lat: latitude, lng: longitude },
      fileName: value.fileName,
    };
    pLocation.value = { ...pLocation.value, ["COOL" + value.id]: photoObj };
  }

  if (photos.value == "NONE") {
    noPhotosFound.value = true;
  } else {
    noPhotosFound.value = false;
  }
};
</script>
