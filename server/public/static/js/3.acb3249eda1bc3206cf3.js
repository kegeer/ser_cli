webpackJsonp([3,5],{204:function(t,e,n){var a,i;a=n(316);var s=n(214);i=a=a||{},"object"!=typeof a.default&&"function"!=typeof a.default||(i=a=a.default),"function"==typeof i&&(i=i.options),i.render=s.render,i.staticRenderFns=s.staticRenderFns,t.exports=a},205:function(t,e){var n,a;a=n=n||{},"object"!=typeof n.default&&"function"!=typeof n.default||(a=n=n.default),"function"==typeof a&&(a=a.options),t.exports=n},214:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("main",[n("div",{staticClass:"main-left"},[n("el-menu",{staticClass:"el-menu-vertical-demo",attrs:{"default-active":"/active",router:!0}},[n("el-menu-item",{attrs:{index:"/active"}},[t._v("所有结果")])],1)],1),t._v(" "),n("div",{staticClass:"main-right"},[n("breadcrumb"),t._v(" "),n("div",{staticClass:"filters"},[n("div",{staticClass:"filter"},[t._v("\n        谱元编号\n        "),n("el-input",{directives:[{name:"model",rawName:"v-model",value:t.name,expression:"name"}],attrs:{placeholder:"请输入谱元编号"},domProps:{value:t.name},on:{input:function(e){t.name=e}}})],1),t._v(" "),n("el-button-group",{staticStyle:{display:"inline-block"}},[n("el-button",{attrs:{type:"primary",icon:"search"},on:{click:t.search}},[t._v("搜索")])],1)],1),t._v(" "),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.fetching,expression:"fetching"}],staticStyle:{width:"100%"},attrs:{data:t.results,stripe:"",border:""}},[n("el-table-column",{attrs:{prop:"id",label:"ID",width:"80"}}),t._v(" "),n("el-table-column",{attrs:{prop:"sample_id",label:"样品ID"}}),t._v(" "),n("el-table-column",{attrs:{prop:"product",label:"产品类型"}}),t._v(" "),n("el-table-column",{attrs:{prop:"major",label:"合作方"}}),t._v(" "),n("el-table-column",{attrs:{prop:"sub",label:"报告版本"}}),t._v(" "),n("el-table-column",{attrs:{prop:"created_at",label:"结果生成日期"}}),t._v(" "),n("el-table-column",{attrs:{label:"操作",width:"180"},inlineTemplate:{render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("el-button",{attrs:{type:"primary",icon:"plus",size:"mini"},on:{click:function(e){t.show(t.$index)}}}),t._v(" "),n("el-button",{attrs:{type:"warning",icon:"delete",size:"mini"},on:{click:function(e){t.askRemove(t.$index)}}})],1)},staticRenderFns:[]}})],1),t._v(" "),n("div",{staticClass:"pagination"},[n("el-pagination",{attrs:{"current-page":t.pagination.current_page,"page-size":t.pagination.per_page,layout:"total, prev, pager, next, jumper",total:t.pagination.total},on:{"current-change":t.navigate}})],1)],1)])},staticRenderFns:[]}},316:function(t,e,n){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i=n(1),s=a(i),r=n(3);e.default={data:function(){return{name:"",active:!1}},mounted:function(){this.fetch()},computed:(0,s.default)({},(0,r.mapState)({results:function(t){return t.Results.results},pagination:function(t){return t.Results.results_pagination},fetching:function(t){return t.fetching}}),{currentPage:function(){return parseInt(this.$route.query.page,10)||1}}),watch:{currentPage:"fetch"},methods:(0,s.default)({},(0,r.mapActions)(["setFetching","resultsSetData"]),{fetch:function(){var t=this;this.setFetching({fetching:!0}),this.$http.get("results?page="+this.currentPage).then(function(e){var n=e.data;t.resultsSetData({results:n.data,results_pagination:n.meta.pagination}),t.setFetching({fetching:!1})})},search:function(){console.log("search")},show:function(t){var e=this.results[t].id;this.$router.push({name:"results.show",params:{id:e}})},askRemove:function(t){var e=this,n=this.results[t];this.$confirm("确认删除记录吗？","提示",{type:"warning"}).then(function(){e.$http.delete("results/"+n.id).then(function(){e.fetch(),e.$notify({title:"成功",message:"删除成功",type:"success"})}).catch(function(t){e.$notify({title:"糟糕",message:t.response.data.messages[0],type:"error"})})})},navigate:function(t){this.$router.push({name:"results.index",query:{page:t}})}})}}});
//# sourceMappingURL=3.acb3249eda1bc3206cf3.js.map