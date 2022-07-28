<template>
  <div
    class="
      bg-white
      h-full
      flex flex-col
      md:container md:mx-auto
      relative
      overflow-x-hidden
    "
  >
    <div class="flex flex-col bg-white p-4">
      <div
        class="
          text-3xl
          font-extrabold
          mb-1
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
          placeholder="enter a session name here"
          @keyup.enter="load"
        />
        <button
          class="p-2 md:px-6 border border-gray-900 ml-1 flex items-center"
          @click="load"
        >
          <SearchIcon class="mr-1 w-4 h-4 font-extrabold" />
        </button>
        <button
          class="p-2 md:px-6 border border-gray-900 ml-1 flex items-center"
          @click="toggleDateFilter"
        >
          <CalendarIcon class="mr-1 w-4 h-4 font-extrabold" />
        </button>
        <button
          class="p-2 md:px-6 border border-gray-900 ml-1 flex items-center"
          @click="loadAll"
        >
          ALL
        </button>
      </div>
      <div
        v-if="dateFilterShowing"
        class="w-full p-2 bg-gray-100 mt-1 flex items-center justify-between"
      >
        <div class="flex flex-grow md:flex-row flex-col items-center">
          <div class="flex items-center">
            <div class="pl-4 pr-2 font-extrabold flex items-center">
              <CalendarIcon class="mr-1 w-4 h-4 font-extrabold" />
              Show all photos...
            </div>
            <select
              v-model="dateOperator"
              class="
                w-28
                p-2
                bg-transparent
                focus:outline-none
                outline-none
                border-b-2 border-green-500
                text-center
              "
              @change="updateDateOperator"
            >
              <option value="from">from</option>
              <option value="before">before</option>
              <option value="after">after</option>
              <option value="between">between</option>
            </select>
          </div>
          <div class="flex items-center">
            <input
              type="date"
              class="
                w-36
                h-10
                p-2
                md:mx-2
                bg-transparent
                focus:outline-none
                outline-none
                border-b-2 border-green-500
              "
              v-model="startDate"
            />
            <div class="px-2 font-extrabold" v-if="dateOperator == 'between'">
              and
            </div>
            <input
              v-if="dateOperator == 'between'"
              type="date"
              class="
                w-36
                h-10
                p-2
                md:mx-2
                bg-transparent
                focus:outline-none
                outline-none
                border-b-2 border-green-500
              "
              v-model="endDate"
            />
          </div>
          <button
            class="
              p-2
              px-4
              border border-gray-900
              ml-4
              w-full
              md:w-auto
              flex
              items-center
              mt-2
              md:mt-0
              text-center
              justify-center
            "
            @click="loadByDate"
          >
            GO
          </button>
        </div>
      </div>
    </div>

    <div class="h-full flex md:flex-row flex-col overflow-hidden">
      <div class="md:w-1/2 w-full md:h-full h-1/2">
        <GoogleMap
          :api-key="pk"
          class="h-full"
          :center="center"
          :zoom="zoom"
          :disableDefaultUi="false"
          @click="test"
        >
          <Marker
            v-for="location in pLocation"
            :key="location"
            :options="{ position: location.center }"
          >
            <InfoWindow class="w-44">
              <img
                :src="
                  'https://www.fhistudio-apps.com/fieldphotos/uploads/' +
                  location.fileName
                "
                class="w-full"
              />
              <div class="mt-2">{{ location.notes }}</div>
            </InfoWindow>
          </Marker>
        </GoogleMap>
      </div>
      <div class="md:w-1/2 w-full h-full overflow-scroll">
        <div
          v-if="noPhotosFound == null"
          class="
            p-2
            mt-6
            flex
            items-center
            flex-col
            justify-center
            font-extrabold
            text-transparent text-4xl
            bg-clip-text bg-gradient-to-br
            from-blue-400
            to-green-600
            text-center
          "
        >
          <SearchIcon class="mr-1 w-10 h-10 text-yellow-500" />
          Load photos using the tools above.
        </div>
        <div
          v-if="noPhotosFound == true"
          class="
            p-2
            mt-6
            flex
            items-center
            flex-col
            font-extrabold
            text-transparent text-4xl
            bg-clip-text bg-gradient-to-br
            from-blue-400
            to-green-600
            text-center
          "
        >
          <CubeTransparentIcon
            class="text-gray-900 mr-1 w-10 h-10 animate-bounce"
          />
          No Photos found. <br />
          Refine your search.
        </div>

        <div v-if="noPhotosFound == false">
          <div
            class="
              bg-gray-100
              w-full
              sticky
              top-0
              shadow-md
              flex
              z-40
              justify-between
            "
          >
            <div class="flex items-center font-extrabold pl-4">
              {{ photos.length }} photos
            </div>
            <div class="flex items-cetner">
              <button
                class="
                  p-2
                  bg-gray-200
                  px-4
                  mr-1
                  hover:bg-gray-300
                  transition-all
                  duration-200
                "
                @click="changeGridClassExpand"
              >
                <ZoomOutIcon class="text-gray-700 mr-1 w-6 h-6" />
              </button>
              <button
                class="
                  p-2
                  bg-gray-200
                  px-4
                  mr-1
                  hover:bg-gray-300
                  transition-all
                  duration-200
                "
                @click="changeGridClassReset"
              >
                <SearchIcon class="text-gray-700 mr-1 w-6 h-6" />
              </button>
              <button
                class="
                  p-2
                  bg-gray-200
                  px-4
                  hover:bg-gray-300
                  transition-all
                  duration-200
                "
                @click="changeGridClassShrink"
              >
                <ZoomInIcon class="text-gray-700 mr-1 w-6 h-6" />
              </button>
            </div>
          </div>
          <div class="grid gap-1 bg-gray-50 p-2" :class="gridClass">
            <div v-for="photo in photos" :key="photo.id">
              <button
                class="
                  col-span-1
                  h-40
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
      </div>
    </div>

    <div
      v-if="zoomShowing"
      class="
        absolute
        bg-white/80
        backdrop-blur-lg
        h-screen
        w-full
        p-4
        overflow-scroll
        z-50
      "
    >
      <div class="w-full flex justify-end mb-2">
        <XIcon
          class="
            bg-white
            text-gray-900
            w-10
            h-10
            mt-0
            mr-0
            cursor-pointer
            absolute
            p-2
            rounded-full
            shadow-xl
            border border-green-600
            hover:rotate-180
            transition-all
            duration-300
          "
          @click="zoomPhoto(null)"
        />
      </div>
      <div class="w-full flex md:flex-row flex-col">
        <div class="p-2 mb-2 md:w-1/2 flex h-full items-center justify-center">
          <img
            class="shadow-md p-2 md:w-[520px]"
            :src="
              'https://www.fhistudio-apps.com/fieldphotos/uploads/' +
              selectedPhoto.fileName
            "
          />
        </div>
        <div class="md:w-1/2 p-4">
          <div class="font-bold md:mt-2 text-2xl text-green-700">
            Session Name:
          </div>
          <div class="italic text-xl">{{ selectedPhoto.sessionName }}</div>
          <div class="font-bold mt-2 text-2xl text-green-700">Notes:</div>
          <div class="italic text-xl">{{ selectedPhoto.photoNotes }}</div>
          <div class="font-bold mt-2 text-2xl text-green-700">Upload Time:</div>
          <div class="italic text-lg">
            {{ selectedPhoto.sessionDate.toString().slice(5, 7) }}/{{
              selectedPhoto.sessionDate.toString().slice(8, 10)
            }}/{{ selectedPhoto.sessionDate.toString().slice(0, 4) }} at
            {{ selectedPhoto.uploadTime }}
          </div>
          <div class="font-bold mt-2 text-2xl text-green-700">Photo By:</div>
          <div class="italic text-lg">
            {{ selectedPhoto.userName }}
          </div>
          <div class="font-bold mt-2 text-2xl text-green-700">Coordinates:</div>
          <div class="italic text-lg">
            {{ selectedPhoto.lat }}, <br />{{ selectedPhoto.lng }}
          </div>
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
import { CalendarIcon } from "@heroicons/vue/outline";
import { ZoomInIcon } from "@heroicons/vue/outline";
import { ZoomOutIcon } from "@heroicons/vue/outline";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const sessionName = ref();
const noPhotosFound = ref(null);
const photos = ref();

const menuShowing = ref(false);
const zoomShowing = ref(false);
const dateFilterShowing = ref(false);
const selectedPhoto = ref({});

//SET TODAY//
var date = new Date();

var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();

if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;

var today = year + "-" + month + "-" + day;
//SET TODAY//

const dateOperator = ref("from");
const startDate = ref(today);
const endDate = ref(today);

console.log(new Date().toLocaleDateString());
//MAP
const center = ref({ lat: 41.7679044, lng: -72.751958 });
const zoom = ref(12);
const pk = import.meta.env.VITE_MAPKEY;

const pLocation = ref({});

//GRID
const gridClass = ref("md:grid-cols-4 grid-cols-3");

const emit = defineEmits(["showMenu"]);

const showMenu = () => {
  emit("showMenu");
};

const changeGridClassExpand = () => {
  gridClass.value = "md:grid-cols-5 grid-cols-4";
};
const changeGridClassShrink = () => {
  gridClass.value = "md:grid-cols-3 grid-cols-2";
};
const changeGridClassReset = () => {
  gridClass.value = "md:grid-cols-4 grid-cols-3";
};

const zoomPhoto = (photo) => {
  zoomShowing.value = !zoomShowing.value;
  selectedPhoto.value = photo;

  if (zoomShowing.value == true) {
    var lat = parseFloat(photo.lat);
    var lng = parseFloat(photo.lng);

    center.value = { lat: lat, lng: lng };
    zoom.value = 18;
  }
};

const toggleDateFilter = () => {
  dateFilterShowing.value = !dateFilterShowing.value;
};

const test = (e) => {
  console.log(":test: " + e.target);
};

//QUERIES//
var response;

const loadByDate = async () => {
  photos.value = null;
  pLocation.value = {};
  selectedPhoto.value = {};
  photos.value = null;

  let formData = new FormData();
  formData.append("dateOperator", dateOperator.value);
  formData.append("startDate", startDate.value);
  formData.append("endDate", endDate.value);

  if (store.host == "www.fhistudio-apps.com") {
    response = await axios.post(
      "https://www.fhistudio-apps.com/fieldphotos/php/loadAllPhotosByDate.php",
      formData
    );
  } else {
    response = await axios.post("/php/loadAllPhotosByDate.php", formData);
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

const load = async () => {
  photos.value = null;
  pLocation.value = {};
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

const loadAll = async () => {
  photos.value = null;
  pLocation.value = {};
  selectedPhoto.value = {};
  photos.value = null;

  if (store.host == "www.fhistudio-apps.com") {
    response = await axios.post(
      "https://www.fhistudio-apps.com/fieldphotos/php/loadAllPhotos.php"
    );
  } else {
    response = await axios.post("/php/loadAllPhotos.php");
  }

  photos.value = response.data;

  for (const [key, value] of Object.entries(response.data)) {
    var latitude = parseFloat(value.lat);
    var longitude = parseFloat(value.lng);

    var photoObj = {
      center: { lat: latitude, lng: longitude },
      fileName: value.fileName,
      notes: value.photoNotes,
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
