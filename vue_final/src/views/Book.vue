<template>
  <div>
    <!-- 导航栏 -->
    <navbar></navbar>

    <!-- 主体 -->
    <main-part></main-part>
    <!-- 底部 -->
    <v-footer color="indigo" app >
      <span class="white--text">&copy; {{ new Date().toLocaleDateString() }}</span>
    </v-footer>
  </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import MainPart from "../components/book/MainPart.vue";
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
  methods: {
  },
};
</script>