<?php
//  header("Content-type:text/html;charset=utf-8");
class db{
    //初始化对象
    function __construct(){
        $this->obj = new PDO('mysql:host=localhost;port=3306;dbname=Jnene-blog;charset=utf8','admin','zhaopeng');
    }
    //设置查询表参数，$table为字符串格式，内容是一个表名
    public function table($table){
        $this->table=$table;
        return $this;
    }
    // 设置返回结果的数量，$limit为整形,值大于1
    public function limit($limit){
        $this->limit=$limit;
        return  $this;
    }
    //设置查询条件参数，$where为字符串或数组
    public function where($where){
        $this->where=$where;//exit(var_dump($this->where));
        return $this;
    }
    // 返回一条查询结果
    public function item(){
        $sql=$this->_build_sql('select')."limit 1";
        $r=$this->obj->prepare($sql);
        $r->execute();
        $str=$r->fetchAll(PDO::FETCH_ASSOC);
        return isset($str[0])?$str[0]:false;
    }
    // 返回多条查询语句
    public function lists(){    
        $sql=$this->_build_sql('select'); 
        $sql .=isset($this->limit)?"limit $this->limit":"" ;  // exit($sql);
        $r=$this->obj->prepare($sql);
        $r->execute();
        return $r->fetchAll(PDO::FETCH_ASSOC);
    }
    //插入数据,$data为数组
    public function insert($data){
        $sql=$this->_build_sql('insert',$data); 
        $r=$this->obj->prepare($sql);
        $r->execute();
        // return $sql;
        return $this->obj->lastInsertId();

    }
    //更新数据
    public function update($data){
        $sql=$this->_build_sql('update',$data);
        $r=$this->obj->prepare($sql);
        $r->execute();
        return $r->rowCount();
    }
    //删除数据
    public function delete(){
        $sql=$this->_build_sql('delete');
        $r=$this->obj->prepare($sql);
        $r->execute();
        return $r->rowCount();
    }
    //构造sql，$classify为字符串，$data为数组
    private function _build_sql($classify,$data=null){
        if($classify == 'select'){
            //处理where条件
            $where=$this->_build_where();
            //处理order条件
            if(isset($this->order)){
                $order='order by '.$this->order.' desc';
            }else{
                $order='';
            }
            //处理查询字段
            $column = isset($this->column)?$this->column:'*';
            $sql="select {$column} from `{$this->table}` {$where} {$order}";
        }elseif($classify == 'insert'){
            $col = $val =[];
            foreach($data as $key=>$value){
                $col[]=$key;
                $val[]=is_string($value)?"'$value'":$value;
            }
            $sql = "insert into "."$this->table"."(".implode(",",$col).")values(".implode(",",$val).")";
        }elseif($classify == 'update'){
            $where=$this->_build_where();
            $str='';
            foreach($data as $key=>$val){
                $val=is_string($val)?"'$val'":$val;
                $str.="{$key}=$val,";
            }
            $str=rtrim($str,',');
            $sql="update {$this->table} set {$str} {$where}";
        }elseif($classify == 'delete'){
            $where = isset($this->where)?$this->_build_where():die('error：删除表操作请联系管理员') ;
            $sql = "delete from {$this->table} {$where}";
        }elseif($classify == 'page'){
            $where = $this->_build_where();
            $column = isset($this->column)?$this->column:'*';
            $sql = "select {$column} from {$this->table} {$where}";
        }elseif($classify == 'count'){
            $where = $this->_build_where();
            $sql = "select count(*) from {$this->table} {$where}";
        }
        return $sql;
    }
    //排序，$order为字符串，参数是一个字段，比如id,若调用该方法，则查询结果安装该字段降序排序
    public function order($order){
        $this->order=$order;
        return $this;
    }
    //设置查询字段,$column为字符串，多个字段用逗号分隔
    public function column($column){
        $this->column=$column;
        return $this;
    }
    //构造where条件
    private function _build_where(){
        if(isset($this->where)){
            $where='';
            if(is_array($this->where)){
                foreach($this->where as $key => $value){
                            $value=is_string($value)?"'$value'":$value;
                            $where .=" $key=$value and ";
                        }
            }else{
                $where=$this->where;
            }
            $where='where '.rtrim($where,'and ');
        }else{
            $where='';
        }
        return $where;
    }
    //分页查询,参数存放查询第几页和一页多少数据，$page：当前页，$page_size：页面条数,$path:路径
    public function page($page,$page_size=6,$path){
        $count=implode($this->count());
        // 判断参数是否合法
            if($page<=0 || ceil($count/$page_size)<$page){
                $page=1;
            }
        $html = $this->SubPage($count,$page_size,$page,$path);
        $page=($page-1)*$page_size;
        $sql=$this->_build_sql('page')." limit {$page},{$page_size}";
        $r=$this->obj->prepare($sql);
        $r->execute();
        $data=$r->fetchAll(PDO::FETCH_ASSOC);
        return array($count,$data,$html);
    }
    // 分页组件，$Cpage:总条数，$Ppage:页面条数，$page:当前页,$path:路径
    private function SubPage($Cpage,$Ppage,$page,$path){
        // 设置文件路径
        $system='?';
        $flag = substr_count($path,'?');
        if($flag>0){
            $system='&';
        }
        //总条数/页面条数=显示个数
        $Lpage = ceil($Cpage/$Ppage);
        if($Lpage < 2){
            return "";
        }
        // 生成页面
        $html = "";
        // 生成首页
        $html .= $page == 1?'<li class="disabled"><a>&laquo;</a></li>':'<li><a href="'.$path.$system.'page=1">&laquo;</a></li>';
        // 中间页生成
        $i=0;$max=0;
        if($Lpage>10 && $page >= 10){
            $i = $page-5;
            if($page+4<$Lpage){$max=$page+4;}else{$max=$Lpage;}
        }elseif($Lpage>10 && $page<10){
            $i=1;$max=10;
        }elseif($Lpage<=10){
            $i=1;$max=$Lpage;
        }
        for($i;$i<=$max;$i++){
            $html .= $page == $i ?'<li class="active"><a href="'.$path.$system.'page='.$i.'">'.$i.'</a></li>':'<li><a href="'.$path.$system.'page='.$i.'">'.$i.'</a></li>';
        }
        // 生成尾页
        $html .= $page == $Lpage ?'<li class="disabled"><a>&raquo;</a></li>':'<li><a href="'.$path.$system.'page='.$Lpage.'">&raquo;</a></li>';
        $html = '<nav><ul class="pagination">'.$html.'</ul></nav>';
        return $html;
    }
    // 返回查询数据的个数
    private function count(){
        // select count(*) from test_info where id>1;
        $sql = $this->_build_sql('count');
        $r = $this->obj->prepare($sql);
        $r->execute();
        return $r->fetchAll(PDO::FETCH_ASSOC)[0];
    }
}
?>