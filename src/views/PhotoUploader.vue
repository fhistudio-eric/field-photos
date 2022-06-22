<template>
  <div class="flex flex-col h-2/3 overflow-hidden relative">
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
        class="p-4 px-8 rounded-full text-white text-2xl"
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
    <div class="bg-gray-900 p-4 text-white text-lg">
      <router-link to="/" class="flex items-center">
        <ArrowLeftIcon class="h-5 w-5 text-white mr-1" /> Back</router-link
      >
    </div>
    <div class="flex-grow">
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
        "
      >
        <button
          class="p-2 mt-2 bg-white w-full z-40 shadow-md"
          @click="retakePhoto"
        >
          Re-take Photo
        </button>
        <div class="h-full">
          <img :src="photoURL" class="w-[300px]" />
        </div>
      </div>
    </div>
  </div>
  <div class="bg-white p-6 h-1/3 flex flex-col justify-between">
    <div class="flex flex-col flex-grow">
      <div class="text-lg font-bold mt-2">Notes:</div>
      <div class="w-full h-full flex-grow">
        <textarea
          class="w-full border border-gray-500 p-2 h-5/6 rounded-sm resize-none"
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
        @click="submitPhoto"
      >
        Submit
      </button>
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

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const uploadTime = ref();
const photoFile = ref();
const photoURL = ref();
const photoNotes = ref();
const uploadSuccess = ref(false);
const uploadStatus = ref("");
const responsedata = ref();

const setImage = (e) => {
  photoFile.value = e.target.files[0];
  photoURL.value = URL.createObjectURL(photoFile.value);
};
const retakePhoto = (e) => {
  photoURL.value = null;
};

const submitPhoto = async () => {
  // var data = {
  //   photo: photoFile.value,
  //   url: photoURL.value,
  // };
  // const formData = getFormData(data);

  let formData = new FormData();
  formData.append("file", photoFile.value);
  formData.append("url", photoURL.value);
  formData.append("userName", store.userName);
  formData.append("sessionName", store.sessionName);
  formData.append("sessionNameNoSapce", store.sessionName.replace(/\s/g, ""));
  formData.append("sessionNotes", store.sessionNotes);
  formData.append("sessionDate", store.sessionDate);
  formData.append("photoNotes", photoNotes.value);
  formData.append("uploadTime", new Date().toLocaleTimeString());

  const response = await axios
    .post(
      "https://www.fhistudio-apps.com/fieldphotos/php/upload.php",
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

const getFormData = (object) =>
  Object.keys(object).reduce((formData, key) => {
    formData.append(key, object[key]);
    return formData;
  }, new FormData());
</script>
