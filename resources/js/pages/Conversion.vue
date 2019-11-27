<template>
<div class="conversion container">
  <!-- <div v-for="(cv,index) in data.cv">
      <p>{{cv}}</p>
    </div> -->
  <div class="row">
    <div class="col-md-3 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <div class="iconSession iconTop">
            <i class="fas fa-flag"></i>
          </div>
          <p class="card-title textCenter">コンバージョン数</p>
          <p class="card-text textCenter nowNumber bold">{{ data.cv[0][1] }}</p>
          <p class="card-text textCenter preNumber mb-1"><i class="fas fa-arrows-alt-h mr-1"></i>{{ data.cv[1][1] }}</p>
          <p v-if="Number(data.cv[0][1]) >= Number(data.cv[1][1])" class="card-text textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(data.cv[0][1], data.cv[1][1])}}%</p>
          <p v-else class="card-text textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(data.cv[0][1], data.cv[1][1])}}%</p>
          <p class="card-text borderTop my-3"></p>
          <p class="card-text cardExp">期間中に１回以上のセッションを開始したユーザー数。</p>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <div class="iconBye iconTop">
            <i class="far fa-flag"></i>
          </div>
          <p class="card-title textCenter">コンバージョン率</p>
          <p class="card-text textCenter nowNumber bold">{{ mathRound(data.cv[0][2], 1) }}</p>
          <p class="card-text textCenter preNumber mb-1"><i class="fas fa-arrows-alt-h mr-1"></i>{{ mathRound(data.cv[1][2], 1) }}</p>
          <p v-if="Number(data.cv[0][2]) >= Number(data.cv[1][2])" class="card-text textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(data.cv[0][2], data.cv[1][2])}}%</p>
          <p v-else class="card-text textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(data.cv[0][2], data.cv[1][2])}}%</p>
          <p class="card-text borderTop my-3"></p>
          <p class="card-text cardExp">期間中に１回以上のセッションを開始したユーザー数。</p>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <div class="center cvBox flex justifyBetween">
            <p class="fourteen">セッション数</p>
            <p class="twenty bold">{{data.cv[0][0]}}</p>
          </div>
          <div class="center rateBox flex justifyEnd">
            <i class="fas fa-long-arrow-alt-down"></i>
            <p>{{comparRate(siteViewNumber,data.cv[0][0])}}%</p>
          </div>
          <div class="center cvBox flex justifyBetween">
            <p class="fourteen">サイト内閲覧数</p>
            <p class="twenty bold">{{siteViewNumber}}</p>
          </div>
          <div class="center rateBox flex justifyEnd">
            <i class="fas fa-long-arrow-alt-down"></i>
            <p>{{comparRate(data.cv[0][1],siteViewNumber)}}%</p>
          </div>
          <div class="center cvBox flex justifyBetween">
            <p class="fourteen">コンバージョン数</p>
            <p class="twenty bold">{{data.cv[0][1]}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <table class="table table-striped" style="table-layout:fixed;">
    <thead>
      <tr class="textCenter fourteen">
        <th style="width:16%"></th>
        <th style="width:14%" class="normal">
          <div class="iconSession">
            <i class="fas fa-flag marginIcon"></i>
          </div>
          コンバージョン<br>数
        </th>
        <th style="width:14%" class="normal">
          <div class="iconBye">
            <i class="far fa-flag marginIcon"></i>
          </div>
          コンバージョン<br>率
        </th>
        <th style="width:14%" class="normal">
          <div class="iconUser">
            <i class="fas fa-user marginIcon"></i>
          </div>
          ユーザー数
        </th>
        <th style="width:14%" class="normal">
          <div class="iconBr">
            <i class="fas fa-arrow-alt-circle-left marginIcon"></i>
          </div>
          直帰率
        </th>
        <th style="width:14%" class="normal">
          <div class="iconPs">
            <i class="fas fa-pager marginIcon"></i>
          </div>
          ページ<br>/セッション
        </th>
        <th style="width:14%" class="normal">
          <div class="iconAveSs">
            <i class="fas fa-clock marginIcon"></i>
          </div>
          平均<br>セッション時間
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(report,index) in data.cvReport" class="fourteen">
        <td class="textLeft wordBreak">{{ report[0][0][0][0] }}</td>
        <td class="textRight">
          {{ report[0][0][1] }}
          <span v-bind:style="{width:stylesCv[index]}" class="barSs mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][1] >= report[1][0][1]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][1],report[1][0][1])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][1],report[1][0][1])}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][2], 1) }}
          <span v-bind:style="{width:stylesCvr[index]}" class="barCity mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][2] >= report[1][0][2]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(report[0][0][2], 1),mathRound(report[1][0][2], 1))}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(report[0][0][2], 1),mathRound(report[1][0][2], 1))}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ report[0][0][3] }}
          <span v-if="index===0" v-bind:style="{width:styleMax}" class="barAgeMax mb-1"></span>
          <span v-else v-bind:style="{width:stylesUser[index]}" class="barAge mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][3] >= report[1][0][3]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][3],report[1][0][3])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][3],report[1][0][3])}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][4], 1) }}
          <span v-bind:style="{width:stylesBr[index]}" class="barCountry mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][4] >= report[1][0][4]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(report[0][0][4], 1),mathRound(report[1][0][4], 1))}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(report[0][0][4], 1),mathRound(report[1][0][4], 1))}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][5], 1) }}
          <span v-bind:style="{width:stylesPs[index]}" class="barPs mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][5] >= report[1][0][5]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(report[0][0][5], 1),mathRound(report[1][0][5], 1))}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(report[0][0][5], 1),mathRound(report[1][0][5], 1))}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][6], 1) }}
          <span v-bind:style="{width:stylesTime[index]}" class="barTimeMax mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][6] >= report[1][0][6]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(report[0][0][6], 1),mathRound(report[1][0][6], 1))}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(report[0][0][6], 1),mathRound(report[1][0][6], 1))}}%</p>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <section>
    <div class="commentArea kagariBorder bottom1Rem flex">
      <div class="iconComment iconTop">
        <i class="fas fa-comment-dots"></i>
      </div>
      <div class="commentTextArea">
        <h6 class="dark-gray sixteen bold">コメントの見出し</h6>
        <textarea placeholder="コメントを入力" style="border:none;"></textarea>
      </div>
    </div>
  </section>
</div>
</template>
<script>
export default {
  data() {
    return {
      data: {},
      styleMax: '100%',
      stylesCv: {},
      stylesBr: {},
      stylesTime: {},
      stylesUser: {},
      stylesPs: {},
      stylesCvr: {},
      siteViewNumber: ''
    }
  },
  created() {
    axios.get('/api/conversion')
      .then((res) => {
        this.data = res.data,
        this.siteView(),
        this.makeArrayCv(),
          this.makeArrayCvr(),
          this.makeArrayBr(),
          this.makeArrayPs(),
          this.makeArrayTime(),
          this.widthUser()
      })
      .catch(error => {
        console.error(error);
      })
  },
  methods: {
    calRate: function(number, maxNumber) {
      var resultNumber = (number / maxNumber) * 100;
      var _pow = Math.pow(10, 1);
      var result = Math.round(resultNumber * _pow) / _pow;
      var width = result + '%';
      return width;
    },
    mathRound: function(number, n) {
      var _pow = Math.pow(10, n);
      return Math.round(number * _pow) / _pow;
    },
    comparRate: function(numberNow, numberPast) {
      if (numberPast == 0 || numberNow == 0) {
        var result = '-';
      } else {
        var result = this.mathRound(
          (Number(numberNow) / Number(numberPast) - 1) * 100,
          1);
      }
      return result;
    },
    siteView: function(){
      var bRate = this.data.cv[0][3] / 100;
      var result = this.mathRound(this.data.cv[0][0] * bRate, 1);
      this.siteViewNumber =  result;
    },
    widthUser: function() {
      var maxNumber = this.data.cvReport[0][0][0][3];
      var w_arry = {};
      for (var i = 1; i < 10; i++) {
        var number = this.data.cvReport[i][0][0][3];
        var width = this.calRate(number, maxNumber);
        w_arry[i] = width;
      }
      this.stylesUser = w_arry;
    },
    makeArrayCv: function() {
      var cvArray = [];
      var cvArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.data.cvReport[i][0][0][1];
        cvArrays[i] = a;
        cvArray.push(a);
      }
      var maxCv = Math.max.apply(null, cvArray);
      var w_arry = {};
      for (var i = 0; i < 10; i++) {
        var number = cvArrays[i];
        var width = this.calRate(number, maxCv);
        w_arry[i] = width;
      }
      this.stylesCv = w_arry;
    },
    makeArrayCvr: function() {
      var cvrArray = [];
      var cvrArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.mathRound(this.data.cvReport[i][0][0][2], 1);
        cvrArrays[i] = a;
        cvrArray.push(a);
      }
      var maxCvr = Math.max.apply(null, cvrArray);
      var w_arry = {};
      for (var i = 0; i < 10; i++) {
        var number = cvrArrays[i];
        var width = this.calRate(number, maxCvr);
        w_arry[i] = width;
      }
      this.stylesCvr = w_arry;
    },
    makeArrayBr: function() {
      var brArray = [];
      var brArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.mathRound(this.data.cvReport[i][0][0][4], 1);
        brArrays[i] = a;
        brArray.push(a);
      }
      var maxBr = Math.max.apply(null, brArray);
      var w_arry = {};
      for (var i = 0; i < 10; i++) {
        var number = brArrays[i];
        var width = this.calRate(number, maxBr);
        w_arry[i] = width;
      }
      this.stylesBr = w_arry;
    },
    makeArrayPs: function() {
      var psArray = [];
      var psArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.mathRound(this.data.cvReport[i][0][0][5], 1);
        psArrays[i] = a;
        psArray.push(a);
      }
      var maxPs = Math.max.apply(null, psArray);
      var w_arry = {};
      for (var i = 0; i < 10; i++) {
        var number = psArrays[i];
        var width = this.calRate(number, maxPs);
        w_arry[i] = width;
      }
      this.stylesPs = w_arry;
    },
    makeArrayTime: function() {
      var timeArray = [];
      var timeArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.mathRound(this.data.cvReport[i][0][0][6], 1);
        timeArrays[i] = a;
        timeArray.push(a);
      }
      var maxTime = Math.max.apply(null, timeArray);
      var w_arry = {};
      for (var i = 0; i < 10; i++) {
        var number = timeArrays[i];
        var width = this.calRate(number, maxTime);
        w_arry[i] = width;
      }
      this.stylesTime = w_arry;
    },
  }
}
</script>
