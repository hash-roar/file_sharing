<template>
  <v-card>
    <v-list dense>
      <!-- 主页设置 -->
      <v-list-item link disabled>
        <v-list-item-action>
          <v-icon>mdi-home</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Home</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <!-- 联系 -->
      <v-list-item link @click.stop="dialog = true">
        <v-list-item-action>
          <v-icon>mdi-email</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Contact</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <!-- 对话框 -->
      <v-dialog v-model="dialog" max-width="350">
        <v-card>
          <v-card-title class="headline">Email</v-card-title>

          <v-card-text> 1022647354@qq.com(报告bug请找我) </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialog = false">
              close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <!-- 搜书 -->
      <v-list-item href="/index/search/index">
        <v-list-item-action>
          <v-icon>mdi-magnify</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>search books</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-card>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
  }),
};
</script>