<template>
  <div>
    <!-- //上传文件模态框 -->
    <v-dialog max-width="1000" v-model="dialog">
      <dialog-add-file
        @close-dialog="closeDialog"
        @upload_succ_get_data="getdata"
        :dir_now="dir_now"
        @getnew="getdata"
      ></dialog-add-file>
    </v-dialog>
    <!-- file部分页头 -->
    <v-subheader inset
      >Files
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon color="grey lighten-1" @click.stop="dialog = !dialog"
          >mdi-plus</v-icon
        >
      </v-btn>
    </v-subheader>

    <v-list-item v-for="item in files" :key="item.file_id">
      <v-list-item-avatar>
        <v-icon class="text--black">mdi-file-pdf</v-icon>
      </v-list-item-avatar>

      <v-list-item-content>
        <v-list-item-title v-text="item.file_name"></v-list-item-title>
        <v-list-item-subtitle
          >文件大小:{{ item.file_size }}B
        </v-list-item-subtitle>
      </v-list-item-content>

      <v-list-item-action>
        <v-btn icon :href="getFilePath(item)">
          <v-icon color="grey lighten-1">mdi-arrow-collapse-down</v-icon>
        </v-btn>
      </v-list-item-action>
    </v-list-item>
  </div>
</template>
<script>
import DialogAddFile from "./DialogAddFile.vue";
import axios from "axios";
import {BASEURL,ROOT_PATH}  from "../enums/index.js"
export default {
  components: {
    DialogAddFile,
  },
  data: () => ({
    dialog: false,
    files: [
      {
        file_id: "",
        file_name: "name",
        file_upload_time: "111",
        file_dir_id: "",
        file_acu_path: "",
        file_download_num: "",
        file_size: 1234,
        file_img: "",
      },
    ],
  }),
  props: ["dir_now"],
  methods: {
    getdata() {
      let post = {
        dir_now: this.dir_now,
      };
      axios
        .post(BASEURL+"/file/get_file_list", post)
        .then((res) => {
          this.files = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    closeDialog() {
      this.dialog = false;
    },
    getFilePath(item) {
      let path = item.file_acu_path;
      let fullpath =path.slice(1);
      return ROOT_PATH+fullpath;
    },
  },
  //组件挂载时获取一遍文件目录
  mounted: function () {
    this.getdata();
  },
  watch: {
    dir_now: function () {
      this.getdata();
    },
  },
};
</script>