<template>
  <div
    class="
      bg-white
      h-full
      flex flex-col
      justify-between
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
          mb-2
          pt-2
          flex
          items-center
          justify-between
          sticky top-0
          bg-white
        "
      >
        <div class="flex justify-between items-center">
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
      <div class="text-lg font-bold">Your Name: *</div>
      <div class="w-full">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
          placeholder="Enter your name"
          v-model="store.userName"
        />
      </div>
      <div class="text-lg font-bold mt-2">Sesssion Name: *</div>
      <div class="w-full">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
          placeholder="Enter a session ID"
          v-model="store.sessionName"
          @focusout="begin"
        />
        <div
          v-if="sessionExists"
          class="bg-red-200 mt-1 flex flex-col shadow-md"
        >
          <div class="mr-1 flex w-full font-bold bg-red-300 p-1">
            <ExclamationIcon class="text-gray-900 mr-1 w-6" />
            <div>Warning - Session name exists</div>
          </div>
          <div class="px-3 py-1">
            You will be adding photos to an existing session.
            <span class="italic">
              Disregard if you were provided with a session name.
            </span>
          </div>
        </div>
      </div>
      <div class="text-lg font-bold mt-2">Session notes:</div>
      <div class="w-full">
        <textarea
          class="w-full border border-gray-500 p-2 h-24 rounded-sm resize-none"
          v-model="store.sessionNotes"
          placeholder="Provide some notes about your session (purpose, weather, etc.)"
        ></textarea>
      </div>
      <div class="flex w-full justify-start items-start">
        <button class="p-1 px-2 bg-white shadow-md rounded-full" @click="clear">
          clear
        </button>
      </div>
    </div>
    <div class="w-full h-full flex text-center flex-col justify-end p-4">
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

import SideMenu from "../components/SideMenu.vue";

import { PhotographIcon } from "@heroicons/vue/outline";
import { ExclamationIcon } from "@heroicons/vue/outline";
import { MenuIcon } from "@heroicons/vue/outline";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const menuShowing = ref(false);

const emit = defineEmits(["showMenu"]);

const showMenu = () => {
  emit("showMenu");
};
const clear = () => {
  store.userName = null;
  store.sessionName = null;
  store.sessionNotes = null;
};

onMounted(() => {
  store.sessionDate = new Date().toISOString().split("T")[0];
  store.host = window.location.host;
});

const sessionExists = ref(false);
var response;

const begin = async () => {
  let formData = new FormData();
  formData.append("sessionName", store.sessionName);

  if (store.host == "www.fhistudio-apps.com") {
    response = await axios.post(
      "https://www.fhistudio-apps.com/fieldphotos/php/checkSessionName.php",
      formData
    );
  } else {
    response = await axios.post("/php/checkSessionName.php", formData);
  }

  if (response.data == "Found") {
    sessionExists.value = true;
  } else {
    sessionExists.value = false;
  }
};
</script>
