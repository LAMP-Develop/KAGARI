<template>
<div class="ad container">
  <!-- <h2>広告</h2>
  <ul>
    <li>今期間</li>
    <li>広告費用：{{data.cv[0][0]}}</li>
    <li>広告クリック：{{data.cv[0][1]}}</li>
    <li>コンバージョン：{{data.cv[0][2]}}</li>
  </ul>
  <ul>
    <li>前期間</li>
    <li>広告費用：{{data.cv[1][0]}}</li>
    <li>広告クリック：{{data.cv[1][1]}}</li>
    <li>コンバージョン：{{data.cv[1][2]}}</li>
  </ul> -->
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card h-100 ">
        <div class="card-body">
          <div class="flex justifyBetween">
            <div class="adMainBox">
              <div class="iconUser iconTop">
                <i class="fas fa-yen-sign"></i>
              </div>
              <p class="card-title textCenter fourteen">広告費用</p>
              <p class="card-text textCenter nowNumber bold">¥{{mathRound(data.cv[0][0], 1)}}</p>
              <p class="card-text textCenter preNumber mb-1"><i class="fas fa-arrows-alt-h mr-1 gray"></i>¥{{mathRound(data.cv[1][0], 1)}}</p>
              <p v-if="Number(data.cv[0][0]) >= Number(data.cv[1][0])" class="card-text textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(data.cv[0][0], data.cv[1][0])}}%</p>
              <p v-else class="card-text textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(data.cv[0][0], data.cv[1][0])}}%</p>
            </div>
            <div class="equal">
              <p class="blue"><i class="fas fa-equals"></i></p>
            </div>
            <div>
              <div class="adBox center textCenter">
                <p class="fourteen mb-2">クリック単価</p>
                <p class="twenty bold mb-2">¥{{clickCosts}}</p>
                <div class="flex">
                  <p class="fourteen flex mr-2 gray"><i class="fas fa-arrows-alt-h mr-1"></i>¥{{pastClickCost}}</p>
                  <p v-if="clickCosts >= pastClickCost" class="fourteen comRateUp">▲{{comparRate(clickCosts, pastClickCost)}}%</p>
                  <p v-else class="fourteen comRateDown">▼{{comparRate(clickCosts, pastClickCost)}}%</p>
                </div>
              </div>
              <div class="textCenter blue">
                <p><i class="fas fa-times"></i></p>
              </div>
              <div class="adBox center textCenter">
                <p class="fourteen mb-2">クリック数</p>
                <p class="twenty bold mb-2">¥{{data.cv[0][1]}}</p>
                <div class="flex">
                  <p class="fourteen flex gray"><i class="fas fa-arrows-alt-h mr-1"></i>¥{{data.cv[1][1]}}</p>
                  <p v-if="data.cv[0][1] >= data.cv[1][1]" class="fourteen comRateUp">▲{{comparRate(data.cv[0][1],data.cv[1][1])}}%</p>
                  <p v-else class="fourteen comRateDown">▼{{comparRate(data.cv[0][1],data.cv[1][1])}}%</p>
                </div>
              </div>
            </div>
          </div>
          <p class="card-text borderTop my-3"></p>
          <p class="card-text cardExp">期間中に１回以上のセッションを開始したユーザー数。</p>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card h-100">
        <div class="card-body">
          <div class="flex justifyBetween">
            <div class="adMainBox">
              <div class="iconBr iconTop">
                <i class="fas fa-yen-sign"></i>
              </div>
              <p class="card-title textCenter fourteen">コンバージョン単価</p>
              <p class="card-text textCenter nowNumber bold">¥{{cvCost}}</p>
              <p class="card-text textCenter preNumber mb-1"><i class="fas fa-arrows-alt-h mr-1 gray"></i>¥{{pastCvCost}}</p>
              <p v-if="cvCost >= pastCvCost" class="card-text textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(cvCost, pastCvCost)}}%</p>
              <p v-else class="card-text textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(cvCost, pastCvCost)}}%</p>
            </div>
            <div class="equal">
              <p class="purple"><i class="fas fa-equals"></i></p>
            </div>
            <div>
              <div class="adBoxClick center textCenter">
                <p class="fourteen mb-2">コンバージョン数</p>
                <p class="twenty bold mb-2">{{data.cv[0][2]}}</p>
                <div class="flex">
                  <p class="fourteen flex mr-2 gray"><i class="fas fa-arrows-alt-h mr-1"></i>{{data.cv[1][2]}}</p>
                  <p v-if="data.cv[0][2] >= data.cv[1][2]" class="fourteen comRateUp">▲{{comparRate(data.cv[0][2],data.cv[1][2])}}%</p>
                  <p v-else class="fourteen comRateDown">▼{{comparRate(data.cv[0][2],data.cv[1][2])}}%</p>
                </div>
              </div>
              <div class="textCenter purple">
                <p><i class="fas fa-divide"></i></p>
              </div>
              <div class="adBoxClick center textCenter">
                <p class="fourteen mb-2">広告費用</p>
                <p class="twenty bold mb-2">{{mathRound(data.cv[0][0], 1)}}</p>
                <div class="flex">
                  <p class="fourteen flex gray"><i class="fas fa-arrows-alt-h mr-1"></i>¥{{mathRound(data.cv[1][0], 1)}}</p>
                  <p v-if="data.cv[0][0] >= data.cv[1][0]" class="fourteen comRateUp">▲{{comparRate(data.cv[0][0],data.cv[1][0])}}%</p>
                  <p v-else class="fourteen comRateDown">▼{{comparRate(data.cv[0][0],data.cv[1][0])}}%</p>
                </div>
              </div>
            </div>
          </div>
          <p class="card-text borderTop my-3"></p>
          <p class="card-text cardExp">期間中に１回以上のセッションを開始したユーザー数。</p>
        </div>
      </div>
    </div>
  </div>
  <table class="table table-striped" style="table-layout:fixed;">
    <thead>
      <tr class="textCenter fourteen">
        <th style="width:16%"></th>
        <th style="width:14%" class="normal">
          <div class="iconUser">
            <i class="fas fa-mouse-pointer marginIcon"></i>
          </div>
          クリック数
        </th>
        <th style="width:14%" class="normal">
          <div class="iconBr">
            <i class="fas fa-yen-sign marginIcon"></i>
          </div>
          費用
        </th>
        <th style="width:14%" class="normal">
          <div class="iconPs">
            <i class="fas fa-yen-sign marginIcon"></i>
          </div>
          クリック単価
        </th>
        <th style="width:14%" class="normal">
          <div class="iconAveSs">
            <i class="fas fa-bolt marginIcon"></i>
          </div>
          セッション数
        </th>
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
          コンバージョン率
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(report,index) in data.cvReport" class="fourteen">
        <td class="textLeft wordBreak">{{ report[0][0][0][0] }}</td>
        <td class="textRight">
          {{ report[0][0][1] }}
          <span v-if="index===0" v-bind:style="{width:styleMax}" class="barAgeMax mb-1"></span>
          <span v-else v-bind:style="{width:stylesClick[index]}" class="barAge mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][1] >= report[1][0][1]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][1],report[1][0][1])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][1],report[1][0][1])}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][2], 1) }}
          <span v-bind:style="{width:stylesCost[index]}" class="barCountry mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][2] >= report[1][0][2]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][2],report[1][0][2])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][2],report[1][0][2])}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{clickCost(report[0][0][2],report[0][0][1])}}
          <span v-bind:style="{width:stylesCc[index]}" class="barAge mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="clickCost(report[0][0][2],report[0][0][1]) >= clickCost(report[1][0][2],report[1][0][1])" class="textCenter comRateUp tewlve"><span
                class="mr-1">▲</span>{{comparRate(clickCost(report[0][0][2],report[0][0][1]),clickCost(report[1][0][2],report[1][0][1]))}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(clickCost(report[0][0][2],report[0][0][1]),clickCost(report[1][0][2],report[1][0][1]))}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][3], 1) }}
          <span v-bind:style="{width:stylesSs[index]}" class="barTime mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][3] >= report[1][0][3]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][3],report[1][0][3])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][3],report[1][0][3])}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][4], 1) }}
          <span v-bind:style="{width:stylesCv[index]}" class="barSs mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][4] >= report[1][0][4]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][4],report[1][0][4])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][4],report[1][0][4])}}%</p>
          </div>
        </td>
        <td class="textRight">
          {{ mathRound(report[0][0][5], 1) }}
          <span v-bind:style="{width:stylesCvr[index]}" class="barCity mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="report[0][0][5] >= report[1][0][5]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(report[0][0][5],report[1][0][5])}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(report[0][0][5],report[1][0][5])}}%</p>
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
      stylesClick: {},
      stylesCost: {},
      stylesClickCost: {},
      stylesSs: {},
      stylesCv: {},
      stylesCvr: {},
      stylesCc: {},
      styleMax: "100%",
      cvCost: '',
      pastCvCost: '',
      clickCosts: '',
      pastClickCost: ''
    }
  },
  mounted() {
    axios.get('/api/ad')
      .then((res) => {
        this.data = res.data,
          console.log(this.data.cv, this.data.cvReport);
        this.makeArraySs(),
          this.makeArrayCv(),
          this.makeArrayCvr(),
          this.makeArrayCost(),
          this.widthClick(),
          this.makeArrayClickCost(),
          this.calCvCost(),
          this.clickCostAd()
      })
      .catch(error => {
        console.log(error);
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
    calCvCost: function() {
      var result = this.mathRound(Number(this.data.cv[0][0]) / Number(this.data.cv[0][2]), 1);
      var pastResult = this.mathRound(Number(this.data.cv[1][0]) / Number(this.data.cv[1][2]), 1);
      this.cvCost = result;
      this.pastCvCost = pastResult;
    },
    clickCost: function(cost,click) {
      var result = this.mathRound(Number(cost) / Number(click), 1);
      return result;
    },
    clickCostAd: function() {
      var result = this.mathRound(Number(this.data.cv[0][0]) / Number(this.data.cv[0][1]), 1);
      var pastResult = this.mathRound(Number(this.data.cv[1][0]) / Number(this.data.cv[1][1]), 1);
      this.clickCosts = result;
      this.pastClickCost = pastResult;
    },
    widthClick: function() {
      var maxNumber = this.data.cvReport[0][0][0][1];
      var w_arry = {};
      for (var i = 1; i < 10; i++) {
        var number = this.data.cvReport[i][0][0][1];
        var width = this.calRate(number, maxNumber);
        w_arry[i] = width;
      }
      this.stylesClick = w_arry;
    },
    makeArrayCv: function() {
      var cvArray = [];
      var cvArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.data.cvReport[i][0][0][4];
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
        var a = this.mathRound(this.data.cvReport[i][0][0][5], 1);
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
    makeArrayClickCost: function() {
      var ccArray = [];
      var ccArrays = {};
      for (var i = 0; i < 10; i++) {
        var cost = this.mathRound(this.data.cvReport[i][0][0][2], 1);
        var click = this.data.cvReport[i][0][0][1];
        var cc = this.mathRound(cost / click, 1);
        ccArrays[i] = cc;
        ccArray.push(cc);
      }
      var maxCc = Math.max.apply(null, ccArray);
      var w_arry = {};
      for (var i = 0; i < 10; i++) {
        var number = ccArrays[i];
        var width = this.calRate(number, maxCc);
        w_arry[i] = width;
      }
      this.stylesCc = w_arry;
    },
    makeArrayCost: function() {
      var brArray = [];
      var brArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.data.cvReport[i][0][0][2];
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
      this.stylesCost = w_arry;
    },
    makeArraySs: function() {
      var psArray = [];
      var psArrays = {};
      for (var i = 0; i < 10; i++) {
        var a = this.data.cvReport[i][0][0][3];
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
      this.stylesSs = w_arry;
    }
  }
}
</script>
