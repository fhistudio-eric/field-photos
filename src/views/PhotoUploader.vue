<template>
  <div
    class="
      flex flex-col
      h-full
      overflow-hidden
      relative
      md:container md:mx-auto md:w-[360px]
    "
  >
    <div
      class="
        absolute
        top-0
        w-full
        p-2
        flex
        items-center
        justify-center
        transition-all
        duration-300
        z-50
      "
      :class="{ '-mt-20': uploadSuccess == false }"
    >
      <div
        class="p-2 px-8 rounded-full text-white text-2xl"
        :class="{
          'bg-green-600': uploadStatus == 'Success',
          'bg-red-600': uploadStatus != 'Success',
        }"
      >
        <div v-if="uploadStatus == 'Success'" class="flex items-center">
          <BadgeCheckIcon class="h-8 w-8 text-white mr-1" />
          <div>{{ uploadStatus }}</div>
        </div>
        <div v-else class="flex items-center">
          <BadgeCheckIcon class="h-8 w-8 text-white mr-1" />
          <div>{{ uploadStatus }}</div>
        </div>
      </div>
    </div>
    <div class="bg-gray-900 p-0 text-white flex justify-between">
      <router-link
        to="/"
        class="flex items-center bg-gray-900 hover:bg-gray-800 p-4"
      >
        <ArrowLeftIcon class="h-4 w-4 text-white mr-1" /> Back</router-link
      >
      <div class="flex items-center justify-end text-right p-4">
        <div v-if="locationAcquired == false" class="text-xs mr-1">
          Getting Location
        </div>
        <div v-else class="text-xs mr-1">
          {{ lat.toString().slice(0, 8) }},{{ lng.toString().slice(0, 8) }}
        </div>
        <GlobeIcon
          class="h-5 w-5"
          :class="{
            'text-green-500': locationAcquired == true,
            'text-red-500 animate-spin': locationAcquired == false,
          }"
          @click="getLocation"
        />
      </div>
    </div>
    <div class="h-1/2">
      <div
        v-if="!photoURL"
        class="flex justify-center items-center w-full h-full"
      >
        <label
          for="image-file"
          class="
            h-full
            w-full
            shadow-inner
            bg-gray-300
            flex flex-col
            items-center
            justify-center
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
            capture="camera"
            class="hidden"
            @change="setImage"
          />
        </label>
      </div>
      <div
        v-else
        class="
          w-full
          flex flex-col
          justify-center
          items-center
          overflow-hidden
          relative
          p-2
        "
      >
        <button
          class="
            p-2
            mt-2
            bg-white
            z-40
            absolute
            top-0
            right-0
            rounded-full
            shadow-xl
          "
          @click="retakePhoto"
        >
          Retake Photo
        </button>
        <div class="h-full p-2 bg-white shadow-md shadow-blue-200">
          <img :src="photoURL" class="max-h-[340px]" />
        </div>
      </div>
    </div>
    <div class="bg-white p-6 flex-grow flex flex-col justify-between">
      <div class="flex flex-col flex-grow">
        <div class="text-lg font-bold mt-2">Notes:</div>
        <div class="w-full h-full flex-grow">
          <textarea
            class="
              w-full
              border border-gray-500
              p-2
              h-5/6
              rounded-sm
              resize-none
            "
            placeholder="describe this image"
            v-model="photoNotes"
          ></textarea>
        </div>
      </div>
      <div class="w-full">
        <button
          class="
            w-full
            border border-gray-500
            bg-white
            p-4
            text-xl
            rounded-sm
            disabled:opacity-50
          "
          :disabled="photoURL == null ? true : false"
          @click="locateMe"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { defaultStore } from "../store";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

import { ArrowLeftIcon } from "@heroicons/vue/solid";
import { CameraIcon } from "@heroicons/vue/outline";
import { BadgeCheckIcon } from "@heroicons/vue/outline";
import { GlobeIcon } from "@heroicons/vue/solid";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

onMounted(() => {
  locateMe();
});

const uploadTime = ref();
const photoFile = ref();
const photoURL = ref(null);
const photoNotes = ref();
const uploadSuccess = ref(false);
const uploadStatus = ref("");
const responsedata = ref();
const location = ref();
const locationAcquired = ref(false);
const lat = ref();
const lng = ref();

const setImage = (e) => {
  photoFile.value = e.target.files[0];
  photoURL.value = URL.createObjectURL(photoFile.value);
};
const retakePhoto = (e) => {
  photoURL.value = null;
};

const makeid = (length) => {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
};

const submitPhoto = async () => {
  var rand = makeid(5);
  locationAcquired.value = false;

  let formData = new FormData();
  formData.append("file", photoFile.value);
  formData.append("url", photoURL.value);
  formData.append("userName", store.userName);
  formData.append("sessionName", store.sessionName);
  formData.append("randomString", rand);
  formData.append("sessionNotes", store.sessionNotes);
  formData.append("sessionDate", store.sessionDate);
  formData.append("photoNotes", photoNotes.value);
  formData.append("uploadTime", new Date().toLocaleTimeString());
  formData.append("lat", lat.value);
  formData.append("lng", lng.value);

  const response = await axios
    .post(
      "/php/upload.php",
      // "https://www.fhistudio-apps.com/fieldphotos/php/upload.php",
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    )
    .then(function (response) {
      responsedata.value = response.data;
      if (!response.data) {
        alert("File not uploaded.");
        uploadSuccess.value = true;
        uploadStatus.value = "Fail - Try Again";
        setTimeout(() => {
          uploadSuccess.value = false;
          // photoURL.value = null;
        }, 3000);
      } else {
        // alert("File uploaded successfully.");
        uploadSuccess.value = true;
        uploadStatus.value = "Success";
        setTimeout(() => {
          uploadSuccess.value = false;
          photoURL.value = null;
          photoNotes.value = "";
        }, 3000);
      }
    })
    .catch(function (error) {
      responsedata.value = error;
    });
};

const getLocation = async () => {
  return new Promise((resolve, reject) => {
    if (!("geolocation" in navigator)) {
      reject(new Error("Geolocation is not available."));
    }

    navigator.geolocation.getCurrentPosition(
      (pos) => {
        lat.value = pos.coords.latitude;
        lng.value = pos.coords.longitude;
        if (photoURL.value != null) {
          submitPhoto();
        }
        resolve(pos);
      },
      (err) => {
        console.log(err);
        reject(err);
      }
    );
  });
};

const locateMe = async () => {
  locationAcquired.value = false;
  try {
    location.value = await getLocation();
    locationAcquired.value = true;
  } catch (e) {
    locationAcquired.value = false;
    console.log(e.message);
  }
};
</script>
