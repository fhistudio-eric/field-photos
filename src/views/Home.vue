<template>
  <div
    class="
      bg-white
      h-full
      p-4
      flex flex-col
      justify-between
      md:container md:mx-auto md:w-[360px]
    "
  >
    <div class="flex flex-col bg-white shadow-md rounded-sm p-4">
      <div class="text-3xl font-extrabold mb-2 flex items-center">
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
          placeholder="Enter session ID or something new"
          v-model="store.sessionName"
          @focusout="begin"
        />
        <div
          v-if="sessionExists"
          class="bg-red-200 mt-1 flex flex-col shadow-md"
        >
          <div class="mr-1 flex w-full font-bold bg-red-300 p-2">
            <ExclamationIcon class="text-gray-900 mr-1 w-6" />
            <div>Warning</div>
          </div>
          <div class="p-3">
            A session with this name already exists. You will be adding photos
            to an existing session. Disregard if you were provided with a
            session name.
          </div>
          <div class="p-3 pt-1">To create a new session enter a new name.</div>
        </div>
      </div>
      <div class="text-lg font-bold mt-2">Session notes:</div>
      <div class="w-full">
        <textarea
          class="w-full border border-gray-500 p-2 h-32 rounded-sm resize-none"
          v-model="store.sessionNotes"
          placeholder="provide some notes about your session (purpose, weather, etc.)"
        ></textarea>
      </div>
    </div>
    <div class="w-full h-full flex text-center flex-col justify-between">
      <div></div>
      <div>
        <router-link
          to="viewer"
          class="
            mb-6
            text-gray-500
            rounded-full
            border border-gray-900
            p-2
            px-6
          "
          >Photo Viewer</router-link
        >
      </div>
      <div>
        <span class="mb-4 text-gray-500">* required to begin</span>
        <router-link to="photo">
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
              bg-white
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
            Begin
          </button>
        </router-link>
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
import { ExclamationIcon } from "@heroicons/vue/outline";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

onMounted(() => {
  store.sessionDate = new Date().toISOString().split("T")[0];
});

const sessionExists = ref(false);

const begin = async () => {
  let formData = new FormData();
  formData.append("sessionName", store.sessionName);

  // const response = await axios.post("https://www.fhistudio-apps.com/fieldphotos/php/checkSessionName.php", formData);
  const response = await axios.post("/php/checkSessionName.php", formData);
  if (response.data == "Found") {
    sessionExists.value = true;
  } else {
    sessionExists.value = false;
  }
};
</script>
