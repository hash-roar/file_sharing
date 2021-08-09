<template>
  <div>
    <v-card>
      <v-card-title> <span class="headline">upload file</span></v-card-title>
      <!-- <v-subheader inset>{{dir_now}}</v-subheader> -->
      <v-card-text
        ><v-container>
          <v-file-input
            v-model="files"
            counter
            multiple
            show-size
            chips
          ></v-file-input>
        </v-container>
        <v-progress-linear
          :value="processLiner.value"
          :active="processLiner.active"
          color="blue-grey"
          height="15"
        ></v-progress-linear>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn @click="close">close</v-btn>
          <v-btn @click="uploadFile">save</v-btn>
        </v-card-actions>
        <v-snackbar
          timeout="3000"
          absolute
          centered
          :color="snackbar.color"
          v-model="snackbar.bool"
          text
        >
          {{ snackbar.message }}
        </v-snackbar>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import axios from "axios";
import { UPLOAD_SIZE, BASEURL } from "../enums/index.js";
export default {
  data: () => ({
    processLiner: {
      value: 0,
      active: false,
    },
    directory_name: "",
    snackbar: {
      bool: false,
      message: "",
      color: "red",
    },
    files: [],
  }),
  methods: {
    //上传文件,在当前目录下
    addFile() {
      let formData = new FormData();
      // formData重复的往一个值添加数据并不会被覆盖掉，可以全部接收到，可以通过formData.getAll('files')来查看所有插入的数据
      for (let file of this.files) {
        formData.append("filesinput[]", file, file.name);
      }
      let url = "/index/file/upload_file";
      let header = {
        "Content-Type": "multipart/form-data",
      };
      //添加目录信息
      let dir_info = this.dir_now;
      formData.set("dir_now", JSON.stringify(dir_info));
      axios
        .post(url, formData, { headers: header })
        .then((res) => {
          this.files = [];
          alert(res.data);
          // 关闭模态框并刷新视图
          this.$emit("close-dialog");
          this.$emit("getnew");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    inform(message, color = "red") {
      this.snackbar.bool = true;
      this.snackbar.message = message;
      this.snackbar.color = color;
    },
    process(value) {
      if (value == 1) {
        this.processLiner.active = false;
      }
      this.processLiner.active = true;
      this.processLiner.value = value * 100;
    },
    async uploadFile() {
      // 判断数组为空
      if (this.files.length == 0) {
        this.inform("请选择文件");
      }
      //定义常量
      let chunk_size = UPLOAD_SIZE;
      //当前文件夹
      while (this.files.length > 0) {
        let file = this.files.pop();
        //上传de数据
        let post_data = {
          chunk_size: chunk_size,
          file_name: file.name,
          file_total_size: file.size,
          chunk_num: Math.ceil(file.size / chunk_size),
          dir_now: this.dir_now,
        };
        await this.sendFile(file, post_data);
      }
      this.close();
      this.$emit("upload_succ_get_data");
    },
    async sendFile(file, postData) {
      let chunk_index_now = 0;
      let hasupload = 0;
      while (
        chunk_index_now < postData.chunk_num &&
        chunk_index_now == hasupload
      ) {
        //对文件切片
        let start = chunk_index_now * postData.chunk_size;
        let end =
          start + postData.chunk_size > postData.file_total_size
            ? postData.file_total_size
            : start + postData.chunk_size;
        let file_blob = file.slice(start, end);
        let formData = new FormData();
        postData.index = chunk_index_now;
        formData.append("slice", file_blob);
        formData.append("post", JSON.stringify(postData));
        await axios
          .post(BASEURL + "/file/upload", formData)
          .then((res) => {
            this.inform(res.data);
            hasupload++;
            this.process(hasupload / postData.chunk_num);
          })
          .catch(function () {
            console.log("axios upload error");
          });
        chunk_index_now++;
      }
    },
    //关闭模态框
    close() {
      this.$emit("close-dialog");
    },
  },
  //获取当前所在目录
  props: ["dir_now"],
};
</script>