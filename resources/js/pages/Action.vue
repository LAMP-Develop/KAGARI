<template>
<div class="action container">
  <table class="table table-striped" style="table-layout:fixed;">
  <thead>
    <tr class="textCenter fourteen">
      <th style="width:16%"></th>
      <th style="width:14%" class="normal">
      <div class="iconSession">
        <i class="fas fa-bolt marginIcon"></i>
      </div>
      セッション数
      </th>
      <th style="width:14%" class="normal">
        <div class="iconPv">
          <i class="fas fa-eye marginIcon"></i>
        </div>
      PV数
      </th>
      <th style="width:14%" class="normal">
      <div class="iconPs">
        <i class="fas fa-pager marginIcon"></i>
      </div>
      ページ<br>/セッション
      </th>
      <th style="width:14%" class="normal">
      <div class="iconUser">
        <i class="fas fa-user marginIcon"></i>
      </div>
      ユーザー数
      </th>
      <th style="width:14%" class="normal">
      <div class="iconAveTime">
        <i class="far fa-clock marginIcon"></i>
      </div>
      平均<br>ページ滞在時間
      </th>
      <th style="width:14%" class="normal">
        <div class="iconBr">
          <i class="fas fa-arrow-alt-circle-left marginIcon"></i>
        </div>
      直帰率
      </th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(action,index) in data" class="fourteen">
      <td class="textLeft wordBreak">{{ action[0][0][0][0] }}</td>
      <td class="textRight">
        {{ action[0][0][1] }}
        <span v-if="index===0" v-bind:style="{width:styleMax}" class="barSsMax mb-1"></span>
        <span v-else v-bind:style="{width:stylesSs[index]}" class="barSs mb-1"></span>
        <div class="flex justifyEnd mb-2">
          <p v-if="action[0][0][1] >= action[1][0][1]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(action[0][0][1],action[1][0][1])}}%</p>
          <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(action[0][0][1],action[1][0][1])}}%</p>
        </div>
      </td>
      <td class="textRight">
        {{ action[0][0][2] }}
        <span v-bind:style="{width:stylesPv[index]}" class="barPv mb-1"></span>
        <div class="flex justifyEnd mb-2">
          <p v-if="action[0][0][2] >= action[1][0][2]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(action[0][0][2],action[1][0][2])}}%</p>
          <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(action[0][0][2],action[1][0][2])}}%</p>
        </div>
      </td>
      <td class="textRight">
        {{ mathRound(action[0][0][3],1) }}
          <span v-bind:style="{width:stylesPs[index]}" class="barPs mb-1"></span>
          <div class="flex justifyEnd mb-2">
            <p v-if="action[0][0][3] >= action[1][0][3]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(action[0][0][3],1),mathRound(action[1][0][3],1))}}%</p>
            <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(action[0][0][3],1),mathRound(action[1][0][3],1))}}%</p>
          </div>
      </td>
      <td class="textRight">
        {{ action[0][0][4] }}
        <span v-bind:style="{width:stylesUser[index]}" class="barAge mb-1"></span>
        <div class="flex justifyEnd mb-2">
          <p v-if="action[0][0][4] >= action[1][0][4]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(action[0][0][4],action[1][0][4])}}%</p>
          <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(action[0][0][4],action[1][0][4])}}%</p>
        </div>
      </td>
      <td class="textRight">
        {{ mathRound(action[0][0][5],1) }}
        <span v-bind:style="{width:stylesTime[index]}" class="barTime mb-1"></span>
        <div class="flex justifyEnd mb-2">
          <p v-if="action[0][0][5] >= action[1][0][5]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(action[0][0][5],1),mathRound(action[1][0][5],1))}}%</p>
          <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(action[0][0][5],1),mathRound(action[1][0][5],1))}}%</p>
        </div>
      </td>
      <td class="textRight">
        {{ mathRound(action[0][0][6],1) }}
        <span v-bind:style="{width:stylesBr[index]}" class="barCountry mb-1"></span>
        <div class="flex justifyEnd mb-2">
          <p v-if="action[0][0][6] >= action[1][0][6]" class="textCenter comRateUp tewlve"><span class="mr-1">▲</span>{{comparRate(mathRound(action[0][0][6],1),mathRound(action[1][0][6],1))}}%</p>
          <p v-else class="textCenter comRateDown tewlve"><span class="mr-1">▼</span>{{comparRate(mathRound(action[0][0][6],1),mathRound(action[1][0][6],1))}}%</p>
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
      <h6 class="dark-gray sixteen bold">コメント</h6>
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
            stylesSs: {},
            stylesBr: {},
            stylesTime: {},
            stylesUser: {},
            stylesPs: {},
            stylesPv: {}
        }
    },
    mounted() {
        axios.get('/api/action')
            .then((res) => {
                this.data = res.data,
                // console.log(this.data);
                this.makeArrayBr(),
                this.makeArrayTime(),
                this.makeArrayUser(),
                this.makeArrayPs(),
                this.makeArrayPv(),
                this.widthSs()
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
      mathRound: function(number, n){
          var _pow = Math.pow( 10 , n );
          return Math.round( number * _pow ) / _pow;
      },
      comparRate: function(numberNow, numberPast) {
        if(numberPast == 0 || numberNow == 0){
          var result = '-';
        }else{
          var result = this.mathRound(
            (Number(numberNow) / Number(numberPast) - 1) * 100,
            1);
        }
        return result;
      },
      widthSs: function() {
        var maxNumber = this.data[0][0][0][1];
        var w_arry = {};
        for (var i = 1; i < 10; i++) {
          var number = this.data[i][0][0][1];
          var width = this.calRate(number, maxNumber);
          w_arry[i] = width;
        }
        this.stylesSs = w_arry;
      },
      makeArrayBr: function(){
        var brArray = [];
        var brArrays ={};
         for(var i=0; i<10; i++){
           var a = this.mathRound(this.data[i][0][0][6], 1);
           brArrays[i] = a;
           brArray.push(a);
         }
        var maxBr = Math.max.apply(null,brArray);
        // console.log(maxBr);
        // console.log(brArrays);
        var w_arry = {};
        for(var i=0; i<10; i++){
          var number = brArrays[i];
          var width = this.calRate(number, maxBr);
          w_arry[i] = width;
        }
        this.stylesBr = w_arry;
      },
      makeArrayTime: function(){
        var timeArray = [];
        var timeArrays = {};
         for(var i=0; i<10; i++){
           var a = this.mathRound(this.data[i][0][0][5], 1);
           timeArrays[i] = a;
           timeArray.push(a);
         }
         var maxTime = Math.max.apply(null,timeArray);
         var w_arry = {};
         for(var i=0; i<10; i++){
           var number = timeArrays[i];
           var width = this.calRate(number, maxTime);
           w_arry[i] = width;
         }
         this.stylesTime = w_arry;
      },
      makeArrayUser: function(){
        var userArray = [];
        var userArrays = {};
         for(var i=0; i<10; i++){
           var a = this.data[i][0][0][4];
           userArrays[i] = a;
           userArray.push(a);
         }
         var maxUser = Math.max.apply(null,userArray);
         var w_arry = {};
         for(var i=0; i<10; i++){
           var number = userArrays[i];
           var width = this.calRate(number, maxUser);
           w_arry[i] = width;
         }
         this.stylesUser = w_arry;
      },
      makeArrayPs: function(){
        var psArray = [];
        var psArrays = {};
         for(var i=0; i<10; i++){
           var a = this.mathRound(this.data[i][0][0][3], 1);
           psArrays[i] = a;
           psArray.push(a);
         }
         var maxPs = Math.max.apply(null,psArray);
         var w_arry = {};
         for(var i=0; i<10; i++){
           var number = psArrays[i];
           var width = this.calRate(number, maxPs);
           w_arry[i] = width;
         }
         this.stylesPs = w_arry;
      },
      makeArrayPv: function(){
        var pvArray = [];
        var pvArrays = {};
         for(var i=0; i<10; i++){
           var a = this.mathRound(this.data[i][0][0][2], 1);
           pvArrays[i] = a;
           pvArray.push(a);
         }
         var maxPv = Math.max.apply(null,pvArray);
         var w_arry = {};
         for(var i=0; i<10; i++){
           var number = pvArrays[i];
           var width = this.calRate(number, maxPv);
           w_arry[i] = width;
         }
         this.stylesPv = w_arry;
      },
    }
}
</script>
