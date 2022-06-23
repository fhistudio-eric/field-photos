import { defineStore } from "pinia";
import { useStorage } from "@vueuse/core";
import { ref } from "vue";

export const defaultStore = defineStore("defaultStore", () => {


    const userName = ref(useStorage("userName", ""));

    const sessionName = ref(useStorage("sessionName", ""));
    const sessionNotes = ref(useStorage("sessionNotes", ""));
    const sessionDate = ref(useStorage("sessionDate", ""));

    const currentView = ref(useStorage("currentView", "Home"));


    return {
        userName,
        sessionName,
        sessionNotes,
        sessionDate,
        currentView
    }
})