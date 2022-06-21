<template>
  <div class="bg-white h-full p-6 flex flex-col justify-between">
    <div class="flex flex-col">
      <div class="text-3xl font-extrabold mb-4 flex items-center">
        <PhotographIcon class="text-gray-900 mr-1 w-10 h-10" />
        Field Photos
      </div>
      <div class="text-lg font-bold">Sesssion Name:</div>
      <div class="w-full">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
        />
      </div>
      <div class="text-lg font-bold mt-2">Session notes:</div>
      <div class="w-full">
        <textarea
          class="w-full border border-gray-500 p-2 h-32 rounded-sm"
        ></textarea>
      </div>
    </div>
    <div class="w-full flex text-center">
      <router-link
        to="photo"
        class="w-full border border-gray-500 p-4 rounded-sm text-xl"
      >
        Start Session
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { PhotographIcon } from "@heroicons/vue/outline";
</script>
