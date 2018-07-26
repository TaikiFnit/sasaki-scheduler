<?php
use Migrations\AbstractSeed;

/**
 * User seed.
 */
class UserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => '佐々木淳',
                'grade' => 'T',
                'email' => 'jsasaki@iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '高木正則',
                'grade' => 'T',
                'email' => 'takagi-m@iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '山田敬三',
                'grade' => 'T',
                'email' => 'k-yamada@iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '平野竜',
                'grade' => 'M2',
                'email' => 'g231p019@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '加藤弘祐',
                'grade' => 'M1',
                'email' => 'g231q011@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '菅野祐馬',
                'grade' => 'M1',
                'email' => 'g231q012@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '小笠原柚子',
                'grade' => 'B4',
                'email' => 'g031n033@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '佐々木優',
                'grade' => 'B4',
                'email' => 'g031n068@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '小菅李音',
                'grade' => 'B4',
                'email' => 'g031n057@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '佐藤雅希',
                'grade' => 'B4',
                'email' => 'g031n073@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '周藤祐汰',
                'grade' => 'B4',
                'email' => 'g031n091@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '塚本涼',
                'grade' => 'B4',
                'email' => 'g031n109@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '木村修太',
                'grade' => 'B4',
                'email' => 'g031n051@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '佐々木佳菜恵',
                'grade' => 'B4',
                'email' => 'g031n062@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '前島多恵子',
                'grade' => 'B4',
                'email' => 'g031n146@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '高橋郷',
                'grade' => 'B4',
                'email' => 'g031p306@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '石川晴香',
                'grade' => 'B3',
                'email' => 'g031o008@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '木津谷諒',
                'grade' => 'B3',
                'email' => 'g031o041@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '熊谷凪紗',
                'grade' => 'B3',
                'email' => 'g031o050@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '佐藤優輝',
                'grade' => 'B3',
                'email' => 'g031o070@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '下屋敷敬祐',
                'grade' => 'B3',
                'email' => 'g031o082@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '山鹿高明',
                'grade' => 'B3',
                'email' => 'g031o153@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '吉田隆雅',
                'grade' => 'B3',
                'email' => 'g031o161@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '李明昊',
                'grade' => 'B3',
                'email' => 'g031o163@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '渡辺大貴',
                'grade' => 'B3',
                'email' => 'g031o167@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => '嵯峨貴楽',
                'grade' => 'B3',
                'email' => 'g031q305@s.iwate-pu.ac.jp',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
