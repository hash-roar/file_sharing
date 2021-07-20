<template>
  <v-main>
    <div>
      <v-card>
        <form >
        <v-file-input
          v-model="files"
          counter
          multiple
          show-size
          chips
        ></v-file-input>
        <!-- <v-text-field :counter="10" required></v-text-field> -->

        <v-btn  class="mr-4" @click="submit">提交</v-btn>
      </form>
      </v-card>
    </div>
  </v-main>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    files: [],
  }),
  methods: {
    getdata() {
      axios
        .get("/index/index/file/get_file_list")
        .then((res) => {
          console.log(res.data);
          this.files = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    submit() {
      let formData = new FormData();
      // formData重复的往一个值添加数据并不会被覆盖掉，可以全部接收到，可以通过formData.getAll('files')来查看所有插入的数据
      for (let file of this.files) {
        formData.append("filesinput[]", file,file.name);
      }
      let url = "/index/index/file/upload_file";
      let headers = {
        "Content-Type": "multipart/form-data",
      };
      axios.post(url, formData,headers=headers)
          .then((res)=>{
             this.files=[];
             alert("success");
          }).catch(function(error) {
            console.log(eror);
          })
      ;
    },
  },
  computed: {
    log: function () {
      console.log(this.files);
    },
  },
  watch: {
    files: function () {
      console.log(this.files);
    },
  },
};
</script>