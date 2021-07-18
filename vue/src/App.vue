<template>
  <v-app>
    <!-- 导航栏 -->
      <navbar></navbar>
  
    <!-- 主体 -->
    <v-main>
      
        <main-part></main-part>
      
    </v-main>
    <!-- 底部 -->
    <v-footer color="indigo" app>
      <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
import Navbar from "./components/Navbar.vue";
import Drawer from "./components/Drawer.vue";
import MainPart from "./components/MainPart.vue";
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
  }),
};
</script>
