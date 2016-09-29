<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;

//use App\Models\ACL;

class TestController extends Controller
{

    /**
     * @Route('/testtest')
     * @Name('test.index')
     */
    public function test()
    {

        $app = \Yee\Yee::getInstance();

        $db = $app->db['cassandra'];

        $data = array(
            'comment'   =>  'update works',
            "languages" => $_SESSION['language']
        );

//        $getResult = $db->getOne('users');

        //$getResult = $db->where('username', 'andreas113')->getOne('users');


        /*
        $cluster = Cassandra::cluster()                 // connects to localhost by default
                ->withContactPoints('192.168.100.200')
                ->build();
        $keyspace = 'hrsystem';
        $session = $cluster->connect($keyspace);

        for ($i = 0; $i <= 10; $i++) {

            $statement = $session->prepare('INSERT INTO users (username, comment) VALUES (?, ?)');

            $session->execute($statement, new Cassandra\ExecutionOptions(array(
                'arguments' => array('email' . $i . '.com', 'comment' . $i)
            )));
        }

        $statement = new Cassandra\SimpleStatement(// also supports prepared and batch statements
                'SELECT * FROM users'
        );
        $future = $session->executeAsync($statement);
        $result = $future->get();                      // wait for the result, with an optional timeout

        foreach ($result as $row) {                       // results and rows implement Iterator, Countable and ArrayAccess
            echo $row['username'] . ' - ' . $row['comment'];
        }
        */
    }
}