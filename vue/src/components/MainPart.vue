<template>
  <v-main>
    <v-card class="">
      <v-btn @click.stop="getNav">get</v-btn>
      <v-list two-line subheader>
        <!--面包屑导航 -->
        <v-subheader inset>
          <v-breadcrumbs :items="directory_nav">
            <template v-slot:item="{ item }">
              <v-breadcrumbs-item @click="changeDir(item)">
                {{ item.dir_name.toUpperCase() }}
              </v-breadcrumbs-item>
            </template>
          </v-breadcrumbs>
          <v-spacer></v-spacer>

          <v-btn icon>
            <v-icon color="grey lighten-1" @click.stop="dialog = !dialog"
              >mdi-plus</v-icon
            >
          </v-btn>
          <!-- 模态框 -->
          <v-dialog max-width="300" v-model="dialog">
            <diolog-add-dir
              :dir_now="dir_now"
              @close-dialog="closeDialog"
              @getnew="getdata"
            >
            </diolog-add-dir>
          </v-dialog>
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
        <v-list-item
          v-for="item in directorys"
          :key="item.dir_id"
          @click="changeDir(item)"
        >
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
import DiologAddDir from "./DialogAddDir.vue";
import axios from "axios";
export default {
  components: {
    DiologAddDir,
  },
  data: () => ({
    //模态框
    dialog: false,
    // 面包屑导航
    directorys: [],
    files: [
      {
        file_name: "book",
        file_upload_time: "Jan 20, 2014",
      },
    ],
    dir_now: {
      dir_id: 1,
      dir_name: "books",
      dir_parentid: 0,
      dir_acu_path: "./uploads/books",
      dir_file_num: 0,
      dir_create_time: "2021-07-19",
    },
    directory_nav: [
      {
        dir_id: 1,
        dir_name: "books",
        dir_parentid: 0,
        dir_acu_path: "./uploads/books",
        dir_file_num: 0,
        dir_create_time: "2021-07-19",
      },
    ],
  }),
  methods: {
    getdata() {
      let post = {
        dir_now: this.dir_now,
      };
      axios
        .post("/index/index/file/get_directory", post)
        .then((res) => {
          //   console.log(res.data);
          this.directorys = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    closeDialog() {
      this.dialog = false;
    },
    //点击改变当前目录下属性,由侦听器异步改变主体内容
    changeDir(dir_old) {
      this.dir_now = dir_old;
    },
    //在后端获取导航目录
    getNav() {
      let post = {
        dir_now: this.dir_now,
      };
      axios
        .post("/index/index/file/get_nav", post)
        .then((res) => {
          console.log(res);
          this.directory_nav = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  //获取目录及文件列表
  mounted: function () {
    this.getdata();
  },
  watch: {
    //监听当前目录改变
    dir_now: function () {
      //重新获取目录并调整面包屑导航
      this.getdata();
      this.getNav();
    },
  },
};
</script>