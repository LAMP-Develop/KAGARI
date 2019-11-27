<template>
<div class="navcomp">
  <section class="mt-2">
  <div class="container">
  <div class="bd-highlight bg-white kagariBorder">
  <div class="d-flex">
  <div class="mr-auto p-2 bd-highlight top-line">
  <p class="mt-4 ml-3 sixteen bold">{{data.site_info[1]}}</p>
  <br>
  <p class="ml-3 mb-4 gray fourteen">{{data.site_info[0]}}</p>
  </div>
  <div class="p-2 bd-highlight top-line">
  <!-- <p class="mt-4 mr-3 blue fourteen" v-on:click="dataAjax">期間<span class="ml-3 gray borderBottom pointer">{{start}} 〜 {{end}}</span></p> -->
  <p class="mt-4 mr-3 blue fourteen" v-on:click="siteInfo">期間<span class="ml-3 gray borderBottom pointer">{{start}} 〜 {{end}}</span></p>
  <br>
  <p class="mr-3 mb-4 red fourteen">比較<span class="ml-3 gray borderBottom pointer">{{comStart}} 〜 {{comEnd}}</span></p>
  </div>
  </div>
  <nav class="nav top-nav">
  <p v-on:click='isActive=1' v-bind:class="[ isActive === 1 ? 'active' : '' ]" class="nav-item nav-link">
      <router-link to="/" class="router-link">
          <i class="far fa-calendar-alt mr-1"></i>サマリー
      </router-link>
  </p>
  <p v-on:click='isActive=2' v-bind:class="[ isActive === 2 ? 'active' : '' ]" class="nav-item nav-link">
      <router-link to='/user' class="router-link">
          <i class="fas fa-users mr-1"></i>ユーザー属性
      </router-link>
  </p>
  <p v-on:click='isActive=3' v-bind:class="[ isActive === 3 ? 'active' : '' ]" class="nav-item nav-link">
      <router-link to='/inflow' class="router-link">
          <i class="fas fa-project-diagram mr-1"></i>流入元分析
      </router-link>
  </p>
  <p v-on:click='isActive=4' v-bind:class="[ isActive === 4 ? 'active' : '' ]" class="nav-item nav-link">
      <router-link to='/action' class="router-link">
          <i class="fas fa-pager mr-1"></i>ユーザー行動分析
      </router-link>
  </p>
  <p v-on:click='isActive=5' v-bind:class="[ isActive === 5 ? 'active' : '' ]" class="nav-item nav-link">
      <router-link to='/conversion' class="router-link">
          <i class="fas fa-flag mr-1"></i>コンバージョン分析
      </router-link>
  </p>
  <p v-on:click='isActive=6' v-bind:class="[ isActive === 6 ? 'active' : '' ]" class="nav-item nav-link">
      <router-link to='/ad' class="router-link">
          <i class="fas fa-ad mr-1"></i>広告分析
      </router-link>
  </p>
  </nav>
  </div>
  </div>
  </section>
</div>
</template>
<script>
import EventBus from '../EventBus.js'
export default {
    data() {
        return {
          data: {},
          isActive: 1,
          start: '',
          end: '',
          comStart: '',
          comEnd: ''
        }
    },
    beforeMount(){
      this.axiosGet()
    },
    mounted() {
      this.$nextTick(function () {
      // this.siteInfo()
  })
    },
    methods: {
      siteInfo: function(){
        this.dateSet();
        var calender = {
            start: this.start,
            end: this.end,
            comStart: this.comStart,
            comEnd: this.comEnd
        };
        console.log(calender);
        EventBus.$emit('site-info', calender);
      },
      axiosGet: function(){
          axios.get('/api/nav')
              .then((res) => {
                  this.data = res.data,
                  // console.log(this.data.site_info[2]);
                  this.dateSet()
              })
              .catch(error => {
                  console.log(error);
              })
      },
      dateSet: function(){
        this.start = this.data.site_info[2];
        this.end = this.data.site_info[3];
        this.comStart = this.data.site_info[4];
        this.comEnd = this.data.site_info[5];
      },
      dataAjax: function(){
        var start = this.start;
        var end = this.end;
        var comStart = this.comStart;
        var comEnd = this.comEnd;

        var calender = new URLSearchParams();
        calender.append('start', 'start');
        calender.append('end', 'end');
        calender.append('comStart', 'comStart');
        calender.append('comEnd', 'comEnd');

        axios.post('/api/ajax',calender).then(res => {
          console.log('送信したデータ：' + response.data.calender);

        })
        .catch(error => {
            console.warn(error);
        });
      }
    }
}
</script>
