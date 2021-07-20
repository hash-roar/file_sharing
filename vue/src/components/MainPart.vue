<template>
  <v-main>
    <v-card class="" img="/index/static/pixiv645.jpg">
      <!-- <v-btn @click.stop="downloadFile">download</v-btn> -->
      <v-list two-line subheader dense>
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

        <v-list-item v-if="directory_nav.length - 1" @click="getBack">
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
            <v-icon class="blue lighten-1 white--text">mdi-folder</v-icon>
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
        <file :dir_now="dir_now"></file> </v-list
    ></v-card>
  </v-main>
</template>
<script>
import File from "./File.vue";
import DiologAddDir from "./DialogAddDir.vue";
import axios from "axios";
export default {
  components: {
    DiologAddDir,
    File,
  },
  data: () => ({
    //模态框
    dialog: false,
    // 面包屑导航
    directorys: [],
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
          this.directory_nav = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    //返回上级目录
    getBack() {
      //设置当前目录为总目录倒数第二个目录即可
      let temp = this.directory_nav.slice(-2, -1);
      this.dir_now = temp[0];
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