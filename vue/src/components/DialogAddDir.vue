<template>
  <div>
    <v-card>
      <v-card-title> <span class="headline">add directory</span></v-card-title>
      <!-- <v-subheader inset>{{dir_now}}</v-subheader> -->
      <v-card-text
        ><v-container>
          <v-row
            ><v-col cols="12">
              <v-text-field
                label="directory name"
                required
                v-model="directory_name"
              ></v-text-field> </v-col
          ></v-row>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn @click="close">close</v-btn>
          <v-btn @click="addDirectory">save</v-btn>
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
  }),
  methods: {
    //增加目录,在当前目录下
    addDirectory() {
      let post = {
        dir_info: this.dir_now,
        dir_adding_name: this.directory_name,
      };
      axios
        .post("/index/index/file/add_directory", post)
        .then((res) => {
          this.$emit("getnew")
          alert("success");
          console.log(res.data);
          this.close();
        })
        .catch(function (error) {
          console.log(error);
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