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
        $whereData = [];
        if($catid = empty($param['catid']) ? '' : intval($param['catid'])){
            $whereData['catid'] = $catid;
        }
        $start_time = empty($param['start_time']) ? '' : $param['start_time'];
        $end_time = empty($param['end_time']) ? '' : $param['end_time'];
        if($start_time && $end_time && $start_time < $end_time){
            $whereData['create_time'] = [
                ['gt',strtotime($start_time)],
                ['lt',strtotime($end_time)]
            ];
        }
        if($keywords = empty($param['keywords']) ? '' : $param['keywords']){
            $whereData['title'] = ['like','%'.$keywords.'%'];
        }

        //获取新闻数据
//        模式一
//        $news = model('News')->getNews();

        //模式二
        $newsModel = model('News');
        $newsModel->page = empty($param['page']) ? 1 : $param['page'];
        $newsModel->size = empty($param['size']) ? config('paginate.list_rows') : $param['page'];

        //获取表里面的数据
        $news = $newsModel->getNewsByCondition($whereData);

        if(isset($param['page'])){
            unset($param['page']);
        }
        if(isset($param['click_time'])){
            unset($param['click_time']);
        }
        $query = http_build_query($param);

        return $this->fetch('',[
            'news' => $news,
            'cats' => config('cat.lists'),//获取新闻分类s
            'catid' => $catid,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'keywords' => $keywords,
            'query' => $query,
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

    //文章状态修改
    public function editStatus(){
        //接受参数
        $param = input('param.');
        if(empty($param['status']) || empty($param['id'])){
            return $this->result('',0,'缺少参数');
        }
        $code = config('code');
        if(!isset($code[$param['status']])){
            return $this->result('',0,'参数值错误');
        }

        try{
            $res = model('News')->save(['status' => $code[$param['status']]],['id' => $param['id']]);
        }catch (\Exception $e){
            return $this->result('','0',$e->getMessage());
        }

        if($res){
            return $this->result('','1','文章状态修改成功');
        }

        return $this->result('','0','文章状态修改失败');
    }

    //新闻内容展示
    public function content($id = 0){
        $content = model('News')->where(['id'=>$id])->value('content');
        return $this->fetch('',[
            'content' => $content,
        ]);
    }
}