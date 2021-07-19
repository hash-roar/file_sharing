<template>
  <v-main>
    <v-card class="">
      <v-btn @click.stop="getdata">get</v-btn>
      <v-list two-line subheader>
        <!--面包屑导航 -->
        <v-subheader inset>
          <v-breadcrumbs :items="directory_nav">
            <template v-slot:item="{ item }">
              <v-breadcrumbs-item :href="item.href" >
                {{ item.dir_name.toUpperCase() }}
              </v-breadcrumbs-item>
            </template>
          </v-breadcrumbs>
          <v-spacer></v-spacer>
          <v-btn icon>
            <v-icon color="grey lighten-1">mdi-plus</v-icon>
          </v-btn>
        </v-subheader>

        <v-list-item>
          <v-list-item-avatar>
            <v-icon class="grey lighten-1 white--text">mdi-folder</v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title>..</v-list-item-title>
            <v-list-item-subtitle>上级目录</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-list-item v-for="item in directorys" :key="item.dir_id">
          <v-list-item-avatar>
            <v-icon class="grey lighten-1 white--text">mdi-folder</v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title v-text="item.dir_name"></v-list-item-title>
            <v-list-item-subtitle>{{
              item.dir_create_time
            }}</v-list-item-subtitle>
          </v-list-item-content>

          <v-list-item-action>
            <v-btn icon>
              <v-icon color="grey lighten-1">mdi-information</v-icon>
            </v-btn>
          </v-list-item-action>
        </v-list-item>

        <v-divider inset></v-divider>

        <v-subheader inset>Files </v-subheader>

        <v-list-item v-for="item in files" :key="item.title">
          <v-list-item-avatar>
            <v-icon class="blue text--black">mdi-file-cloud-outline</v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title v-text="item.file_name"></v-list-item-title>
            <v-list-item-subtitle
              v-text="item.file_upload_time"
            ></v-list-item-subtitle>
          </v-list-item-content>

          <v-list-item-action>
            <v-btn icon>
              <v-icon color="grey lighten-1">mdi-arrow-collapse-down</v-icon>
            </v-btn>
          </v-list-item-action>
        </v-list-item>
      </v-list></v-card
    >
  </v-main>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    directorys: [],
    files: [
      {
        file_name: "book",
        file_upload_time: "Jan 20, 2014",
      },
    ],
    dir_now:{
        dir_id:1,
        dir_name: "books",
        dir_parentid: 0,
        dir_acu_path: "",
    },
    directory_nav: [
      {
        dir_id:1,
        dir_name: "books",
        dir_parentid: 0,
        dir_acu_path: "",
      },
    ],
  }),
  methods: {
    getdata() {
      axios
        .get("/index/index/file/get_directory")
        .then((res) => {
          console.log(res.data);
          this.directorys = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>