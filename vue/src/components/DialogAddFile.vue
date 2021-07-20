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
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn @click="close">close</v-btn>
          <v-btn @click="addFile">save</v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    directory_name: "",
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
      let url = "/index/index/file/upload_file";
      let headers = {
        "Content-Type": "multipart/form-data",
      };
      //添加目录信息
      let dir_info = this.dir_now;
      formData.set("dir_now", JSON.stringify(dir_info));
      console.log(formData.get("dir_now"));
      axios
        .post(url, formData, (headers = headers))
        .then((res) => {
          this.files = [];
          alert(res.data);
          // 关闭模态框并刷新视图
          this.$emit("close-dialog");
          this.$emit("getnew");
        })
        .catch(function (error) {
          console.log(eror);
        });
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