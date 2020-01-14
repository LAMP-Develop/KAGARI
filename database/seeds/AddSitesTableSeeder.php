<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddSitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('add_sites')->insert([
          ['VIEW_ID' => 181324669,'url' => 'https://hamaya-kyoto.com','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => '株式会社ハマヤ 公式サイト','user_id' => 1,'trial_at' => null,'created_at' => '2019-08-30 01:19:07','updated_at' => '2019-08-30 01:19:07','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 113784847,'url' => 'https://www.saneicraft.com/','category' => '7','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'サンエイクラフト 公式サイト','user_id' => 1,'trial_at' => null,'created_at' => '2019-08-30 01:38:37','updated_at' => '2019-08-30 01:38:37','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 87585672,'url' => 'https://watari-tax.com/','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => '渡利裕亮税理士事務所','user_id' => 1,'trial_at' => null,'created_at' => '2019-11-01 12:26:26','updated_at' => '2019-11-01 12:26:26','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 125366511,'url' => 'https://kredo.jp','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'Kredo','user_id' => 2,'trial_at' => null,'created_at' => '2019-09-04 01:31:15','updated_at' => '2019-10-05 00:01:29','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 186790459,'url' => 'https://ranking-chatlady.com','category' => '1','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'チャットレディ','user_id' => 3,'trial_at' => null,'created_at' => '2019-09-10 07:58:05','updated_at' => '2019-09-10 07:58:05','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 194083959,'url' => 'https://media.mk-group.co.jp','category' => '1','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'MKメディア','user_id' => 4,'trial_at' => null,'created_at' => '2019-09-10 08:09:27','updated_at' => '2019-09-10 08:09:27','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 182059237,'url' => 'https://walldeco.net','category' => '6','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'walldeco','user_id' => 5,'trial_at' => null,'created_at' => '2019-09-10 08:19:17','updated_at' => '2019-09-10 08:19:17','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 182729555,'url' => 'http://www.kitchen-up.jp','category' => '6','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'キッチンアップ','user_id' => 5,'trial_at' => null,'created_at' => '2019-09-10 08:19:58','updated_at' => '2019-09-10 08:19:58','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 62313699,'url' => 'https://www.honyakuctr.com','category' => '7','industry' => '0','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'HCコーポレイトサイト','user_id' => 6,'trial_at' => null,'created_at' => '2019-09-11 06:26:39','updated_at' => '2019-10-21 00:12:18','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 78869945,'url' => 'https://www.housefreedom.co.jp','category' => '2','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'ハウスフリーダム','user_id' => 7,'trial_at' => null,'created_at' => '2019-09-13 08:09:53','updated_at' => '2019-09-13 08:09:53','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 123331317,'url' => 'https://hittobito.com','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'ひっとびと','user_id' => 8,'trial_at' => null,'created_at' => '2019-10-21 12:09:20','updated_at' => '2019-10-21 12:09:20','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 108636807,'url' => 'http://fablabyamaguchi.com','category' => '7','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'ファブラボ山口','user_id' => 9,'trial_at' => null,'created_at' => '2019-10-24 19:26:34','updated_at' => '2019-10-25 10:12:20','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 200902526,'url' => 'http://tomoehagi.jp/','category' => '7','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'ともえ','user_id' => 9,'trial_at' => null,'created_at' => '2019-10-24 19:30:09','updated_at' => '2019-10-25 10:12:20','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 204686242,'url' => 'https://e-hatsumeijuku.techno-producer.com/shanai_gijutumarke','category' => '10','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'IPランドスケープ(特許情報分析)を用いた技術マーケティング 社内セミナー│TechnoProducer株式会社','user_id' => 10,'trial_at' => null,'created_at' => '2019-10-25 17:17:27','updated_at' => '2019-10-25 17:17:27','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 98463695,'url' => 'https://yuko-ltd.com/','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => '武田鍼灸整骨院','user_id' => 11,'trial_at' => null,'created_at' => '2019-11-14 13:03:26','updated_at' => '2019-11-14 13:03:26','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 186826468,'url' => 'https://total-care.net/','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'トータルヘルスケア','user_id' => 11,'trial_at' => null,'created_at' => '2019-11-14 14:01:22','updated_at' => '2019-11-14 14:01:22','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 198241833,'url' => 'https://9696.co.jp','category' => '6','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'クラウンクラウンメインサイト','user_id' => 12,'trial_at' => null,'created_at' => '2019-11-15 07:56:22','updated_at' => '2019-11-15 07:56:22','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 69845651,'url' => 'https://unaginomikawa.com','category' => '8','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'うなぎの三河','user_id' => 13,'trial_at' => null,'created_at' => '2019-11-19 16:09:26','updated_at' => '2019-11-19 16:09:26','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 110969973,'url' => 'http://www.nakachuu.co.jp','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => '株式会社中忠商店','user_id' => 14,'trial_at' => null,'created_at' => '2019-11-28 17:06:08','updated_at' => '2019-11-28 17:06:08','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 2725060,'url' => 'https://www.bedroom.co.jp','category' => '6','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'ビーナスベッド','user_id' => 15,'trial_at' => null,'created_at' => '2019-11-28 18:33:47','updated_at' => '2019-11-28 18:33:47','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 176753782,'url' => 'https://coin-with.com','category' => '1','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'CoinWith','user_id' => 16,'trial_at' => null,'created_at' => '2019-11-28 18:36:12','updated_at' => '2019-11-28 18:36:12','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 44325084,'url' => 'https://www.chilchinbito-hiroba.jp','category' => '2','industry' => '23','plan' => '1','plan_created_at' => null,'payment_methods' => null,'site_name' => 'チルチンびと広場','user_id' => 17,'trial_at' => null,'created_at' => '2019-12-28 02:16:14','updated_at' => '2019-12-28 02:55:54','send_flag' => 0,'comparison_flag' => 0,'logo_path' => ''],
          ['VIEW_ID' => 193386568,'url' => 'http://www.kominka.life/','category' => '2','industry' => '23','plan' => '0','plan_created_at' => null,'payment_methods' => null,'site_name' => 'チルチンびと古民家の会','user_id' => 17,'trial_at' => null,'created_at' => '2019-12-28 02:21:39','updated_at' => '2019-12-28 02:21:39','send_flag' => 0,'comparison_flag' => 0,'logo_path' => '']
        ]);
    }
}