<template>
  <div>
    <!-- 导航栏 -->
    <navbar></navbar>
    <!-- 主体 -->
    <main-part></main-part>
    <!-- 底部 -->
    <!-- <v-footer color="indigo" app  class="ma-0 pa-0">
      <v-img src="../assets/cloud.jpg" max-height="30">
        <span class="black--text"
          >&copy; {{ new Date().getFullYear() }}</span
        ></v-img
      >
    </v-footer> -->
  </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import MainPart from "../components/MainPart.vue";
export default {
  name: "App",

  components: {
    Navbar,
    MainPart,
  },

  data: () => ({
    drawer: false,
    watcher: false,
    message: "",
  }),
  methods: {},
};
</script>


