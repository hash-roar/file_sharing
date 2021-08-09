<template>
  <div>
    <v-card class="ma-auto px-5" flat>
      <v-card-title>Login</v-card-title>
      <v-card-text>
        <v-form v-model="valid">
          <v-container class="pa-0">
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="name"
                  prepend-icon="mdi-account"
                  :rules="nameRules"
                  :counter="20"
                  label="name"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="password"
                  prepend-icon="mdi-lock"
                  :rules="nameRules"
                  :counter="20"
                  label="password"
                  required
                  :type="passShow ? 'text' : 'password'"
                  :append-icon="passShow ? 'mdi-eye' : 'mdi-eye-off'"
                  @click:append="passShow = !passShow"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
          <v-card-actions class="mt-3"
            ><v-spacer></v-spacer
            ><v-btn @click="Login">Submit</v-btn></v-card-actions
          >
        </v-form>
      </v-card-text>
      <v-snackbar
        timeout="2000"
        absolute
        bottom
        :color="snackbar.color"
        v-model="snackbar.bool"
        text
      >
        {{ snackbar.message }}
      </v-snackbar>
    </v-card>
  </div>
</template>
<script>
import { BASEURL } from "../enums/index.js";
export default {
  data: () => ({
    snackbar: {
      bool: false,
      message: "",
      color: "red",
    },
    passShow: false,
    valid: false,
    name: "",
    password: "",
    nameRules: [
      (v) => !!v || "Name is required",
      (v) => v.length <= 20 || "Name must be less than 10 characters",
    ],
  }),
  methods: {
    Login() {
      if (!this.valid) {
        this.infom("complete the form !");
        return;
      }
      let post = {
        name: this.name,
        password: this.password,
      };
      this.$axios
        .post(BASEURL + "/admin/login", post)
        .then((res) => {
          if (res.data == "success") {
            this.infom("login success!", "blue");
            this.$store.commit("setLogin");
            this.$router.push(this.$route.query.redirect);
          }else
          {
            this.infom(res.data);
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    infom(message, color = "red") {
      this.snackbar.bool = true;
      this.snackbar.message = message;
      this.snackbar.color = color;
    },
  },
};
</script>