<template>
  <v-app>
    <v-container class="mx-auto pa-0 mt-16">
      <v-card max-width="950">
        <v-card-title class="text-center"> 搜书 </v-card-title>
        <!-- <v-card-subtitle>支持按书名搜索</v-card-subtitle> -->
        <v-divider></v-divider>
        <v-card-text>
          <v-text-field
            v-model="book_name"
            append-outer-icon="mdi-magnify"
            autofocus
            clearable
            @keydown.enter="search"
          >
            <template v-slot:append-outer>
              <v-icon left color="blue" @click="search">mdi-magnify</v-icon>
            </template>
          </v-text-field>
        </v-card-text>
        <v-card-text>
          <v-list-item v-for="item in files" :key="item.file_id">
            <v-list-item-avatar>
              <v-icon class="blue text--black">mdi-file-cloud-outline</v-icon>
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
        </v-card-text>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import axios from "axios";
export default {
  name: "App",

  components: {},

  data: () => ({
    book_name: "",
    files: [],
  }),
  methods: {
    search() {
      let post = {
        book_name: this.book_name,
      };
      axios
        .post("/index/search/get_book_list", post)
        .then((res) => {
          this.files = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getFilePath(item) {
      let path = item.file_acu_path;
      let fullpath =  path.slice(1);
      return fullpath;
    },
  },
};
</script>
