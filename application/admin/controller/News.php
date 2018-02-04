<?php
namespace app\admin\controller;
use datatables;

class News extends Base {
    /*
     * 新闻首页
     */
    public function index(){
        //接收数据
        $param = input('param.');
        //获取新闻分类
        $cats = config('cat.lists');
        //获取新闻数据
//        模式一
//        $news = model('News')->getNews();

        //模式二
        $whereData = [];
        $whereData['page'] = empty($param['page']) ? 1 : $param['page'];
        $whereData['size'] = empty($param['size']) ? config('paginate.list_rows') : $param['page'];

        //获取表里面的数据
        $news = model('News')->getNewsByCondition($whereData);

        return $this->fetch('',[
            'news' => $news,
            'cats' => $cats
        ]);
    }

    //datatables分页
    public function index2(){
        $param = input('param.');
        $table = 'ent_news';
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'title',  'dt' => 1 ),
            array(
                'db' => 'catid',
                'dt' => 2 ,
                'formatter' => function( $d, $cats ) {
                    return $this->getCat($d);
                }
            ),
            array( 'db' => 'image',     'dt' => 3 ),
            array(
                'db'        => 'is_position',
                'dt'        => 4,
            ),
            array(
                'db'        => 'update_time',
                'dt'        => 5,
                'formatter' => function( $d, $row ) {
                    return date( 'Y-m-d H:i:s', $d);
                }
            ),
            array(
                'db'        => 'status',
                'dt'        => 6,
            )
        );
        $sql_details = array(
            'user' => config('database.username'),
            'pass' => config('database.password'),
            'db'   => config('database.database'),
            'host' => config('database.hostname'),
        );
        $ssp = new \datatables\Ssp();
        return json_encode($ssp::simple($param,$sql_details, $table, $primaryKey, $columns));
    }

    /*
     * 新闻添加
     */
    public function add(){
        //请求方式
        if(request()->isPost()){
            //接受数据
            $data = input('post.');
            //验证数据
            $validate = validate('News');//实例化验证类
            if(!$validate->check($data)){//检测传递过来的数据
                $this->error($validate->getError());//捕获错误信息，并提示
            }
            //数据入库
            try{
                $id = model('News')->add($data);
            }catch(\Exception $e){
                return $this->result('','0','添加失败！');
            }

            if($id){
                return $this->result(['jump_url' => url('news/index')],1,'添加成功！');
            }else{
                return $this->result('','0','添加失败！');
            }
        }else{
            return $this->fetch('',[
                'cats' => config('cat.lists')
            ]);
        }
    }

    //获取新闻分类
    public function getCat($key){
        $cats = config('cat.lists');
        return empty($cats[$key]) ? '无' : $cats[$key];
    }
}