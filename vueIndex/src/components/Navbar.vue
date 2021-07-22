
<template>
  <div>
     <!-- 导航抽屉 -->
    <v-navigation-drawer v-model="drawer" app>
      <drawer1></drawer1>
    </v-navigation-drawer>
    <!-- 导航栏 -->
    <v-app-bar app color="indigo" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>books</v-toolbar-title>
      <v-spacer> </v-spacer>
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
    </v-app-bar>
  </div>
</template>

<script>
import Drawer1 from "./Drawer1.vue"
export default {
  components:{
   Drawer1
  },
  data: () => ({
    drawer: false,
  }),
};
</script>