<template>
  <div class="flex flex-col h-1/2">
    <div class="bg-gray-900 p-4 text-white text-lg">
      <router-link to="/" class="flex items-center">
        <ArrowLeftIcon class="h-5 w-5 text-white mr-1" /> Home</router-link
      >
    </div>
    <div class="p-6 flex-grow">
      <div
        class="
          h-full
          border-4 border-dashed border-black
          rounded-xl
          flex flex-col
          items-center
          justify-center
          bg-white
        "
      >
        <PlusCircleIcon class="h-14 w-14 text-gray-900 mr-1" />
        <div>Add Photo</div>
      </div>
    </div>
  </div>
  <div class="bg-white h-1/2 p-6 flex flex-col justify-between">
    <div class="flex flex-col">
      <div class="text-lg font-bold">Name:</div>
      <div class="w-full">
        <input
          type="text"
          class="w-full border border-gray-500 p-2 rounded-sm"
        />
      </div>
      <div class="text-lg font-bold mt-2">Notes:</div>
      <div class="w-full">
        <textarea
          class="w-full border border-gray-500 p-2 h-32 rounded-sm"
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
import { ArrowLeftIcon } from "@heroicons/vue/solid";
import { PlusCircleIcon } from "@heroicons/vue/outline";
</script>
