module.exports = {
  transpileDependencies: [
    'vuetify'
  ],
  publicPath:"/books/"
  ,
  devServer: {
    open: true,
    host: 'localhost',
    port: 8081,
    https: false,
    hotOnly: false,
    proxy: { // 配置跨域
      '/api': {
        //要访问的跨域的api的域名
        target: 'http://localhost:80',
        ws: true,
        changOrigin: true,
        pathRewrite: {
          '^/api': ''
        }
      }
    },
    before: app => { }
  }
}
