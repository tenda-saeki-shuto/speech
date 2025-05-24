<?php

//独自PDOクラス
//下に使用例
//継承クラス内なら、
//$this->query("SELECT * FROM user_info_table);
//のように使える

//使用するサーバー情報からPDOを作成
class myPDO extends PDO
{
    //起動時オーバーライドして接続
    public function __construct()
    {
        //DB情報を定義
        $dbname = 'HBK';
        $host = '192.168.40.103';
        $dsn = "mysql:dbname=$dbname;host=$host";
        $user = 'tenda';
        $password = 'tenda';

        //指定のDBに接続する
        parent::__construct($dsn, $user, $password);
    }

    public function inputSQL($sql)
    {
        $result = $this->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
}

//使用例

// class UserManager extends myPDO
// {
    // //ユーザー情報一覧を取得
    // public function get_all_user_info()
    // {
    //     //ユーザー情報一覧をDBのusersテーブルから取得
    //     $result = $this->inputSQL("SELECT * FROM admin_master_table where id=2");
    //     //returnで全てのユーザーの情報を返す（表示は別）
    //     return $result;
    // }
// }

// //ログイン関連機能
// class LoginManager extends myPDO
// {
//     private $user_id = null;
//     private $is_login = false;

//     public function __construct()
//     {
//         parent::__construct();
//         if (!empty($_POST['user_id']) || !empty($_POST['login_pass'])) {
//             $user_id = $_POST['user_id'];
//            $user_info = $this->inputSQL("SELECT * FROM user_info_table WHERE user_id=$user_id");
//             if ($user_info['password'] == $_POST['password']) {
//                 $this->user_id = $user_info['user_id'];
//                 $this->is_login = true;
//             }
//         }
//     }
// }
