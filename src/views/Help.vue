<template>
  <div
    class="
      bg-white
      h-full
      flex flex-col
      justify-between
      relative
      overflow-x-hidden
    "
    :class="{ 'overflow-hidden': menuShowing == true }"
  >
    <div class="flex flex-col bg-white p-4">
      <div
        class="
          text-3xl
          font-extrabold
          pb-2
          pt-2
          flex
          items-center
          justify-between
          sticky
          top-0
          bg-white
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
          p-2
        />
      </div>
      <div class="pb-10">
        <div
          class="
            font-bold
            text-2xl
            mt-2
            sticky
            top-12
            bg-gray-100
            p-2
            shadow-md
          "
        >
          About
        </div>

        <div class="font-bold mt-2 text-green-700 underline">
          What is this tool for?
        </div>
        <p class="text-gray-800">
          This is a tool used to collect photos in the field and create
          collections by sessions.
        </p>
        <div class="font-bold mt-2 text-green-700 underline">
          What are some use cases?
        </div>
        <div class="text-gray-800">
          <ul class="list-disc ml-6">
            <li>A site visit to collect information</li>
            <li>Commuinity crowd sourcing</li>
            <li>Reporting issues</li>
            <li>Breakout groups collecting sample photos</li>
          </ul>
        </div>
        <div class="font-bold mt-2 text-green-700 underline">
          What is a session?
        </div>
        <p class="text-gray-800">
          A session is a unique name allowing photos to be grouped. You can
          create a unique session name and keep it secret for yourself or share
          it with others so you can all add photos to the same session.
        </p>
        <div class="font-bold mt-2 text-green-700 underline">
          Are the photos private?
        </div>
        <p class="text-gray-800">
          No. The photos are not private or encrypted. If someone can guess your
          session name they can view your photos.
        </p>
        <div class="font-bold mt-2 text-green-700 underline">
          Does this track my location?
        </div>
        <p class="text-gray-800">
          Yes and no. The tool grabs your location each time you upload a photo
          using the phones GPS. It is not tracking you at all times, only when
          you when tap submit to upload a photo.
        </p>

        <div
          class="
            font-bold
            text-2xl
            mt-2
            sticky
            top-12
            bg-gray-100
            p-2
            shadow-md
          "
        >
          Help
        </div>

        <div class="font-bold mt-2 text-green-700 underline">
          How do I start?
        </div>
        <div class="text-gray-800">
          <ul class="list-disc ml-6">
            <li>
              To start enter you name, session name, and optionally session
              notes.
            </li>
            <li>
              Your name and session name are required to ensure photos get to
              thecorrect group and help figure out who took the photo.
            </li>
            <li>
              You may have been given a session name by a group organizer. If
              so,enter that to add your photos to the groups.
            </li>
            <li>
              Session notes help give an idea of the session purpose and can
              behelpful when reviewing photos later.
            </li>
          </ul>
        </div>
        <div class="font-bold mt-2 text-green-700 underline">
          Taking a photo
        </div>
        <div class="text-gray-800">
          <ul class="list-disc ml-6">
            <li>
              When ready, tap the gray camera button to open the camera on your
              device.
            </li>
            <li>Take your photo. You can retake your photo if needed.</li>
            <li>
              Add some notes to the photo to give some context of what or why.
            </li>
            <li>
              Tap submit. The tool will quickly grab your location and upload
              the photo.
            </li>
            <li>Once uploaded you are ready for another!</li>
          </ul>
        </div>

        <div class="font-bold mt-2 text-green-700 underline">
          How do I view the photos?
        </div>
        <p class="text-gray-800">
          Go to the Photo Viewer page and enter in your session name. This will
          load all of the information and photos from that session.
        </p>
        <div class="font-bold mt-2 text-green-700 underline">
          My photo is taking a long time to upload. Why?
        </div>
        <p class="text-gray-800">
          Upload time depends on two main factors, data speeds and image size.
          If you are on a slow cellular connection it may take longer. If your
          image is large it may also take longer. The tool does it's best to
          compress and optimize large iPhone images to reduce upload times.
          iPhone images are a special format at require a few adjustments before
          than can be uploaded.
        </p>

        <div
          class="
            font-extralight
            text-center
            mt-52
            text-transparent text-4xl
            bg-clip-text bg-gradient-to-r
            from-blue-400
            to-green-600
          "
        >
          Hello :)
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

import { PhotographIcon } from "@heroicons/vue/outline";
import { CubeTransparentIcon } from "@heroicons/vue/outline";
import { MenuIcon } from "@heroicons/vue/outline";
import SideMenu from "../components/SideMenu.vue";

const store = defaultStore();
const router = useRouter();
const route = useRoute();

const sessionName = ref();
const noPhotosFound = ref();
const photos = ref();

onMounted(async () => {});

const menuShowing = ref(false);

const emit = defineEmits(["showMenu"]);

const showMenu = () => {
  emit("showMenu");
};
</script>
