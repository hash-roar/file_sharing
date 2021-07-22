<template>
  <v-app>
    <!-- 导航栏 -->
    <navbar></navbar>

    <!-- 主体 -->

    <main-part></main-part>

    <!-- 底部 -->
    <v-footer color="indigo" app>
      <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
import Navbar from "./components/Navbar.vue";
import Drawer from "./components/Drawer1.vue";
import MainPart from "./components/MainPart.vue";
import axios from "axios";
export default {
  name: "App",

  components: {
    Drawer,
    Navbar,
    MainPart,
  },

  data: () => ({
    drawer: false,
    watcher: false,
    message: "",
  }),
  methods: {
    getMess() {
      axios
        .get("/index/index/hello")
        .then((res) => {
          this.message = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>
