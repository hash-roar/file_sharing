module.exports = {
  transpileDependencies: [
    'vuetify'
  ],
  devServer: {
    open: true,
    host: 'localhost',
    port: 8080,
    https: false,
    hotOnly: false,
    proxy: { // 配置跨域
      '/': {
        //要访问的跨域的api的域名
        target: 'http://localhost:80',
        ws: true,
        changOrigin: true,
        pathRewrite: {
          '^/': ''
        }
      }
    },
    before: app => { }
  }
}
