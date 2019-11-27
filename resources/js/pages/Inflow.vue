<template>
  <div class="container inflow">
    <section>
    <div class="row">
      <div class="col-md-4">
        <div class="card bottom1Rem">
          <div class="card-body">
            <div class="iconUser iconTop">
              <i class="fas fa-project-diagram"></i>
            </div>
            <p class="card-title textCenter">チャネル</p>
            <div v-for="(medium,index) in data.inflow[0]">
              <div class="flex justifyBetween mb-1">
                <p class="fourteen black">{{ medium[0] }}</p>
                <p class="eighteen black bold">{{ medium[1] }}</p>
              </div>
              <span v-if="index===0" v-bind:style="{width:styleMax}" class="barAgeMax mb-1"></span>
              <span v-else v-bind:style="{width:stylesChanel[index]}" class="barAge mb-1"></span>
              <div class="flex justifyEnd mb-2">
                <p v-if="medium[1] >= medium[2]" class="textCenter comRateUp fourteen"><span class="mr-1">▲</span>{{comparRate(medium[1],medium[2])}}%</p>
                <p v-else class="textCenter comRateDown fourteen"><span class="mr-1">▼</span>{{comparRate(medium[1],medium[2])}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem">
          <div class="card-body">
            <div class="iconBr iconTop">
              <i class="fas fa-retweet"></i>
            </div>
            <p class="card-title textCenter">ソーシャル</p>
            <div v-for="(social,index) in data.inflow[1]">
              <div class="flex justifyBetween mb-1">
                <p class="fourteen black">{{ social[0] }}</p>
                <p class="eighteen black bold">{{ social[1] }}</p>
              </div>
              <span v-if="index===0" v-bind:style="{width:styleMax}" class="barCountryMax mb-1"></span>
              <span v-else v-bind:style="{width:stylesSocial[index]}" class="barCountry mb-1"></span>
              <div class="flex justifyEnd mb-2">
                <p v-if="social[1] >= social[2]" class="textCenter comRateUp fourteen"><span class="mr-1">▲</span>{{comparRate(social[1],social[2])}}%</p>
                <p v-else class="textCenter comRateDown fourteen"><span class="mr-1">▼</span>{{comparRate(social[1],social[2])}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem">
          <div class="card-body">
            <div class="iconBye iconTop">
              <i class="fas fa-link"></i>
            </div>
            <p class="card-title textCenter dark-gray">他サイトのリンク</p>
            <div v-for="(referral,index) in data.inflow[2]">
              <div class="flex justifyBetween mb-1">
                <p class="fourteen black">{{ referral[0] }}</p>
                <p class="eighteen black bold">{{ referral[1] }}</p>
              </div>
              <span v-if="index===0" v-bind:style="{width:styleMax}" class="barCityMax mb-1"></span>
              <span v-else v-bind:style="{width:stylesReferral[index]}" class="barCity mb-1"></span>
              <div class="flex justifyEnd mb-2">
                <p v-if="referral[1] >= referral[2]" class="textCenter comRateUp fourteen"><span class="mr-1">▲</span>{{comparRate(referral[1],referral[2])}}%</p>
                <p v-else class="textCenter comRateDown fourteen"><span class="mr-1">▼</span>{{comparRate(referral[1],referral[2])}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
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
<!-- <h2>チャネル</h2>
  <div v-for="(medium,index) in data.inflow[0]">
    <p>{{ medium[0] }}:{{ medium[1] }}</p>
  </div>
  <h2>ソーシャル</h2>
  <div v-for="(social,index) in data.inflow[0]">
    <p>{{ social[0] }}:{{ social[1] }}</p>
  </div>
  <h2>他サイトのリンク</h2>
  <div v-for="(referral,index) in data.inflow[0]">
    <p>{{ referral[0] }}:{{ referral[1] }}</p>
  </div> -->
</template>
<script>
export default {
  data() {
    return {
      data: {},
      styleMax: '100%',
      stylesChanel: {},
      stylesSocial: {},
      stylesReferral: {}
    }
  },
  created() {
    axios.get('/api/inflow')
      .then((res) => {
        this.data = res.data,
        console.log(this.data.inflow);
        this.widthChanel(),
        this.widthSocial(),
        this.widthReferral()
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
            if(numberPast == 0 || numberNow == 0){
              var result = '-';
            }else{
              var result = this.mathRound(
                (Number(numberNow) / Number(numberPast) - 1) * 100,
                1);
            }
          return result;
        },
        widthChanel: function() {
          var number = this.data.inflow[0];
          var maxNumber = this.data.inflow[0][0][1];
          var numberLength = number.length;
          // console.log(numberLength);
          var w_arry = {};
          for (var i = 1; i < numberLength; i++) {
            var number = this.data.inflow[0][i][1];
            var width = this.calRate(number, maxNumber);
            w_arry[i] = width;
          }
          this.stylesChanel = w_arry;
        },
        widthSocial: function() {
          var number = this.data.inflow[1];
          var maxNumber = this.data.inflow[1][0][1];
          var numberLength = number.length;
          var w_arry = {};
          for (var i = 1; i < numberLength; i++) {
            var number = this.data.inflow[1][i][1];
            var width = this.calRate(number, maxNumber);
            w_arry[i] = width;
          }
          this.stylesSocial = w_arry;
        },
        widthReferral: function() {
          var maxNumber = this.data.inflow[2][0][1];
          var w_arry = {};
          for (var i = 1; i < 5; i++) {
            var number = this.data.inflow[2][i][1];
            var width = this.calRate(number, maxNumber);
            w_arry[i] = width;
          }
          this.stylesReferral = w_arry;
        }
  }
}
</script>
