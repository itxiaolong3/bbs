<?php
/**
 * Created by PhpStorm.
 * User: xiaolong
 * 可以用单例模式来设计（三私一公）
 * Date: 2017/9/19
 * Time: 11:26
 */
//设置区域时间
date_default_timezone_set('Asia/Shanghai');

class MySqlDBUtil
{
    /**
     * 数据库的基本属性
     */
    private $host;//主机地址
    private $port;//端口号
    private $user;//用户名
    private $pass;//密码
    private $charset;//字符集
    private $dbname;//数据库名

    //运行时候需要的属性，用来保存链接数据库的资源
    public $link;

    private static $instance;//保存单一对象,，（一私）

    /**
     * 构造方法,对象被创建时自动调用,（二私）
     */
    private function __construct($arr)
    {
        //初始化属性值
        $this->init($arr);
        $this->my_connect();
        $this->my_dbname();
        $this->my_charset();
    }

    private function __clone()
    {
    }//(三私)

    /**
     * @param $arr （一公）
     */
    public static function getInstance($arr)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($arr);
        }
        return self::$instance;
    }

    //初始化属性值
    private function init($arr)
    {
        $this->host = isset($arr['host']) ? $arr['host'] : "localhost";
        $this->port = isset($arr['port']) ? $arr['port'] : "3306";
        $this->user = isset($arr['user']) ? $arr['user'] : "root";
        $this->pass = isset($arr['pass']) ? $arr['pass'] : "";
        $this->charset = isset($arr['charset']) ? $arr['charset'] : "utf8";
        $this->dbname = isset($arr['dbname']) ? $arr['dbname'] : "";
    }

    private function my_connect()
    {
        //如果链接成功就保存连接资源到全局变量的link中
        if ($link = @mysqli_connect("$this->host:$this->port", "$this->user", "$this->pass", "$this->dbname")) {
            $this->link = $link;
        } else {
            echo "数据库连接失败<br/>";
            echo "错误编号：", mysqli_errno($link) . "<br/>";
            echo "错误信息：", mysqli_error($link) . "<br/>";
            return false;

        }
    }

    //错误调试方法,执行sql方法
    public function my_query($sql)
    {
        $result = mysqli_query($this->link, $sql);
        if (!$result) {
            //报错信息
            echo "SQL语句执行失败！<br/>";
            echo "错误编号：", mysqli_errno($this->link), "<br/>";
            echo "错误信息：", mysqli_error($this->link), "<br/>";
            return false;
        }
        return $result;

    }

    /**
     * 返回数据集,多行多列
     */
    public function fetchAll($sql)
    {
        if ($result = $this->my_query($sql)) {
            //遍历资源结果集
            $rows = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            //释放结果集资源
            mysqli_free_result($result);
            //返回所有的数据
            return $rows;
        } else {
            return false;
        }
    }

    /**
     * 返回数据集,一行多列
     */
    public function fetchRow($sql)
    {
        //先执行sql语句
        if ($result = $this->my_query($sql)) {
            $row = mysqli_fetch_assoc($result);
            //释放结果集资源
            mysqli_free_result($result);
            //返回一条的数据
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 返回最近执行sql的影响行
     */
    public function affetchedRow($sql)
    {
        //先执行sql语句
        if ($result = $this->my_query($sql)) {
            $row = mysqli_affected_rows($this->link);
            //释放结果集资源
            @mysqli_free_result($result);
            //返回一条的数据
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 返回一行一列数据
     */
    public function fetchColum($sql)
    {
        if ($resutl = $this->my_query($sql)) {
            $colum = mysqli_fetch_row($resutl);
            //释放结果集资源
            mysqli_free_result($resutl);
            //对执行后得来的数据进行判断是否存在
            return isset($colum[0]) ? $colum[0] : false;
        } else {
            //sql执行失败
            return false;
        }
    }

    /**
     * 返回一行一列数据
     */
    public function getLastId()
    {
        return mysqli_insert_id($this->link)==0? "0":mysqli_insert_id($this->link);
    }

    //选择数据库
    private function my_dbname()
    {
        $sql = "use $this->dbname";
        $this->my_query($sql);
    }

    //设置字符集码
    private function my_charset()
    {
        $sql = "set names $this->charset";
        $this->my_query($sql);
    }

    /**
     * 析构方法，释放数据库资源
     */
    public function __destruct()
    {
        mysqli_close($this->link);
    }

    /**
     * 序列化时触发，返回一个数组
     * @return array 返回一个数组
     */
    public function __sleep()
    {
        // TODO: Implement __sleep() method.
        return array("host", "port", "user", "pass", "charset", "dbname");
    }

    /**
     * 反序列化一个对象的时候自动调用
     */
    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
        //连接数据库
        $this->my_connect();
        //选择数据库
        $this->my_dbname();
        //设置默认字符集编码
        $this->my_charset();
    }

}