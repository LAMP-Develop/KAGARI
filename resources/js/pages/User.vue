<template>
<div class="user container">
  <section>
    <div class="row mb-5">
      <div class="col-md-4">
        <div class="card bottom1Rem">
          <div class="card-body">
            <div class="iconAveSs iconTop">
              <i class="fas fa-user-plus"></i>
            </div>
            <p class="card-title textCenter fourteen">新規ユーザー</p>
            <div class="card-text doughnutChart">
              <DoughnutChartUser :chart-data="datacollectionUser" :options="optionsUser" :width="150" :height="150"></DoughnutChartUser>
            </div>
            <div class="flex justifyCenter">
              <div class="newUser textCenter mr-3">
                <i class="fas fa-user-plus newUserColor"></i>
                <p class="fourteen dark-gray mb-1">新規ユーザー</p>
                <p class="dark-gray bold mb-1">{{newUser}}%</p>
                <p v-if=" newUser >= pastNewUser " class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(newUser,pastNewUser)}}%</p>
                <p v-else class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(newUser,pastNewUser)}}%</p>
              </div>
              <div class="returnUser textCenter ml-3">
                <i class="fas fa-user returnUserColor"></i>
                <p class="fourteen dark-gray mb-1">既存ユーザー</p>
                <p class="dark-gray bold mb-1">{{returnUser}}%</p>
                <p v-if="returnUser >= pastReturnUser" class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(returnUser,pastReturnUser)}}%</p>
                <p v-else class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(returnUser,pastReturnUser)}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem">
          <div class="card-body">
            <div class="iconSession iconTop">
              <i class="fas fa-venus-mars"></i>
            </div>
            <p class="card-title textCenter">性別</p>
            <div class="card-text doughnutChart">
              <DoughnutChartSex :chart-data="datacollectionSex" :options="optionsSex" :width="150" :height="150"></DoughnutChartSex>
            </div>
            <div class="flex justifyCenter">
              <div class="newUser textCenter mr-3">
                <i class="fas fa-male blue"></i>
                <p class="fourteen dark-gray mb-1">男性</p>
                <p class="dark-gray bold mb-1">{{male}}%</p>
                <p v-if="male >= pastMale" class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(male,pastMale)}}%</p>
                <p v-else class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(male,pastMale)}}%</p>
              </div>
              <div class="returnUser textCenter ml-3">
                <i class="fas fa-female red"></i>
                <p class="fourteen dark-gray mb-1">女性</p>
                <p class="dark-gray bold mb-1">{{female}}%</p>
                <p v-if="female >= pastFemale" class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(female,pastFemale)}}%</p>
                <p v-else class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(female,pastFemale)}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem">
          <div class="card-body">
            <div class="iconUser iconTop">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <p class="card-title textCenter">デバイス</p>
            <div class="card-text doughnutChart">
              <DoughnutChartDevice :chart-data="datacollectionDevice" :options="optionsDevice" :width="150" :height="150"></DoughnutChartDevice>
            </div>
            <div class="flex justifyCenter">
              <div class="newUser textCenter mr-3">
                <i class="fas fa-mobile-alt blue"></i>
                <p class="tewlve dark-gray mb-1">モバイル</p>
                <p class="dark-gray bold mb-1">{{mobile}}%</p>
                <p v-if="mobile >= pastMobile" class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(mobile,pastMobile)}}%</p>
                <p v-else class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(mobile,pastMobile)}}%</p>
              </div>
              <div class="returnUser textCenter ml-3 mr-3">
                <i class="fas fa-desktop pcColor"></i>
                <p class="tewlve dark-gray mb-1">PC</p>
                <p class="dark-gray bold mb-1">{{pc}}%</p>
                <p v-if="pc >= pastPc" class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(pc,pastPc)}}%</p>
                <p v-else class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(pc,pastPc)}}%</p>
              </div>
              <div class="returnUser textCenter ml-3">
                <i class="fas fa-tablet-alt mobileColor"></i>
                <p class="tewlve dark-gray mb-1">タブレット</p>
                <p class="dark-gray bold mb-1">{{tablet}}%</p>
                <p v-if="tablet >= pastTablet" class="textCenter comRateUp"><span class="mr-1">▲</span>{{comparRate(tablet,pastTablet)}}%</p>
                <p class="textCenter comRateDown"><span class="mr-1">▼</span>{{comparRate(tablet,pastTablet)}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem h-100">
          <div class="card-body">
            <div class="iconUser iconTop">
              <i class="fas fa-user"></i>
            </div>
            <p class="card-title textCenter">年齢</p>
            <div v-for="(age,index) in data.userTypes[2]">
              <div class="flex justifyBetween mb-1">
                <p class="fourteen black">{{ age[0] }}</p>
                <p class="eighteen black bold">{{ age[1] }}</p>
              </div>
              <span v-if="index===0" v-bind:style="{width:styleMax}" class="barAgeMax mb-1"></span>
              <span v-else v-bind:style="{width:stylesAge[index]}" class="barAge mb-1"></span>
              <div class="flex justifyEnd mb-2">
                <p v-if="Number(age[1]) > Number(age[2])" class="textCenter comRateUp fourteen"><span class="mr-1">▲</span>{{comparRate(age[1],age[2])}}%</p>
                <p v-else class="textCenter comRateDown fourteen"><span class="mr-1">▼</span>{{comparRate(age[1],age[2])}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem h-100">
          <div class="card-body">
            <div class="iconBr iconTop">
              <i class="fas fa-globe-asia"></i>
            </div>
            <p class="card-title textCenter">国</p>
            <div v-for="(country,index) in data.userTypes[0]">
              <div class="flex justifyBetween mb-1">
                <p class="fourteen black">{{ country[0] }}</p>
                <p class="eighteen black bold">{{ country[1] }}</p>
              </div>
              <span v-if="index===0" v-bind:style="{width:styleMax}" class="barCountryMax mb-1"></span>
              <span v-else v-bind:style="{width:stylesCountry[index]}" class="barCountry mb-1"></span>
              <div class="flex justifyEnd mb-2">
                <p v-if="Number(country[1]) > Number(country[2])" class="textCenter comRateUp fourteen"><span class="mr-1">▲</span>{{comparRate(country[1],country[2])}}%</p>
                <p v-else class="textCenter comRateDown fourteen"><span class="mr-1">▼</span>{{comparRate(country[1],country[2])}}%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bottom1Rem h-100">
          <div class="card-body">
            <div class="iconBye iconTop">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <p class="card-title textCenter dark-gray">地域</p>
            <div v-for="(city,index) in data.userTypes[1]">
              <div class="flex justifyBetween mb-1">
                <p class="fourteen black">{{ city[0] }}</p>
                <p class="eighteen black bold">{{ city[1] }}</p>
              </div>
              <span v-if="index===0" v-bind:style="{width:styleMax}" class="barCityMax mb-1"></span>
              <span v-else v-bind:style="{width:stylesCity[index]}" class="barCity mb-1"></span>
              <div class="flex justifyEnd mb-2">
                <p v-if="Number(city[1]) > Number(city[2])" class="textCenter comRateUp fourteen"><span class="mr-1">▲</span>{{comparRate(city[1],city[2])}}%</p>
                <p v-else class="textCenter comRateDown fourteen"><span class="mr-1">▼</span>{{comparRate(city[1],city[2])}}%</p>
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
  <!-- <div class="country graphBox">
        <h2>Country</h2>
        <div v-for="(country,index) in data.user[3]">
            <p>{{ country[0] }}:{{ country[1] }}</p>
            <span v-if="index===0" v-bind:style="{width:styleMax}" class="barCountry"></span>
            <span v-else v-bind:style="{width:stylesCountry[index]}" class="barCountry"></span>
            <p>前期間：{{country[2]}}</p>
        </div>
    </div>
    <div class="city graphBox">
        <h2>City</h2>
        <div v-for="(city,index) in data.user[4]">
            <p>{{ city[0] }}:{{ city[1] }}</p>
            <span v-if="index===0" v-bind:style="{width:styleMax}" class="barCity"></span>
            <span v-else v-bind:style="{width:stylesCity[index]}" class="barCity"></span>
        </div>
    </div>
    <div class="age graphBox">
        <h2>Age</h2>
        <div v-for="(age,index) in data.user[1]">
            <p>{{ age[0] }}:{{ age[1] }}</p>
            <span v-if="index===0" v-bind:style="{width:styleMax}" class="barAge"></span>
            <span v-else v-bind:style="{width:stylesAge[index]}" class="barAge"></span>
        </div>
</div>
    <div class="gender graphBox">
        <h2>Gender</h2>
        <DoughnutChartSex :chart-data="datacollectionSex" :options="optionsSex" :width="150" :height="150"></DoughnutChartSex>
    </div>
    <div class="device graphBox">
        <h2>Deivce</h2>
        <DoughnutChartDevice :chart-data="datacollectionDevice" :options="optionsDevice" :width="150" :height="150"></DoughnutChartDevice>
    </div>
    <div class="userType graphBox">
      <h2>UserType</h2>
      <DoughnutChartUser :chart-data="datacollectionUser" :options="optionsUser" :width="150" :height="150"></DoughnutChartUser>
    </div> -->
</div>
</template>
<script>
import DoughnutChartSex from '../chart/DoughnutChart.js'
import DoughnutChartUser from '../chart/DoughnutChart.js'
import DoughnutChartDevice from '../chart/DoughnutChart.js'

export default {
  components: {
    DoughnutChartSex,
    DoughnutChartUser,
    DoughnutChartDevice,
  },
  data() {
    return {
      datacollectionSex: {},
      datacollectionUser: {},
      datacollectionDevice: {},
      optionsSex: {},
      optionsDevice: {},
      optionsUser: {},
      data: {},
      styleMax: '100%',
      stylesCountry: {},
      stylesCity: {},
      stylesAge: {},
      newUser: '',
      pastNewUser: '',
      returnUser: '',
      pastReturnUser: '',
      male: '',
      pastMale: '',
      female: '',
      pastFemale: '',
      mobile: '',
      pastMobile: '',
      pc: '',
      pastPc: '',
      tablet: '',
      pastTablet:''
    }
  },
  created() {
    axios.get('/api/user')
      .then((res) => {
        this.data = res.data,
          console.log(this.data.userTypes);
          // ,this.data.user[2]['female'][1],this.data.user[1]['desktop'][2]
        this.setNumber(),
        this.widthCountry(),
          this.widthCity(),
          this.widthAge(),
          this.DoughnutChartDataSex(),
          this.DoughnutChartDataUser(),
          this.DoughnutChartDataDevice()
      })
      .catch(error => {
        console.error(error);
      })
  },
  methods: {
    setNumber: function(){
      var newUserRate = this.calTwoNumber(this.data.user[0]['New Visitor'][0],this.data.user[0]['Returning Visitor'][1]);
      var pastNewUserRate = this.calTwoNumber(this.data.user[0]['New Visitor'][1],this.data.user[0]['Returning Visitor'][0]);
      var returnUserRate = this.calTwoNumber(this.data.user[0]['Returning Visitor'][0],this.data.user[0]['New Visitor'][1]);
      var pastReturnUserRate = this.calTwoNumber(this.data.user[0]['Returning Visitor'][1],this.data.user[0]['New Visitor'][0]);
      var maleRate = this.calTwoNumber(this.data.user[2]['male'][0],this.data.user[2]['female'][0]);
      var pastMaleRate = this.calTwoNumber(this.data.user[2]['male'][1],this.data.user[2]['female'][1]);
      var femaleRate = this.calTwoNumber(this.data.user[2]['female'][0],this.data.user[2]['male'][0]);
      var pastFemaleRate = this.calTwoNumber(this.data.user[2]['female'][1],this.data.user[2]['male'][1]);
      var mobileRate = this.calThreeNumber(this.data.user[1]['mobile'][0],this.data.user[1]['desktop'][0],this.data.user[1]['tablet'][0]);
      var pastMobileRate = this.calThreeNumber(this.data.user[1]['mobile'][1],this.data.user[1]['desktop'][1],this.data.user[1]['tablet'][1]);
      var pcRate = this.calThreeNumber(this.data.user[1]['desktop'][0],this.data.user[1]['mobile'][0],this.data.user[1]['tablet'][0]);
      var pastPcRate = this.calThreeNumber(this.data.user[1]['desktop'][1],this.data.user[1]['mobile'][1],this.data.user[1]['tablet'][1]);
      var tabletRate = this.calThreeNumber(this.data.user[1]['tablet'][0],this.data.user[1]['mobile'][0],this.data.user[1]['desktop'][0]);
      var pastTabletRate = this.calThreeNumber(this.data.user[1]['tablet'][1],this.data.user[1]['mobile'][1],this.data.user[1]['desktop'][1]);

      this.newUser = newUserRate;
      this.pastNewUser = pastNewUserRate;
      this.returnUser = returnUserRate;
      this.pastReturnUser = pastReturnUserRate;
      this.male = maleRate;
      this.pastMale = pastMaleRate;
      this.female = pastFemaleRate;
      this.pastFemale = pastFemaleRate;
      this.mobile = mobileRate;
      this.pastMobile = pastMaleRate;
      this.pc = pcRate;
      this.pastPc = pastPcRate;
      this.tablet = tabletRate;
      this.pastTablet = pastTabletRate;
    },
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
    calTwoNumber: function(numberOne, numberTwo) {
      var sumNumber = Number(numberOne) + Number(numberTwo);
      var result = this.mathRound((Number(numberOne) / sumNumber) * 100, 1);
      return result;
    },
    calThreeNumber: function(numberOne, numberTwo, numberThree) {
      var sumNumber = Number(numberOne) + Number(numberTwo) + Number(numberThree);
      var result = this.mathRound((Number(numberOne) / sumNumber) * 100, 1);
      // console.log(result,sumNumber);
      return result;
    },
    widthCountry: function() {
      var maxNumber = this.data.userTypes[0][0][1];
      var w_arry = {};
      for (var i = 1; i < 5; i++) {
        var number = this.data.userTypes[0][i][1];
        var width = this.calRate(number, maxNumber);
        w_arry[i] = width;
      }
      this.stylesCountry = w_arry;
    },
    widthCity: function() {
      var maxNumber = this.data.userTypes[1][0][1];
      var w_arry = {};
      for (var i = 1; i < 5; i++) {
        var number = this.data.userTypes[1][i][1];
        var width = this.calRate(number, maxNumber);
        w_arry[i] = width;
      }
      this.stylesCity = w_arry;
    },
    widthAge: function() {
      var number = this.data.userTypes[2];
      var maxNumber = this.data.userTypes[2][0][1];
      var w_arry = {};
      var numberLength = number.length;
      // console.log(numberLength);
      for (var i = 1; i < numberLength; i++) {
        var number = this.data.userTypes[2][i][1];
        var width = this.calRate(number, maxNumber);
        w_arry[i] = width;
      }
      this.stylesAge = w_arry;
    },
    DoughnutChartDataSex: function() {
      var maleNumber = this.data.user[2]['male'][0];
      var femaleNumber = this.data.user[2]['female'][0];
      var sexData = [];
      sexData.push(maleNumber, femaleNumber);
      this.datacollectionSex = {
          // ラベル
          labels: ["男性", "女性"],
          // データ詳細
          datasets: [{
            data: sexData,
            backgroundColor: [
              '#007AFF',
              '#FF2D55'
            ]
          }]
        },
        this.optionsSex = {
          responsive: false,
          cutoutPercentage: 85,
          legend: {
            display: false
          }
        }
    },
    DoughnutChartDataUser: function() {
      var NewNumber = this.data.user[0]['New Visitor'][0];
      var ReturnNumber = this.data.user[0]['Returning Visitor'][1];
      var userData = [];
      userData.push(NewNumber, ReturnNumber);
      this.datacollectionUser = {
          // ラベル
          labels: ["新規ユーザー", "既存ユーザー"],
          // データ詳細
          datasets: [{
            data: userData,
            backgroundColor: [
              'rgba(255, 59, 48, 1)',
              'rgba(255, 59, 48, 0.6)'
            ]
          }]
        },
        this.optionsUser = {
          legend: {
            display: false
          },
          responsive: false,
          cutoutPercentage: 85,
        }
    },
    DoughnutChartDataDevice: function() {
      var mobileNumber = this.data.user[1]['mobile'][0];
      var pcNumber = this.data.user[1]['desktop'][0];
      var tabletNumber = this.data.user[1]['tablet'][0];
      var deviceData = [];
      deviceData.push(mobileNumber, pcNumber, tabletNumber);
      this.datacollectionDevice = {
          // ラベル
          labels: ["モバイル", "PC", "タブレット"],
          // データ詳細
          datasets: [{
            data: deviceData,
            backgroundColor: [
              '#007AFF',
              '#007AFF99',
              '#007AFF66'
            ]
          }]
        },
        this.optionsDevice = {
          responsive: false,
          cutoutPercentage: 85,
          legend: {
            display: false
          }
        }
    }
  }
}
</script>
